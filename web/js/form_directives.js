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
            inputclass: '@',
            selectedobject: '=',
            url: '@',
            initial: '=',
            reverseurl: '@'
        },
        template: '<angucomplete id="{{id}}" inputclass="{{inputclass}} pause="100" selectedobject="localselectedobject" url="{{url}}" titlefield="label" initial="localInitial">',
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
            $scope.$watch(function(){return $scope.refer;}, function(newval, oldval){
                if(newval){
                    $scope.data = newval;
                    if(newval.length == 0){
                        $scope.data.push(null);
                    }
                }
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
                        url: 'upload',
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
            class: "@",
            data: '=',
            refs: '=',
            model: '=',
            modifiable: '=',
        },
        template: '<input id="{{id}}" class="{{class}}" type="number" ng-model="model" ng-disabled="!modifiable"/>',
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
        templateUrl: 'js/templates/form/spreadsheet.htm',
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
            redirectTo: '@redirectto',
            dataUrl: '=dataurl',
            data: '='
        },
        transclude: true,
        templateUrl: 'js/templates/simpleForm.htm',
        controller: function($scope, $location, configServ, dataServ, userMessages){
            $scope.errors = {};
            $scope.setSchema = function(resp){
                $scope.schema = angular.copy(resp);
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
                    });
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
                            $scope.geom.push([point.lng, point.lat])
                        });
                    }
                    catch(e){
                        point = layer.getLatLng();
                        $scope.geom.push([point.lng, point.lat]);
                    }
                }
            }

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
                $scope.editLayer.addLayer(layer);
                current = layer;
                $scope.updateCoords(layer);
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
        },
        templateUrl: 'js/templates/form/datepick.htm',
        controller: function($scope){
            $scope.opened = false;
            $scope.toggle = function($event){
                $event.preventDefault();
                $event.stopPropagation();
                $scope.opened = !$scope.opened;
            }   
        }
    }
});
