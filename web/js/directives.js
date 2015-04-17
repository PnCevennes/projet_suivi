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
            $scope.currentPage = 0;
            $scope.$watch('schema', function(newval){
                if(newval){
                    $scope.nbPages = newval.__groups__.length;
                }
            });

            $scope.next = function(){
                if($scope.currentPage < $scope.nbPages - 1){
                    $scope.currentPage++;
                }
            }

            $scope.prev = function(){
                if($scope.currentPage > 0){
                    $scope.currentPage--;
                }
            }
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
                $scope.schema.__groups__.forEach(function(group){
                    $scope.schema[group].forEach(function(field){
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
 *  
 */
app.directive('geometry', function(){
    return {
        restrict: 'E',
        scope: {
            geom: '=',
            options: '=',
            origin: '=',
        },
        templateUrl:  'js/templates/geometry.htm',
        controller: function($scope, $rootScope, mapService){
            var editLayer = new L.FeatureGroup();

            $scope.geom = $scope.geom || [];
            var current = null;

            $scope.editLayer = editLayer;
            mapService.map.addLayer(editLayer);
 
            $scope.updateCoords = function(layer){
                $scope.geom.splice(0);
                if(layer){
                    getCoordsFromLayer(layer).forEach(function(point){
                        $scope.geom.push(point);
                    });
                }
            }

            $scope.$on('$destroy', function(ev){
                mapService.map.removeControl($scope.controls);
                mapService.map.removeLayer($scope.editLayer);
                $scope.controls = null;
            });


            var getCoordsFromLayer = function(layer){
                var coords = [];
                try{
                    layer.getLatLngs().forEach(function(point){
                        coords.push([point.lng, point.lat])
                    });
                }
                catch(e){
                    point = layer.getLatLng();
                    coords.push([point.lng, point.lat]);
                }
                return coords;
            };

            


            $scope.controls = new L.Control.Draw({
                edit: {featureGroup: editLayer},
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
                    editLayer.addLayer(e.layer);
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
