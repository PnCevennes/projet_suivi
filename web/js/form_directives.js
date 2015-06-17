var app = angular.module('FormDirectives');


/**
 * wrapper pour la directive typeahead permettant de l'utiliser en édition
 * requete inverse au serveur pour obtenir un label lié à l'ID fourni et passage
 * label à la directive pour affichage
 * params supplémentaires:
 *  initial -> l'ID fourni
 *  reverseurl -> l'url permettant d'obtenir le label correspondant à l'ID
 */
app.directive('angucompletewrapper', function(dataServ, $http){
    return {
        restrict: 'E',
        scope: {
            inputclass: '@',
            decorated: '@',
            selectedobject: '=',
            ngBlur: '=',
            url: '@',
            initial: '=',
            reverseurl: '@',
            ngrequired: '=',
        },
        transclude: true,
        templateUrl: 'js/templates/form/autoComplete.htm',
        link: function($scope, elem){
            $scope.localselectedobject = '';
            $scope.test = function(){
                if($('#aw')[0].value == ''){
                    $scope.selectedobject = null;
                }
            };

            $scope.find = function(txt){
                if(txt){
                    return $http.get($scope.url + txt).then(function(resp){
                        return resp.data;    
                    });
                }
            };

            $scope.$watch('localselectedobject', function(newval){
                if(newval && newval.id){
                    $scope.selectedobject = newval.id;
                }
            });

            $scope.$watch('initial', function(newval){
                if(newval){
                    dataServ.get($scope.reverseurl + '/' + newval, function(resp){
                        $scope.localselectedobject = resp;
                    });
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
        controller: function($scope, userMessages){
            $scope.addDisabled = true;
            if(!$scope.refer){
                $scope.refer = [];
            }
            $scope.data = $scope.refer;
            $scope.$watch(function(){return $scope.refer;}, function(newval, oldval){
                if(newval){
                    $scope.data = $scope.refer;
                    if(newval.length == 0){
                        $scope.add(null);
                        $scope.addDisabled = true;
                    }
                    else{
                        $scope.addDisabled = false;
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
                            // protection doublons
                            if($scope.data.indexOf(newval)<$scope.data.length-1){
                                userMessages.errorMessage = "Il y a un doublon dans votre saisie !";
                                $scope.data.pop();
                            }
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
            if($scope.refer && $scope.refer.length==0){
                $scope.add(null);
            }
            else{
            //if($scope.data && $scope.data.length>0){
                $scope.addDisabled = false;
            }
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
            fileids: '=',
            options: '='
        },
        templateUrl: 'js/templates/form/fileinput.htm',
        controller: function($scope, $rootScope, $upload, dataServ, userMessages){
            var maxSize = $scope.options.maxSize || 2048000;
            if($scope.fileids == undefined){
                $scope.fileids = [];
            }
            $scope.delete_file = function(f_id){
                dataServ.delete('upload_file/'+f_id, function(resp){
                    $scope.fileids.splice($scope.fileids.indexOf(resp.id), 1);
                });
            };
            $scope.$watch('upload_file', function(){
                $scope.upload($scope.upload_file);
            });
            $scope.upload = function(files){
                angular.forEach(files, function(item){
                    var ext = item.name.slice(item.name.lastIndexOf('.')+1, item.name.length);
                    if($scope.options.accepted && $scope.options.accepted.indexOf(ext)>-1){
                        if(item.size < maxSize){
                            $scope.lock = true;
                            $upload.upload({
                                url: 'upload_file',
                                file: item,
                                })
                                .progress(function(evt){
                                    $scope.progress = parseInt(100.0 * evt.loaded / evt.total);    
                                })
                                .success(function(data){
                                    $scope.fileids.push(data.path);
                                    $scope.lock = false;
                                })
                                .error(function(data){
                                    userMessages.errorMessage = "Une erreur s'est produite durant l'envoi du fichier.";
                                    $scope.lock = false;
                                });
                        }
                        else{
                            userMessages.errorMessage = "La taille du fichier doit être inférieure à " + (maxSize/1024) + " Ko";
                        }
                    }
                    else{
                        userMessages.errorMessage = "Type d'extension refusé";
                    }
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
            ngBlur: "=",
            min: '=',
            max: '=',
            data: '=',
            refs: '=',
            model: '=',
            modifiable: '=',
        },
        template: '<input id="{{id}}" ng-blur="ngBlur" class="{{ngclass}}" type="number" min="{{min}}" max="{{max}}" ng-model="model" ng-disabled="!modifiable"/>',
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
            data: '='
        },
        transclude: true,
        templateUrl: 'js/templates/simpleForm.htm',
        controller: function($scope, $rootScope, configServ, dataServ, userServ, userMessages, $loading, $q, SpreadSheet){
            var dirty = true;
            $scope.errors = {};
            $scope.currentPage = 0;
            $scope.addSubSchema = false;
            $scope.isActive = [];
            $scope.isDisabled = [];
            configServ.get('debug', function(value){
                $scope.debug = value;   
            });
            /*
             * Spinner
             * */
            $loading.start('spinner-form');
            var dfd = $q.defer();
            var promise = dfd.promise;
            promise.then(function(result) {
                $loading.finish('spinner-form');
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
                    if($scope.schema.subSchemaAdd && userServ.checkLevel($scope.schema.subSchemaAdd)){
                        $scope.addSubSchema = true;
                    }
                    $scope.setData($scope.data || {});
                    dfd.resolve('loading form');
                }
            };

            $scope.setData = function(resp){
                $scope.schema.groups.forEach(function(group){
                    group.fields.forEach(function(field){
                        $scope.data[field.name] = angular.copy(resp[field.name]) || field.default || null;
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
                dfd.resolve('loading form');
            };

            $scope.cancel = function(){
                $rootScope.$broadcast('form:cancel', $scope.data);
            };

            $scope.save = function(){
                var errors = null;
                var confirm_save = true;
                if($scope.schema.subDataRef){
                    if(SpreadSheet.hasErrors[$scope.schema.subDataRef]){
                        errors = SpreadSheet.hasErrors[$scope.schema.subDataRef]();
                    }
                    else{
                        errors = null;
                    }
                    if(errors){
                        userMessages.errorMessage = SpreadSheet.errorMessage[$scope.schema.subDataRef];
                        var confirm_save = userMessages.confirm("Il y a des erreurs dans le sous formulaire de saisie rapide.\n\nSi vous confirmez l'enregistrement, les données du sous formulaire de saisie rapide ne seront pas enregistrées");
                    }
                }
                if(confirm_save){
                    if($scope.dataUrl){
                        dataServ.post($scope.saveUrl, $scope.data, $scope.updated, $scope.error);
                    }
                    else{
                        dataServ.put($scope.saveUrl, $scope.data, $scope.created, $scope.error);
                    }
                }
            };

            $scope.updated = function(resp){
                dataServ.forceReload = true;
                $scope.data.id = resp.id;
                dirty = false;
                $rootScope.$broadcast('form:update', $scope.data);
            }

            $scope.created = function(resp){
                dataServ.forceReload = true;
                $scope.data.id = resp.id;
                dirty = false;
                $rootScope.$broadcast('form:create', $scope.data);
            }

            $scope.error = function(resp){
                userMessages.errorMessage = 'Il y a des erreurs dans votre saisie';
                $scope.errors = angular.copy(resp);
            }

            $scope.remove = function(){
                if(userMessages.confirm("Êtes vous certain de vouloir supprimer cet élément ?")){
                    dataServ.delete($scope.saveUrl, $scope.removed);
                }
            }

            $scope.removed = function(resp){
                dirty = false;
                $rootScope.$broadcast('form:delete', $scope.data);
            }

            $scope.$on('$locationChangeStart', function(ev){
                if(!dirty){
                    return;
                }
                if(!userMessages.confirm("Etes vous certain de vouloir quitter cette page ?\n\nLes données non enregistrées pourraient être perdues.")){
                    ev.preventDefault();
                }
            });

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
app.directive('geometry', function($timeout){
    return {
        restrict: 'A',
        scope: {
            geom: '=',
            options: '=',
            origin: '=',
        },
        templateUrl:  'js/templates/form/geometry.htm',
        controller: function($scope, $rootScope, mapService){
            $scope.editLayer = new L.FeatureGroup();

            var current = null;

            var setEditLayer = function(layer){
                mapService.getLayer().removeLayer(layer);
                $scope.updateCoords(layer);
                $scope.editLayer.addLayer(layer);
                current = layer;
            };

            var coordsDisplay = null;


            if(!$scope.options.configUrl){
                $scope.configUrl = 'js/resources/defaults.json';
            }
            else{
                $scope.configUrl = $scope.options.configUrl;
            }

            mapService.initialize($scope.configUrl).then(function(){
                mapService.getLayerControl().addOverlay($scope.editLayer, "Edition");
                mapService.loadData($scope.options.dataUrl).then(function(){
                    if($scope.origin){
                        var layer = mapService.selectItem($scope.origin);
                        if(layer){
                            setEditLayer(layer);
                        }
                    }
                    mapService.getMap().addLayer($scope.editLayer);
                    mapService.getMap().removeLayer(mapService.getLayer());
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

                mapService.getMap().addControl($scope.controls);

                /*
                 * affichage coords curseur en edition 
                 * TODO confirmer le maintien
                 */
                coordsDisplay = L.control({position: 'bottomleft'});
                coordsDisplay.onAdd = function(map){
                    this._dsp = L.DomUtil.create('div', 'coords-dsp');
                    return this._dsp;
                };
                coordsDisplay.update = function(evt){
                    this._dsp.innerHTML = '<span>Long. : ' + evt.latlng.lng + '</span><span>Lat. : ' + evt.latlng.lat + '</span>';
                };

                mapService.getMap().on('mousemove', function(e){
                    coordsDisplay.update(e);
                });

                coordsDisplay.addTo(mapService.getMap());
                /*
                 * ---------------------------------------
                 */


                mapService.getMap().on('draw:created', function(e){
                    if(!current){
                        $scope.editLayer.addLayer(e.layer);
                        current = e.layer;
                        $rootScope.$apply($scope.updateCoords(current));
                    }
                });

                mapService.getMap().on('draw:edited', function(e){
                    $rootScope.$apply($scope.updateCoords(e.layers.getLayers()[0]));
                });

                mapService.getMap().on('draw:deleted', function(e){
                    current = null;
                    $rootScope.$apply($scope.updateCoords(current));
                });
                $timeout(function() {
                    mapService.getMap().invalidateSize();
                }, 0 );
            
            });

            $scope.geom = $scope.geom || [];

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


app.factory('SpreadSheet', function(){
    return {
        errorMessage: {},
        hasErrors: {},
    };
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
        controller: function($scope, configServ, SpreadSheet){
            var defaultLine = {};
            var lines = [];
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
                    defaultLine[item.name] = item.default || null;
                });
                $scope.data = lines;
                $scope.addLines();
            };

            $scope.addLines = function(){
                for(i=0; i<3; i++){
                    line = angular.copy(defaultLine);
                    lines.push(line);
                }
            };

            $scope.check = function(){
                var out = [];
                var err_lines = [];
                var primaries = [];
                var errMsg = "Erreur";
                var hasErrors = false;
                $scope.data.forEach(function(line){
                    var line_valid = true;
                    var line_empty = true;
                    $scope.schema.fields.forEach(function(field){
                        if(line[field.name] && line[field.name] != '__NULL__'){
                            line_empty = false;
                        }
                        if((field.options.required || field.options.primary) && (!line[field.name] || line[field.name] == '__NULL__')){
                            line_valid = false;
                        }
                        if(field.options.primary && line_valid){
                            //gestion des clés primaires pour la suppression des doublons
                            if(primaries.indexOf(line[field.name])>-1){
                                line_valid = false;
                                errMsg = "Doublon";
                                hasErrors = true
                            }
                            else{
                                primaries.push(line[field.name]);
                            }
                        }
                    });
                    if(line_valid){
                        out.push(line);
                    }
                    else{
                        if(!line_empty){
                            err_lines.push($scope.data.indexOf(line) + 1);
                            hasErrors = true;
                        }
                    }
                });


                if(!$scope.dataIn[$scope.dataRef]){
                    $scope.dataIn[$scope.dataRef] = [];
                }
                else{
                    $scope.dataIn[$scope.dataRef].splice(0);
                }
                out.forEach(function(item){
                    $scope.dataIn[$scope.dataRef].push(item);
                });
                if(hasErrors){
                    errMsg = 'Il y a des erreurs ligne(s) : '+err_lines.join(', ');
                    SpreadSheet.errorMessage[$scope.dataRef]= errMsg;
                }
                return hasErrors;
            };
            SpreadSheet.hasErrors[$scope.dataRef] = $scope.check;
        },
    };
});

app.directive('subeditform', function(){
    return{
        restrict: 'A',
        scope: {
            schema: "=",
            saveUrl: "=saveurl",
            refId: "=refid",
        },
        template: '<div spreadsheet schemaurl="schema" dataref="dataRef" data="data" subtitle=""></div><button type="button" class="btn btn-success" ng-click="save()">Enregistrer</button><pre>{{data|json}}</pre>',
        controller: function($scope, $rootScope, dataServ, configServ, SpreadSheet, userMessages){
            $scope.data = {refId: $scope.refId};
            $scope.dataRef = '__items__';

            $scope.save = function(){
                errors = SpreadSheet.hasErrors[$scope.dataRef]();
                if(errors){
                    userMessages.errorMessage = SpreadSheet.errorMessage[$scope.dataRef];
                }
                else{
                    dataServ.put($scope.saveUrl, $scope.data, $scope.saved);
                }
            };

            $scope.saved = function(resp){
                resp.ids.forEach(function(item, key){
                    $scope.data.__items__[key].id = item;
                });
                $rootScope.$broadcast('subEdit:dataAdded', $scope.data.__items__);
            };
        }
    };
});
