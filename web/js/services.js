var app = angular.module('suiviProtocoleServices');


/**
 * Service de gestion des communications avec le serveur
 */
app.service('dataServ', function($http, $filter){
    //cache de données pour ne pas recharger systématiquement les données du serveur
    var cache = {};

    //flag ordonnant la recharge des données plutôt que l'utilisation du cache
    this.forceReload = false;

    /*
     * contacte le serveur en GET et met en cache les données renvoyées
     * Si les données sont déja en cache, retourne le données directement, à moins 
     * que le flag forceReload ou le paramtre "force" soient true, auquel cas le serveur
     * est recontacté et les données renvoyées écrasent le cache.
     * retourne les données via la callback success
     *
     * params:
     *  url: l'url à contacter
     *  success: la callback à utiliser pour traiter les données
     *  error: une callback appelée en cas d'erreur gérable
     *  force: flag permettant de forcer le rechargement des données plutot que l'utilisation
     *         du cache
     */
    this.get = function(url, success, error, force){
        // ne recharger les données du serveur que si le cache est vide ou 
        // si l'option force est true
        if(!error){
            error = function(err){console.log(err);}
        }
        if(cache[url] == undefined || force || this.forceReload){
            $http.get(url)
                .then(function(data){
                    this.forceReload = false;
                    cache[url] = data.data;
                    success(data.data);
                },
                error);
        }
        else{
            success(cache[url]);
        }
    };

    /*
     * contacte le serveur en POST et renvoie le résultat via la callback success
     * aucune donnée n'est mise en cache
     * params: 
     *  url: l'url à contacter
     *  data: les données POST
     *  success: la callback de traitement de la réponse du serveur
     *  error: la callback de traitement en cas d'erreur gérable
     */
    this.post = function(url, data, success, error){
        $http.post(url, data).success(success).error(error || function(err){console.log(err);});
    };

    /*
     * contacte le serveur en PUT et renvoie le résultat via la callback success
     * params:
     *  cf. this.post
     */
    this.put = function(url, data, success, error){
        $http.put(url, data).success(success).error(error || function(err){console.log(err);});
    };

    /*
     * contacte le serveur en DELETE
     * params:
     *  url: l'url à contacter
     *  success: la callback de traitement de la réponse du serveur
     *  error: la callback de traitement en cas d'erreur gérable
     */
    this.delete = function(url, success, error){
        $http.delete(url).success(success).error(error || function(err){console.log(err);});
    };
        

    // FIXME virer le reste
    this.addToCache = function(cacheName, obj){
        cache[cacheName].push(obj);
    };

    this.getFromCache = function(cacheName, path){
        var res = $filter('filter')(cache[cacheName], path, function(act, exp){return act==exp;});
        if(res){
            return res[0];
        }
        return null;
    };

    this.getCacheLength = function(cachename){
        if(cache[cachename]){
            return cache[cachename].length;
        }
        return 0;
    };
});


/**
 * Service de récupération et stockage des configurations
 * Utiliser pour stocker les variables globales ou les éléments de configuation de l'application
 */
app.service('configServ', function(dataServ){
    var cache = {};

    /*
     * charge des informations depuis une url si elles ne sont pas déja en cache
     * et les retourne via une callback. Si les variables sont déjà en cache, les 
     * retourne directement.
     * params:
     *  serv: l'url du serveur
     *  success: la callback de traitement
     */
    this.getUrl = function(serv, success){
        if(cache[serv]){
            success(cache[serv]);
        }
        else{
            dataServ.get(serv, function(resp){
                cache[serv] = resp;
                success(cache[serv]);
            });
        }
    };

    /*
     * retourne une variable globale via la callback success
     * params:
     *  key : le nom de la variable
     *  success : la callback de traitement
     */
    this.get = function(key, success){
        success(cache[key]);
    };


    /*
     * crée ou met à jour une variable globale
     * params:
     *  key : le nom de la variable
     *  data : le contenu
     */
    this.put = function(key, data){
        cache[key] = data;
    };
});


/**
 * Service de gestion de la carte leaflet
 */
