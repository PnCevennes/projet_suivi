app = angular.module('SimpleMap');


app.factory('LeafletServices', ['$http', function($http) {
    return {
      layer : {}, 
      
      loadData : function(layerdata) {
        this.layer = {};
        this.layer.name = layerdata.name;
        this.layer.active = layerdata.active;
        
        if (layerdata.type == 'xyz' || layerdata.type == 'ign') {
          if ( layerdata.type == 'ign') {
            url = 'https://gpp3-wxs.ign.fr/' + layerdata.key + '/geoportail/wmts?LAYER='+layerdata.layer+'&EXCEPTIONS=text/xml&FORMAT=image/jpeg&SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile&STYLE=normal&TILEMATRIXSET=PM&TILEMATRIX={z}&TILEROW={y}&TILECOL={x}'; 
          }
          else {
            url = layerdata.url;
          }
          this.layer.map = new L.TileLayer(url,layerdata.options);
        }
        else if (layerdata.type == 'wms') {
          this.layer.map = L.tileLayer.wms(layerdata.url,layerdata.options);
        }
        return this.layer;
      }
   };
}]);

app.factory('mapService', function(){
    return {};
});


/*
 * directive pour l'affichage et l'édition des cartes
 * params:
 *  data [obj] -> Liste des géométries 
 */
