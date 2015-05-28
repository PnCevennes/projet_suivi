var app = angular.module('suiviProtocoleServices');

/**
 * Service de gestion des communications avec le serveur
 */
app.service('dataServ', function($http, $filter, userMessages){
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
            error = function(err){console.log(err)};
        }
        if(cache[url] == undefined || force || this.forceReload){
            $http.get(url)
                .then(function(data){
                    this.forceReload = false;
                    cache[url] = data.data;
                    success(data.data);
                },
                function(err){
                    switch(err.status){
                        case 500: 
                            userMessages.errorMessage = "Erreur serveur ! Si cette erreur se reproduit, contactez un administrateur.";
                            break;
                        case 404: 
                            userMessages.errorMessage = "Erreur : Donnée inexistante";
                            break;
                        case 403: 
                            userMessages.errorMessage = "Vous n'êtes pas autorisé à effectuer cette action";
                            break;
                        case 400: 
                            userMessages.errorMessage = "Données inutilisables";
                            break;
                        default: userMessages.errorMessage = "Erreur !";
                    };
                    error(err);
                }
            );
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

});


/**
 * Service de récupération et stockage des configurations
 * Utiliser pour stocker les variables globales ou les éléments de configuation de l'application
 */
app.service('configServ', function(dataServ){
    var cache = {};

    var bc = [];
    this.bcShown = true;

    this.addBc = function(lvl, label, path){
        if(bc.length>lvl){
            bc.splice(lvl, bc.length);
        }
        bc.push({label: label, url: path});
    }

    this.getBc = function(){
        return bc;
    }


    this.setBc = function(lvl){
        if(bc.length>lvl){
            bc.splice(lvl, bc.length);
        }
    }
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
 * /
app.service('mapService', function($rootScope, $filter, dataServ){
    // conteneur pour les points de la carte
    /*
    this.marks = [];

    this.map = L.map('map', {maxZoom: 20}).setView([44.34, 3.5858], 10);
    var tiles = {};
    var ctrl = L.control.layers(tiles, overlays);
    /*
    var tiles = {
        'OpenCycleMap': L.tileLayer('http://{s}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png'),
        'OpenStreetMap': L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png'),
    };
    


    this.map.addLayer(tiles['OpenCycleMap']);
    this.map.addLayer(tiles['OpenStreetMap']);
    * /

    this.setMaps = function(resp){
        /*
        resp.forEach(function(item){
            var _layer = L.tileLayer(item.url);
            tiles[item.name] = _layer;
            _layer.addTo(this.map);
        });* /
    };

    /*
    this.markLayer = new L.markerClusterGroup({disableClusteringAtZoom: 13});
    var overlays = {
        'Sites': this.markLayer,
    };
    this.map.addLayer(this.markLayer);

    ctrl.addTo(this.map);

    /*
     * ajoute un point à la carte
     *  /
    this.addPoint = function(point){
        this.markLayer.addLayer(point);
        this.marks.push(point);
    };


    /*
    * retire tous les points de la carte et n'affiche que les points dont
    * les ids sont fournis
    */
    /*
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

    dataServ.get('js/resources/maps.json', this.setMaps);
    * /

});
*/

/*
 * service utilisateur
 */
app.service('userServ', function(dataServ, $rootScope){
    var _user = {idApplication: 100}; //FIXME idApp
    var _tmp_password = '';

    this.getUser = function(){
        return _user;
    };


    this.checkLevel = function(level){
        return _user.maxdroit >= level;
    };

    this.isOwner = function(ownerId){
        return _user.idRole == ownerId;
    };

    this.login = function(login, password, app){
        _tmp_password = password;
        dataServ.post('users/login', {
            login: login, 
            pass: password, 
            idApp: app},
            this.connected,
            this.error
            );
    };

    this.logout = function(){
        dataServ.get('users/logout', 
                this.disconnected, 
                function(){}, 
                true);
    };

    this.connected = function(resp){
        _user = resp;
        _user.pass = _tmp_password;
        $rootScope.$broadcast('user:login', _user);
    };

    this.disconnected = function(resp){
        _user = {idApplication: 100}; //FIXME idApp
        $rootScope.$broadcast('user:logout');
    }

    this.error = function(resp){
        $rootScope.$broadcast('user:error');
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
        try{
            return res[0].libelle;
        }
        catch(e){
            return 'Erreur : Valeur incompatible'; //Erreur censée ne jamais arriver.
        }
    }
});

