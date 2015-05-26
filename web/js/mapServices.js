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
 *  configUrl [str] -> url du fichier de config des fonds carto
 *  data [obj] -> Liste des géométries 
 *  editId [str] -> ID du layer à éditer
 *  editRef [obj] -> référence du champ formulaire (eq ng-model)
 *  editOptions [obj] -> options d'édition (type geom, etc.)
 */
app.directive('leafletMap', function(){
    return {
        restrict: 'A',
        scope: {
            configUrl: '@',
            data: '=',
            editId: '@',
            editRef: '=',
            editOptions: '=',
        },
        template: '<div id="mapd"></div>',
        controller: function($scope, $filter, $q, $rootScope, LeafletServices, mapService, configServ, dataServ){
            /*
             */

            var map = null;
            var layer = null; 
            var editLayer = null;
            var editControl = null;
            var tileLayers = {};
            var geoms = [];
            var currentSel = null;

            var initialize = function(){
                dfd = $q.defer();
                map = L.map('mapd');
                mapService.map = map;
                layer = L.markerClusterGroup({disableClusteringAtZoom: 13});
                layer.addTo(map);
                configServ.getUrl($scope.configUrl, function(res){
                    var resource = res[0];
                    resource.layers.baselayers.forEach(function(layer, name){
                        var layerData = LeafletServices.loadData(layer);
                        tileLayers[layerData.name] = layerData.map;
                        if(layerData.active){
                            layerData.map.addTo(map);
                        }
                    });
                    map.setView(
                        [resource.center.lat, resource.center.lng], 
                        resource.center.zoom);
                    var layerControl = L.control.layers(tileLayers, {'Données': layer});
                    if($scope.editId){
                        editLayer = new L.FeatureGroup();
                        layerControl.addOverlay(editLayer, 'Edition');
                        var editControl = new L.control.draw({
                            edit: {featureGroup: $scope.editLayer},
                            draw: {
                                circle: false,
                                rectangle: false,
                                marker: $scope.options.geometryType == 'point',
                                polyline: $scope.options.geometryType == 'linestring',
                                polygon: $scope.options.geometryType == 'polygon',
                            },
                        });
                        map.addControl(editControl);
                    }

                    layerControl.addTo(map);
                    mapService.layerControl = layerControl;
                    dfd.resolve();
                });

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
                    var res = $filter('filter')(geoms, {feature: {properties: {id: _id}}}, function(act, exp){return act==exp;});
                    try{
                        map.setView(res[0].getLatLng(), Math.max(map.getZoom(), 13));
                        return res[0];
                    }
                    catch(e){
                        return null;
                    }
                };
                mapService.getItem = getItem;


                var selectItem = function(_id){
                    console.log(_id);
                    var geom = getItem(_id);
                    console.log(geom);
                    
                    try{
                        if(currentSel){
                            currentSel.setIcon(L.icon({
                                iconUrl: 'js/lib/leaflet/images/marker-icon.png', 
                                iconSize: [25, 41], 
                                iconAnchor: [13, 41],
                                popupAnchor: [0, -41],
                            }));
                        }
                        geom.setIcon(L.icon({
                            iconUrl: 'js/lib/leaflet/images/marker-icon-rouge.png', 
                            iconSize: [25, 41], 
                            iconAnchor: [13, 41],
                            popupAnchor: [0, -41],
                        }));
                        currentSel = geom;
                        return geom;
                    }
                    catch(e){
                        return null;
                    }
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
                    geom.bindPopup('<a href="#/chiro/site/' + jsonData.properties.id + '">' + jsonData.properties.siteNom + '</a>');
                    geoms.push(geom);
                    layer.addLayer(geom);
                    return geom;
                };
                mapService.addGeom = addGeom;


                var loadData = function(url){
                    var dfd = $q.defer();
                    dataServ.get(url, dataLoad(dfd));
                    return dfd.promise;
                };
                mapService.loadData = loadData;


                var dataLoad = function(deferred){
                    return function(resp){
                        resp.forEach(function(geom){
                            addGeom(geom);
                        });
                        $rootScope.$broadcast('mapService:dataLoaded');
                        deferred.resolve();
                    };
                };
                return dfd.promise;
            };
            mapService.initialize = initialize;


            /*
            $scope.layers = {};
            if(!$scope.configUrl){
                $scope.configUrl = 'js/resources/defaults.json';
            }

            mapService.initialize($scope.configUrl);

           
            $scope.$watch('data', function(newval){
                if(newval){
                    newval.forEach(function(item){
                        mapService.addGeom(item);
                    });
                }
            });


            $scope.$on('$destroy', function(evt){
                mapService.layerReady = false;
                mapService.geoms = [];
            });
            */
        }
    };
});




