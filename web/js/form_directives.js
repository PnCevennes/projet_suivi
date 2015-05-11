var app = angular.module('FormDirectives');


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
            name: '@',
            inputclass: '@',
            selectedobject: '=',
            url: '@',
            initial: '=',
            reverseurl: '@',
            ngrequired: '=',
        },
        template: '<angucomplete id="{{id}}" inputclass="{{inputclass}}" pause="100" selectedobject="localselectedobject" url="{{url}}" titlefield="label" initial="localInitial"></angucomplete><input type="hidden" name="_{{name}}" ng-model="selectedobject" ng-required="ngrequired"></input>',
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
            group: '=',
            data: '=',
            errors: '=',
        },
        templateUrl: 'js/templates/form/dynform.htm',
        controller: function($scope){},
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
        templateUrl: 'js/templates/form/multi.htm',
        controller: function($scope){
            $scope.addDisabled = true;
            $scope.data = $scope.refer;
            $scope.$watch(function(){return $scope.refer;}, function(newval, oldval){
                if(newval){
                    newval.forEach(function(item){
                        $scope.add(item);
                    });
                    //$scope.data = newval;
                    if(newval.length == 0){
                        $scope.add(null);
                    }
                }
            });
            $scope.add = function(item){
                $scope.data.push(item || null);
                $scope.$watch(
                    function(){
                        return $scope.data[$scope.data.length-1]
                    },
                    function(newval){
                        if(newval){
                            $scope.addDisabled = false;
                        }
                        else{
                            $scope.addDisabled = true;
                        }
                    }
                );
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
        templateUrl: 'js/templates/form/fileinput.htm',
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
                        url: 'uploaded',
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
            id: "@",
            ngclass: "@",
            data: '=',
            refs: '=',
            model: '=',
            modifiable: '=',
        },
        template: '<input id="{{id}}" class="{{ngclass}}" type="number" ng-model="model" ng-disabled="!modifiable"/>',
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


/*
 * directive pour l'affichage simple d'un formulaire
 * params: 
 *  saveurl : l'url à laquelle seront envoyées les données
 *  schemaUrl : l'url du schéma descripteur du formulaire
 *  dataurl : url pour récupérer les données en édition
 *  data : conteneur de données (complété par les données obtenues par l'url *
 */
app.directive('simpleform', function(){
    return {
        restrict: 'A',
        scope: {
            saveUrl: '=saveurl',
            schemaUrl: '=schemaurl',
            dataUrl: '=dataurl',
            creating: '=',
            data: '='
        },
        transclude: true,
        templateUrl: 'js/templates/simpleForm.htm',
        controller: function($scope, $rootScope, configServ, dataServ, userServ, userMessages){
            $scope.errors = {};
            $scope.currentPage = 0;
            $scope.isActive = [];
            $scope.isDisabled = [];
            configServ.get('debug', function(value){
                $scope.debug = value;   
            });

            $scope.prevPage = function(){
                if($scope.currentPage > 0){
                    $scope.isActive[$scope.currentPage] = false;
                    $scope.currentPage--;
                    $scope.isActive[$scope.currentPage] = true;
                }
            };

            $scope.nextPage = function(){
                if($scope.currentPage < $scope.isActive.length-1){
                    $scope.isActive[$scope.currentPage] = false;
                    $scope.isDisabled[$scope.currentPage] = false;
                    $scope.currentPage++;
                    $scope.isActive[$scope.currentPage] = true;
                    $scope.isDisabled[$scope.currentPage] = false;
                }
            };

            $scope.setSchema = function(resp){
                $scope.schema = angular.copy(resp);
                
                // mise en place tabulation formulaire
                $scope.schema.groups.forEach(function(group){
                    $scope.isActive.push(false);
                    $scope.isDisabled.push(!$scope.dataUrl);
                    group.fields.forEach(function(field){
                        if(!field.options){
                            field.options = {};
                        }
                        field.options.readOnly = !userServ.checkLevel(field.options.editLevel || 0);
                        field.options.dismissed = !userServ.checkLevel(field.options.restrictLevel || 0);
                    });
                });
                $scope.isActive[0] = true;
                $scope.isDisabled[0] = false;

                if($scope.dataUrl){
                    dataServ.get($scope.dataUrl, $scope.setData);
                }
                else{
                    $scope.setData($scope.data || {});
                }
            };

            $scope.setData = function(resp){
                $scope.schema.groups.forEach(function(group){
                    group.fields.forEach(function(field){
                        $scope.data[field.name] = resp[field.name] || field.default || null;
                        if(field.type=='hidden' && field.options && field.options.ref=='userId' && $scope.data[field.name]==null && userServ.checkLevel(field.options.restrictLevel || 0)){
                            $scope.data[field.name] = userServ.getUser().idRole;
                        }
                    });
                });
                $scope.deleteAccess = userServ.checkLevel($scope.schema.deleteAccess);
                if(!$scope.deleteAccess && $scope.schema.deleteAccessOverride){
                    $scope.deleteAccess = userServ.isOwner($scope.data[$scope.schema.deleteAccessOverride]);
                }
                $rootScope.$broadcast('form:init', $scope.data);
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
                dataServ.forceReload = true;
                $scope.data.id = resp.id;
                $rootScope.$broadcast('form:update', $scope.data);
            }

            $scope.created = function(resp){
                dataServ.forceReload = true;
                $scope.data.id = resp.id;
                $rootScope.$broadcast('form:create', $scope.data);
            }

            $scope.error = function(resp){
                userMessages.errorMessage = 'Il y a des erreurs dans votre saisie';
                $scope.errors = angular.copy(resp);
            }

            $scope.remove = function(){
                if(confirm("Êtes vous certain de vouloir supprimer cet élément ?")){
                    dataServ.delete($scope.saveUrl, $scope.removed);
                }
            }

            $scope.removed = function(resp){
                $rootScope.$broadcast('form:delete', $scope.data);
            }

            configServ.getUrl($scope.schemaUrl, $scope.setSchema);
        }
    }
});


/*
 * directive pour la gestion des données spatiales
 * params:
 *  geom -> eq. ng-model
 *  options: options à passer tel que le type de géométrie editer
 *  origin: identifiant du point à éditer
 */
app.directive('geometry', function(){
    return {
        restrict: 'E',
        scope: {
            geom: '=',
            options: '=',
            origin: '=',
        },
        templateUrl:  'js/templates/form/geometry.htm',
        controller: function($scope, $rootScope, mapService){
            $scope.editLayer = new L.FeatureGroup();
            var current = null;

            $scope.geom = $scope.geom || [];
            /*
            $scope.$watch('geom', function(newval){
                $scope.geom.splice(0);
                $scope.geom.push(newval);
            });
            */

            mapService.map.addLayer($scope.editLayer);
 
            $scope.updateCoords = function(layer){
                $scope.geom.splice(0);
                if(layer){
                    try{
                        layer.getLatLngs().forEach(function(point){
                            $scope.geom.push([point.lng, point.lat]);
                        });
                    }
                    catch(e){
                        point = layer.getLatLng();
                        $scope.geom.push([point.lng, point.lat]);
                    }
                }
            };

            $scope.$on('$destroy', function(ev){
                mapService.map.removeControl($scope.controls);
                mapService.map.removeLayer($scope.editLayer);
                $scope.controls = null;
            });

           
            $scope.controls = new L.Control.Draw({
                edit: {featureGroup: $scope.editLayer},
                draw: {
                    circle: false,
                    rectangle: false,
                    marker: $scope.options.geometryType == 'point',
                    polyline: $scope.options.geometryType == 'linestring',
                    polygon: $scope.options.geometryType == 'polygon',
                },
            });

            mapService.map.addControl($scope.controls);


            mapService.map.on('draw:created', function(e){
                if(!current){
                    $scope.editLayer.addLayer(e.layer);
                    current = e.layer;
                    $rootScope.$apply($scope.updateCoords(current));
                }
            });

            mapService.map.on('draw:edited', function(e){
                $rootScope.$apply($scope.updateCoords(e.layers.getLayers()[0]));
            });

            mapService.map.on('draw:deleted', function(e){
                current = null;
                $rootScope.$apply($scope.updateCoords(current));
            });

            if($scope.origin){
                var layer = mapService.getMarker($scope.origin);
                $scope.updateCoords(layer);
                $scope.editLayer.addLayer(layer);
                current = layer;
            }
        },
    };
});

/*
 * datepicker
 * params:
 *  uid: id du champ
 *  date: valeur initiale format yyyy-MM-dd
 */
app.directive('datepick', function(){
    return{
        restrict:'A',
        scope: {
            uid: '@',
            date: '=',
            ngrequired: '=',
        },
        templateUrl: 'js/templates/form/datepick.htm',
        controller: function($scope){
            $scope.opened = false;
            $scope.toggle = function($event){
                $event.preventDefault();
                $event.stopPropagation();
                $scope.opened = !$scope.opened;
            };

            $scope.$watch('date', function(newval){
                try{
                    newval.setHours(12);
                    $scope.date = newval;
                }
                catch(e){
                    if(newval){
                        $scope.date = $scope.date.replace(/(\d+)-(\d+)-(\d+)/, '$3/$2/$1');
                    }
                }
            });
        }
    }
});


/**
 * Directive pour l'affichage d'un tableau de saisie rapide style feuille de calcul
 * params : 
 *  schemaurl -> url du schema descripteur du tableau
 *  data -> reference vers le dictionnaire de données du formulaire parent
 *  dataref -> champ à utiliser pour stocker les données
 *  subtitle -> Titre indicatif du formulaire
 */
app.directive('spreadsheet', function(){
    return {
        restrict: 'A',
        scope: {
            schemaUrl: '=schemaurl',
            dataRef: '=dataref',
            subTitle: '=subtitle',
            dataIn: '=data',
        },
        templateUrl: 'js/templates/form/spreadsheet.htm',
        controller: function($scope, configServ){
            var defaultLine = {};
            $scope.data = [];
            $scope.$watch(
                function(){
                    return $scope.schemaUrl;
                }, 
                function(newval){
                    if(newval){
                        configServ.getUrl(newval, $scope.setSchema);
                    }
                }
            );
            $scope.setSchema = function(schema){
                $scope.schema = schema;
                $scope.schema.fields.forEach(function(item){
                    defaultLine[item.name] = null;
                });
                var lines = [];
                for(i=0; i<20; i++){
                    lines.push(angular.copy(defaultLine));
                }
                $scope.data = lines;

                if(!$scope.dataIn[$scope.dataRef]){
                    $scope.dataIn[$scope.dataRef] = $scope.data;
                }
            };
        },
    };
});