app.directive('leafletMap', function(){
    return {
        restrict: 'A',
        scope: {
            data: '=',
        },
        templateUrl: 'js/templates/display/map.htm',
        //template: '<div dw-loading="map-loading" dw-loading-options="{text: \'Chargement des données\'}" ng-options="{ text: \'\', className: \'custom-loading\', spinnerOptions: {radius:30, width:8, length: 16, color: \'#f0f\', direction: -1, speed: 3}}"></div><div id="mapd"></div>',
        controller: function($scope, $filter, $q, $rootScope, LeafletServices, mapService, configServ, dataServ, $timeout, $loading){
            /*
             */

            var map = null;
            var layer = null; 
            var tileLayers = {};
            var geoms = [];
            var currentSel = null;
            var layerControl = null;
            var resource = null;

            var initialize = function(configUrl){
                if(!configUrl){
                    configUrl = 'js/resources/defaults.json';
                }
                if(map){
                    $timeout(function() {
                        map.invalidateSize();
                    }, 0 );
                }
                var dfd = $q.defer();
                try{
                    map = L.map('mapd', {maxZoom: 17});
                    layer = L.markerClusterGroup();
                    layer.addTo(map);
                    configServ.getUrl(configUrl, function(res){
                        resource = res[0];
                        if(!resource.clustering){
                            layer.options.disableClusteringAtZoom = 13;
                        }
                        var curlayer = null;
                        configServ.get('map:currentLayer', function(_curlayer){
                            curlayer = _curlayer
                        });
                        resource.layers.baselayers.forEach(function(_layer, name){
                            var layerData = LeafletServices.loadData(_layer);
                            tileLayers[layerData.name] = layerData.map;
                            if(curlayer){
                                if(layerData.name == curlayer){
                                    layerData.map.addTo(map);
                                }
                            }
                            else{
                                if(layerData.active){
                                    layerData.map.addTo(map);
                                }
                            }
                        });
                        map.setView(
                            [resource.center.lat, resource.center.lng], 
                            resource.center.zoom);
                        layerControl = L.control.layers(tileLayers, {'Données': layer});
                        
                        layerControl.addTo(map);


                        var recenterCtrl = L.control({position: 'topleft'});
                        recenterCtrl.onAdd = function(map){
                            this._rectCtrl = L.DomUtil.create('div', 'recenterBtn');
                            this.update();
                            return this._rectCtrl;
                        }
                        recenterCtrl.update = function(){
                            this._rectCtrl.innerHTML = '<button type="button" onclick="recenter();"><span class="glyphicon glyphicon-move"></span></button>';
                        };
                        recenterCtrl.addTo(map);

                        document.recenter = function(){
                            $rootScope.$apply(
                                $rootScope.$broadcast('map:centerOnSelected')
                            );
                        }

                        /*
                         * déplacement carte récupération de la zone d'affichage
                         */
                        map.on('moveend', function(ev){
                            $rootScope.$apply(
                                $rootScope.$broadcast('mapService:pan')
                            );
                        });

                        map.on('baselayerchange', function(ev){
                            $rootScope.$apply(function(){
                                configServ.put('map:currentLayer', ev.name);
                            })
                        });



                        dfd.resolve();
                    });
                }
                catch(e){
                    layer.clearLayers();
                    geoms.splice(0);
                    dfd.resolve();
                }

                var getVisibleItems = function(){
                    var bounds = map.getBounds();
                    var visibleItems = [];
                    geoms.forEach(function(item){
                        try{
                            var _coords = item.getLatLng();
                        }
                        catch(e){
                            var _coords = item.getLatLngs();
                        }
                        try{
                            if(bounds.intersects(_coords)){
                                visibleItems.push(item.feature.properties.id);
                            }
                        }
                        catch(e){
                            if(bounds.contains(_coords)){
                                visibleItems.push(item.feature.properties.id);
                            }
                        }
                    });
                    return visibleItems;
                };
                mapService.getVisibleItems = getVisibleItems;

                var getLayerControl = function(){
                    return layerControl;
                };
                mapService.getLayerControl = getLayerControl;

                var getLayer = function(){
                    return layer;
                };
                mapService.getLayer = getLayer;

                var getMap = function(){
                    return map;
                }
                mapService.getMap = getMap;

                var getGeoms = function(){
                    return geoms;
                }
                mapService.getGeoms = getGeoms;

                var filterData = function(ids){
                    angular.forEach(geoms, function(geom){
                        if(ids.indexOf(geom.feature.properties.id) < 0){
                            geom.feature.$shown = false;
                            layer.removeLayer(geom);
                        }
                        else{
                            if(geom.feature.$shown === false){
                                geom.feature.$shown = true;
                                layer.addLayer(geom);
                            }
                        }
                    });
                };
                mapService.filterData = filterData;

                var getItem = function(_id){
                    var res = geoms.filter(function(item){
                        return item.feature.properties.id == _id;
                    });
                    if(res.length){
                        $timeout(function(){
                            try{
                                /*
                                 * centre la carte sur le point sélectionné
                                 */
                                map.setView(res[0].getLatLng(), Math.max(map.getZoom(), 13));
                            }
                            catch(e){
                                /*
                                 * centre la carte sur la figure sélectionnée
                                 */
                                map.fitBounds(res[0].getBounds());
                            }
                        }, 0);
                        return res[0];
                    }
                    return null;
                };
                mapService.getItem = getItem;

                var _set_selected = function(item, _status){
                    var iconUrl = 'js/lib/leaflet/images/marker-icon.png';
                    var polygonColor = '#03F'; 
                    var zOffset = 0;
                    if(_status){
                        iconUrl = 'js/lib/leaflet/images/marker-rouge.png';
                        polygonColor = '#F00'; 
                        zOffset = 1000;
                    }
                    try{
                        item.setIcon(L.icon({
                            iconUrl: iconUrl, 
                            shadowUrl: 'js/lib/leaflet/images/marker-shadow.png',
                            iconSize: [25, 41], 
                            iconAnchor: [13, 41],
                            popupAnchor: [0, -41],
                        }));
                        item.setZIndexOffset(zOffset);
                    }
                    catch(e){
                        item.setStyle({
                            color: polygonColor,
                        });
                    }
                };

                var selectItem = function(_id){
                    var geom = getItem(_id);
                    if(currentSel){
                        _set_selected(currentSel, false);
                    }
                    _set_selected(geom, true);
                    currentSel = geom;
                    return geom;
                };
                mapService.selectItem = selectItem;

                addGeom = function(jsonData){
                    var geom = L.GeoJSON.geometryToLayer(jsonData);
                    geom.feature = jsonData;
                    geom.on('click', function(e){
                        $rootScope.$apply(
                            $rootScope.$broadcast('mapService:itemClick', geom)    
                        );
                    });
                    if(jsonData.properties.geomLabel){
                        geom.bindPopup(jsonData.properties.geomLabel);
                    }
                    try{
                        geom.setZIndexOffset(0);
                    }
                    catch(e){}
                    geoms.push(geom);
                    layer.addLayer(geom);
                    return geom;
                };
                mapService.addGeom = addGeom;


                var loadData = function(url){
                    var defd = $q.defer();
                    $loading.start('map-loading');
                    configServ.get(url, function(resp){
                        if(resp){
                            url = resp.url;
                        }
                    });
                    dataServ.get(url, dataLoad(defd));
                    return defd.promise;
                };
                mapService.loadData = loadData;


                var dataLoad = function(deferred){
                    return function(resp){
                        if(resp.filtered){
                            resp.filtered.forEach(function(geom){
                                addGeom(geom);
                            });
                        }
                        else{
                            resp.forEach(function(geom){
                                addGeom(geom);
                            });
                        }
                        $rootScope.$broadcast('mapService:dataLoaded');
                        $loading.finish('map-loading');
                        deferred.resolve();
                    };
                };

                return dfd.promise;
            };
            mapService.initialize = initialize;

            $scope.recenter = function(){
                if(currentSel){
                    mapService.getItem(currentSel.feature.properties.id);
                }
            };

            $scope.$on('map:centerOnSelected', function(ev){
                if(currentSel){
                    mapService.getItem(currentSel.feature.properties.id);
                }
            });


            $scope.$on('$destroy', function(evt){
                if(map){
                    map.remove();
                    mapService.initialize = null;
                    geoms = [];
                }
            });
        }
    };
});