/*
app.service('mapService', function($rootScope, $filter, dataServ, $q, configServ, LeafletServices){
    this.map = null;
    this.dataLayer = null;
    this.layer = null;
    this.layers = {};
    this.layerControl = null;
    this.currentSel = null;
    this.geoms = [];
    this.layerReady = false;
    this.dataLoaded = false;
    var self = this;


    this.initialize = function(configUrl, layer){
        
        var dfd = $q.defer();
        self.map = L.map('mapd');
        if(!layer){
            self.layer = L.markerClusterGroup({disableClusteringAtZoom: 13});
        }
        else{
            self.layer = layer;
        }
        self.layer.addTo(self.map);
        configServ.getUrl(configUrl, function(res){
            var resource = res[0];
            resource.layers.baselayers.forEach(function(layer, name){
                var layerData = LeafletServices.loadData(layer);
                self.layers[layerData.name] = layerData.map;
                if(layerData.active){
                    layerData.map.addTo(self.map);
                }
            });
            self.map.setView(
                [resource.center.lat, resource.center.lng], 
                resource.center.zoom);
            self.layerControl = L.control.layers(self.layers, {'Données': self.layer});
            self.layerControl.addTo(self.map);
            self.layerReady = true;
            dfd.resolve();
        });
        return dfd.promise;
    }; 


    this.initLayer = function(){
        self.geoms.forEach(function(geom){
            geom.addTo(self.layer);
        });
    };

    this.addGeom = function(jsonData){
        var geom = L.GeoJSON.geometryToLayer(jsonData);
        geom.feature = jsonData;
        geom.on('click', function(e){
            $rootScope.$apply(
                $rootScope.$broadcast('mapService:itemClick', geom)    
            );
        });
        geom.bindPopup('<a href="#/chiro/site/' + jsonData.properties.id + '">' + jsonData.properties.siteNom + '</a>');
        self.geoms.push(geom);
        if(this.layerReady){
            geom.addTo(this.layer);
        }
        return geom;
    };

    this.selectItem = function(_id){
        var res = $filter('filter')(self.geoms, {feature: {properties: {id: _id}}}, function(act, exp){return act==exp;});
        try{
            geom = res[0];
            if(this.currentSel){
                this.currentSel.setIcon(L.icon({
                    iconUrl: 'js/lib/leaflet/images/marker-icon.png', 
                    iconSize: [25, 41], 
                    iconAnchor: [13, 41],
                    popupAnchor: [0, -41],
                }));
            }
            geom.setIcon(L.icon({
                iconUrl: 'js/lib/leaflet/images/marker-icon-rouge.png', 
                iconSize: [25, 41], 
                iconAnchor: [13, 41],
                popupAnchor: [0, -41],
            }));
            self.map.setView(geom.getLatLng(), Math.max(this.map.getZoom(), 13));
            self.currentSel = geom;
            return geom;
        }
        catch(e){
            return null;
        }
    };

    this.filterData = function(ids){
        if(!this.layer){
            return;
        }
        angular.forEach(this.geoms, function(geom){
            if(ids.indexOf(geom.feature.properties.id) < 0){
                geom.feature.$shown = false;
                this.layer.removeLayer(geom);
            }
            else{
                if(geom.feature.$shown === false){
                    geom.feature.$shown = true;
                    this.layer.addLayer(geom);
                }
            }
        }, this);
    };

    this.loadData = function(url){
        var dfd = $q.defer();
        dataServ.get(url, this.dataLoad(dfd));
        return dfd.promise;
    };

    this.dataLoad = function(deferred){
        return function(resp){
            resp.forEach(function(geom){
                self.addGeom(geom);
            });
            $rootScope.$broadcast('mapService:dataLoaded');
            self.dataLoaded = true;
            deferred.resolve();
        };
    };
});
*/


