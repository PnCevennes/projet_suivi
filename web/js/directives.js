var app = angular.module('suiviProtocoleDirectives');


/**
 * fonction qui renvoie le label associé à un identifiant
 * paramètres : 
 *  xhrurl ->url du  service web
 *  inputid -> identifiant de l'élément
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
                if(newval){
                    dataServ.get($scope.xhrurl + '/' + newval, $scope.setResult);
                }
            });
        }
    };
});


/**
 * wrapper pour la directive angucomplete permettant de l'utiliser en édition
 * requete inverse au serveur pour obtenir un label lié à l'ID fourni et passage
 * label à la directive pour affichage
 * params supplémentaires:
 *  initial -> l'ID fourni
 *  reverseurl -> l'url permettant d'obtenir le label correspondant à l'ID
 */
app.directive('angucompletewrapper', function(dataServ){
    return {
        restrict: 'E',
        scope: {
            id: '@',
            selectedobject: '=',
            url: '@',
            initial: '=',
            reverseurl: '@'
        },
        template: '<angucomplete id="{{id}}" pause="100" selectedobject="localselectedobject" url="{{url}}" titlefield="label" initial="localInitial">',
        controller: function($scope){
            $scope.localselectedobject = {};
            $scope.$watch('initial', function(newval){
                if(newval){
                    dataServ.get($scope.reverseurl + '/' + newval, function(resp){
                        $scope.localInitial = resp.label;
                    });
                }
            });
            $scope.$watch('localselectedobject', function(newval){
                if(newval && newval.originalObject){
                    $scope.selectedobject = newval.originalObject.id;
                }
            });
        }
    };
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
                $scope.fileids = [];
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

/**
 * Directive pour l'affichage des messages utilisateur en popover
 */
app.directive('usermsg', function(userMessages, $timeout){
    return {
        restrict: 'A',
        templateUrl: 'js/templates/modalMsg.htm',
        controller: function($scope){
            $scope.hideMsg=true;
            $scope.$watch(
                function(){return userMessages.infoMessage},
                function(newval){
                    console.log(newval);
                    $scope.userMessage = newval;
                    if(newval){
                        $scope.hideMsg=false;
                        $timeout(function(){
                            $scope.hideMsg=true;
                        }, 3500);
                    }
                }
            );
        }
    };
});


/**
 * Directive pour l'affichage d'un tableau de saisie rapide style feuille de calcul
 * params : 
 *  schema -> le schema descripteur du tableau
 *  data -> la destination des données (ng-model)
 */
app.directive('spread', function(){
    return {
        restrict: 'E',
        scope: {
            schema: '=',
            data: '='
        },
        templateUrl: 'js/templates/spreadsheet.htm',
        controller: function($scope){
            var defaultLine = {};
            $scope.schema.fields.forEach(function(item){
                defaultLine[item.name] = null;
            });
            $scope.onkeyup = function(ev){

            }
            if($scope.data.length == 0){
                var lines = [];
                for(i=0; i<20; i++){
                    lines.push(angular.copy(defaultLine));
                }
                $scope.data = lines;
            }
        }
    };
});


/**
 * Directive pour l'affichage d'un element dans une fenetre modale 
 */
app.directive('modalform', function(){
    return {
        restrict: 'E',
        transclude: true,
        templateUrl: 'modalForm.htm',
        link: function($scope, elem){

        }
    }
    
});


app.directive('simpleform', function(){
    return {
        restrict: 'A',
        scope: {
            saveUrl: '=saveurl',
            schemaUrl: '=schemaurl',
            redirectTo: '@redirectto',
            dataUrl: '=dataurl',
            data: '='
        },
        transclude: true,
        templateUrl: 'js/templates/simpleForm.htm',
        controller: function($scope, $location, configServ, dataServ, userMessages){
            console.log($scope.schemaUrl);
            $scope.errors = {};
            $scope.setSchema = function(resp){
                $scope.schema = angular.copy(resp);
                if($scope.dataUrl){
                    dataServ.get($scope.dataUrl, $scope.setData);
                }
                else{
                    var tmp = {};
                    $scope.schema.forEach(function(field){
                        tmp[field.name] = field.default || null
                    });
                    $scope.setData(tmp);
                }
            };

            $scope.setData = function(resp){
                angular.forEach(resp, function(elem, key){
                    $scope.data[key]=elem;
                });
            };

            $scope.save = function(){
                if($scope.dataUrl){
                    dataServ.post($scope.saveUrl, $scope.data, $scope.updated, $scope.error);
                }
                else{
                    dataServ.put($scope.saveUrl, $scope.data, $scope.created, $scope.error);
                }
            };

            $scope.updated = function(resp){
                userMessages.infoMessage = 'Mise à jour effectuée';
                dataServ.forceReload = true;
                $location.path($scope.redirectTo + resp.id);
            }

            $scope.created = function(resp){
                userMessages.infoMessage = 'Création effectuée';
                dataServ.forceReload = true;
                $location.path($scope.redirectTo + resp.id);
            }

            $scope.error = function(resp){
                $scope.errors = angular.copy(resp);
            }

            
            configServ.getUrl($scope.schemaUrl, $scope.setSchema);
        }
    }
});