app.directive('maplist', function($rootScope, $timeout, mapService){
    return {
        restrict: 'A',
        transclude: true,
        //templateUrl: 'js/templates/display/mapList.htm',
        template: '<div><div id="mapAsFilter" class="checkbox"><label ng-show="toolBoxOpened"><input type="checkbox" ng-model="mapAsFilter" ng-click="filter()"/> filtrer avec la carte </label><span ng-class="{\'glyphicon glyphicon-chevron-left\': toolBoxOpened, \'glyphicon glyphicon-chevron-right\': !toolBoxOpened}" ng-click="toolBoxOpened = !toolBoxOpened"></span></div><ng-transclude></ng-transclude></div>',
        link: function(scope, elem, attrs){
            // récupération de l'identificateur d'événements de la liste
            var target = attrs['maplist'];
            scope.mapAsFilter = false;
            scope.toolBoxOpened = true;
            var visibleItems = [];
            /*
             * initialisation des listeners d'évenements carte 
             */
            var connect = function(){
                // click sur la carte
                scope.$on('mapService:itemClick', function(ev, item){
                    mapService.selectItem(item.feature.properties.id);
                    $rootScope.$broadcast(target + ':select', item.feature.properties);
                });

                scope.$on('mapService:pan', function(ev){
                    scope.filter();
                });

                scope.filter = function(){
                    visibleItems = mapService.getVisibleItems();
                    $rootScope.$broadcast(target + ':filterIds', visibleItems, scope.mapAsFilter);
                }

                // sélection dans la liste
                scope.$on(target + ':ngTable:ItemSelected', function(ev, item){
                    $timeout(function(){
                        try{
                            var geom = mapService.selectItem(item.id);
                            geom.openPopup();
                        }
                        catch(e){}
                    }, 0);
                });

                // filtrage de la liste
                scope.$on(target + ':ngTable:Filtered', function(ev, data){
                    ids = [];
                    data.forEach(function(item){
                        ids.push(item.id);
                    });
                    if(mapService.filterData){
                        mapService.filterData(ids);
                    }
                });
            };

            $timeout(function(){
                connect();
            }, 0);

        }
    };
});