app.service('mapService', function($rootScope, $filter){
    // conteneur pour les points de la carte
    this.marks = [];

    this.map = L.map('map').setView([44.34, 3.5858], 10);

    var tiles = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png');
    this.map.addLayer(tiles);

    this.markLayer = new L.markerClusterGroup({disableClusteringAtZoom: 13});
    this.map.addLayer(this.markLayer);


    /*
     * ajoute un point à la carte
     */
    this.addPoint = function(point){
        this.markLayer.addLayer(point);
        this.marks.push(point);
    };


    /*
    * retire tous les points de la carte et n'affiche que les points dont
    * les ids sont fournis
    */
    this.filterMarks = function(ids){
        this.markLayer.clearLayers();
        angular.forEach(this.marks, function(mark){
            if(ids.indexOf(mark.feature.properties.id)!=-1){
                this.markLayer.addLayer(mark);
            }
        }, this);
    };

    this.clear = function(){
        this.marks = [];
        this.markLayer.clearLayers();
    }
    
    this.getMarker = function(_id){
        var res = $filter('filter')(this.marks, {feature: {properties: {id: _id}}}, function(act, exp){return act==exp;});
        try{
            return res[0];
        }
        catch(e){
            return null;
        }
    };

});


/**
 * filtre basique - transforme une date yyyy-mm-dd en dd/mm/yyyy pour l'affichage
 * Utilisé comme un formateur de date
 */
app.filter('datefr', function(){
    return function(input){
        try{
            return input.replace(/^(\d+)-(\d+)-(\d+).*$/i, "$3/$2/$1");
        }
        catch(e){
            return input;
        }
    }
});


/**
 * Affichage du label d'une liste déroulante à partir de son identifiant
 */
app.filter('tselect', function($filter){
    return function(input, param){
        var res = $filter('filter')(input, {id: param}, function(act, exp){return act==exp;});
        console.log(res);
        try{
            return res[0].libelle;
        }
        catch(e){
            return 'Erreur : Valeur incompatible'; //Erreur censée ne jamais arriver.
        }
    }
});


/**
 * fonction qui renvoie le label associé à un identifiant
 * paramètres : 
 *  xhrurl ->url du  service web
 *  inputid -> identifiant de l'élément
 * return : label
 */
app.directive('xhrdisplay', function(){
    return {
        restrict: 'E',
        scope: {
            inputid: '=',
            xhrurl: '=',
        },
        template: '{{value}}',
        controller: function($scope, dataServ){
            $scope.setResult = function(resp){
                $scope.value = resp.label;
            };
            $scope.$watch(function(){return $scope.inputid}, function(newval, oldval){
                dataServ.post($scope.xhrurl, {id: newval}, $scope.setResult);
            });
        }
    };
});


/**
 * directive de type champ input qui permet à l'utilisateur de selectionner un élément à partir d'une recherche textuelle (autocompletion)
 * fonctions : 
 *  params :
 *      url : l'url à contacter pour obtenir les données (doit renvoyer une liste de dictionnaires {id: ?, label: ?})
 *      initial : la valeur d'initialisation (un ID)
 *      target : la donnée cible de la directive (eq. ng-model)
 *  find : interrogation du serveur 
 *      return liste identifiant
 *  select : selection d'un item dans la liste renvoyée par le serveur. Stocke cette valeur dans la propriété target
 */
app.directive('xhrinput', function(){
    return {
        restrict: 'E',
        scope: {
            url: '=',
            initial: '=',
            target: '='
        },
        templateUrl: 'js/templates/xhrinput.htm',
        controller: function($scope, dataServ){
            //FIXME
            $scope.target = angular.copy($scope.initial);
            $scope.find = function(){
                if($scope._input.length){
                    $scope.show = true;
                    dataServ.post($scope.url, {label: $scope._input}, function(resp){
                        $scope.hints = resp;
                    });
                }
                else{
                    $scope.show = false;
                }
            };
            $scope.select = function(idx){
                $scope.show = false;
                $scope._input = $scope.hints[idx].label;
                $scope.target = $scope.hints[idx].id;
            };
            dataServ.post($scope.url, {id: $scope.initial}, function(resp){
                $scope._input = resp.label;
            });
        }
    }
});


/**
 * génération automatique de formulaire à partir d'un json qui représente le schéma du formulaire
 * params:
 *  schema: le squelette du formulaire (cf. doc schémas)
 *  data: le dictionnaire de données source/cible
 *  onsave: la callback de sauvegarde du controleur
 *  onremove: la callback de suppression du controleur
 *  errors: liste d'erreurs de saisie (dictionnaire {nomChamp: errMessage})
 */
app.directive('dynform', function(){
    return {
        restrict: 'E',
        scope: {
            schema: '=',
            data: '=',
            onsave: '=',
            onremove: '=',
            errors: '=',
        },
        templateUrl: 'js/templates/dynform.htm',
        controller: function($scope){
            $scope.save = function(){
                $scope.onsave();
            };

            $scope.remove = function(){
                $scope.onremove();
            }
        },
    };
});


/**
 * génération d'un champ formulaire de type multivalué
 * params:
 *  refer: la valeur source/cible du champ (une liste)
 *  schema: le schema descripteur du champ (cf. doc schemas)
 */
app.directive('multi', function(){
    return {
        restrict: 'E',
        scope: {
            refer: '=',
            schema: '=',
        },
        templateUrl: 'js/templates/multi.htm',
        controller: function($scope){
            $scope.$watch(function(){return $scope.refer;}, function(newval, oldval){
                $scope.data = $scope.refer;
            });
            $scope.add = function(){
                $scope.data.push(null);
            };
            $scope.remove = function(idx){
                $scope.data.splice(idx, 1);
            };
        }
    }
});


/*
 * Directive qui permet d'avoir un champ de formulaire de type fichier et qui l'envoie au serveur
 * envoie un fichier au serveur qui renvoie un identifiant de création.
 * params:
 *  fileids: la valeur source/cible du champ (liste d'identifiants)
 */
app.directive('fileinput', function(){
    return {
        restrict: 'E',
        scope: {
            fileids: '='
        },
        templateUrl: 'js/templates/fileinput.htm',
        controller: function($scope, $rootScope, $upload){
            if($scope.fileids == undefined){
                scope.fileids = [];
            }
            $scope.delete_file = function(f_id){
                alert('TODO');
            };
            $scope.$watch('upload_file', function(){
                $scope.upload($scope.upload_file);
            });
            $scope.upload = function(files){
                angular.forEach(files, function(item){
                    $scope.lock = true;
                    $upload.upload({
                        url: '/upload',
                        file: item,
                        })
                        .progress(function(evt){
                            $scope.progress = parseInt(100.0 * evt.loaded / evt.total);    
                        })
                        .success(function(data){
                            $scope.fileids.push(data.id);
                            $scope.lock = false;
                        });
                });
            };
        }
    }
});


/**
 * Directive qui permet d'avoir un champ de formulaire de type valeur calculée modifiable
 * params: 
 *  data: la source de données du champ (une liste de références aux champs servant au calcul)
 *  refs: une liste du nom des champs à surveiller
 *  model: la source/cible du champ (eq. ng-model)
 *  modifiable: bool -> indique si le champ est modifiable ou en lecture seule
 */
app.directive('calculated', function(){
    return {
        restrict: 'E',
        scope: {
            data: '=',
            refs: '=',
            model: '=',
            modifiable: '=',
        },
        template: '<input type="number" ng-model="model" ng-disabled="!modifiable"/>',
        controller: function($scope){
            angular.forEach($scope.refs, function(elem){
                $scope.$watch(function(){
                    return $scope.data[elem];
                }, function(newval, oldval){
                    //$scope.model += newval-oldval;
                    //if($scope.model<0) $scope.model=0;
                    $scope.model = 0;
                    angular.forEach($scope.refs, function(elem){
                        $scope.model += $scope.data[elem];
                    }, $scope);
                });
            }, $scope);
        }
    }
});
