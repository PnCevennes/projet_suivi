var app = angular.module('baseSites');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/site', {
            controller: 'siteListController',
            templateUrl: 'js/templates/site/list.htm'
        })
        .when('/:appName/edit/site', {
            controller: 'siteEditController',
            templateUrl: 'js/templates/site/edit.htm'
        })
        .when('/:appName/edit/site/:id', {
            controller: 'siteEditController',
            templateUrl: 'js/templates/site/edit.htm'
        })
        .when('/:appName/site/:id', {
            controller: 'siteDetailController',
            templateUrl: 'js/templates/site/detail.htm'
        });
});


/*
 * controleur pour la carte et la liste des sites
 */
app.controller('siteListController', function($scope, $rootScope, $routeParams, $filter, dataServ, ngTableParams, mapService, configServ){
    
    $scope._appName = $routeParams.appName;
    $scope.nb_sites = {};

    mapService.clear();
    mapService.map.setZoom(10);
    $scope.success = function(resp){
        var data=[];
        $scope.items = resp;
        mapService.markLayer.clearLayers();
        angular.forEach(resp, function(item){
            var mark = L.marker(L.latLng([item.geometry.coordinates[1], item.geometry.coordinates[0]]));
            mark.bindPopup('<h5><a href="#/'+$scope._appName+'/site/'+item.properties.id+'">' + item.properties.siteNom + '</a><h5>');
            mark.feature = item;
            mark.on('click', function(e){
                $rootScope.$apply(
                    $rootScope.$broadcast('mapService:itemClick', mark)
                    );
                });
            mapService.addPoint(mark);
            data.push(item.properties);
        }, $scope);


        /*
         *  initialisation des parametres du tableau
         */
        $scope.tableParams = new ngTableParams({
            page: 1,
            count: 10,
            filter: {},
            sorting: {}
        },
        {
            counts: [],
            total: data.length, // length of data
            getData: function ($defer, params) {
                // use build-in angular filter
                var filteredData = params.filter() ?
                        $filter('filter')(data, params.filter()) :
                        data;
                var orderedData = params.sorting() ?
                        $filter('orderBy')(filteredData, params.orderBy()) :
                        data;
                var ids = [];
                configServ.put('listSite:ngTable:Filter', params.filter());
                configServ.put('listSite:ngTable:Sorting', params.sorting());
                angular.forEach(orderedData, function(item){
                    ids.push(item.id);
                });
                mapService.filterMarks(ids);
                configServ.put('listSite:ngTable:orderedData', orderedData);
                params.total(orderedData.length); // set total for recalc pagination
                $scope.nb_sites = {total: data.length, current: orderedData.length};
                $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
            } 
        });
        configServ.get('listSite:ngTable:Filter', function(filter){
            $scope.tableParams.filter(filter);
        });
        configServ.get('listSite:ngTable:Sorting', function(sorting){
            $scope.tableParams.sorting(sorting);
        });

        $scope.data = data;
        $scope.tableParams.reload();
    };

    $scope.setSchema = function(schema){
        $scope.schema = schema.listSite;
        dataServ.get($scope._appName + '/site', $scope.success);
    };

    configServ.getUrl($scope._appName + '/siteConfig', $scope.setSchema);
    

    /*
     * evenements
     */
    $scope.$on('mapService:itemClick', function(ev, item){
        $scope.selectPoint(item);
    });


    /*
     * repercute la sélection d'un point dans la liste
     */
    $scope.selectSite = function(item){
        // changement d'état du point précédemment sélectionné
        var old = $filter('filter')(mapService.marks, {feature: {properties: {$selected: true}}}, function(act, exp){return act==exp;});
        if(old[0]){
            $scope.changeIcon(old[0]);
        }
        var res = $filter('filter')(mapService.marks, {feature: {properties: {id: item.id}}}, function(act, exp){return act==exp;});
        res[0].togglePopup();
        mapService.map.setView(res[0].getLatLng(), 14);
        $scope.changeIcon(res[0]);
    };

    /*
     * repercute la selection d'un point sur la carte
     */
    $scope.selectPoint = function(item){
        // changement d'état du point précédemment sélectionné
        configServ.get('listSite:ngTable:orderedData', function(data){
            var cnt = data.length;
            var res = $filter('filter')(data, {id: item.feature.properties.id});
            var idx = data.indexOf(res[0]);
            var pg = idx / $scope.tableParams.count();
            $scope.tableParams.page(Math.ceil(pg) || 1);

        });
        var old = $filter('filter')(mapService.marks, {feature: {properties: {$selected: true}}}, function(act, exp){return act==exp;});
        if(old[0]){
            $scope.changeIcon(old[0]);
        }
        $scope.changeIcon(item);
    }


    /*
     * change la couleur d'un point sur la carte et dans la liste
     * lorsqu'il est sélectionné
     */
    $scope.changeIcon = function(item){
        item.feature.properties.$selected = !item.feature.properties.$selected;
        if(item.feature.properties.$selected){
            item.setIcon(L.icon({iconUrl: 'js/lib/leaflet/images/marker-icon-rouge.png'}));
        }
        else{
            item.setIcon(L.icon({iconUrl: 'js/lib/leaflet/images/marker-icon.png'}));
        }
    }
});


/*
 * controleur pour l'affichage basique des détails d'un site
 */
app.controller('siteDetailController', function($scope, $filter, $routeParams, dataServ, configServ, mapService){

    $scope._appName = $routeParams.appName;

    // chargement des données sites <- dataServ.get(chiro/site/:id)
    $scope.setSites = function(resp){
        $scope.data= angular.copy(resp);

        //affichage du type de lieu en fonction de son type_id
        var field = $filter('filter')($scope.schema.formSite, {name: 'typeId'}, function(act, exp){return act==exp});
        var label = $filter('filter')(field[0].options.choices, {id: $scope.data.properties.typeId}, function(act, exp){
            return act==exp;
        });
        $scope.data.properties.typeId = label[0].libelle;
        mapService.map.setView([$scope.data.geometry.coordinates[1], $scope.data.geometry.coordinates[0]], 14);
        dataServ.get($scope._appName + '/observation/site/' + $routeParams.id, $scope.setObs);
    };

    $scope.setObs = function(resp){
        $scope.observations = angular.copy(resp);
    }

    // chargement du schéma <- dataServ.get(chiro/siteForm)
    $scope.setSchema = function(resp){
        $scope.schema = angular.copy(resp);
        $scope.schema.detailSite.Informations.shown = true;

        // récupération des données à afficher
        dataServ.get($scope._appName + '/site/' + $routeParams.id, $scope.setSites);
    };

    $scope.select_group = function(group){
        angular.forEach($scope.schema.detailSite.__groups__, function(grp){
            $scope.schema.detailSite[grp].shown = false;
        });
        $scope.schema.detailSite[group].shown = true;
    };

    $scope.$on('$destroy', function(){});
    // récupération de la configuration d'affichage
    configServ.getUrl($scope._appName + '/siteConfig', $scope.setSchema, function(err){console.log(err);}, true);
});





/*
 * controleur pour l'édition d'un site
 */
app.controller('siteEditController', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ){

    $scope._appName = $routeParams.appName;

    $scope.setSchema = function(resp){
        $scope.schema = resp;
        if($routeParams.id){
            dataServ.get($scope._appName + '/site/' + $routeParams.id, $scope.setData);
        }
        else{
            props = {};
            $scope.schema.formSite.forEach(function(elem){
                props[elem.name] = elem.default || null;
            });
            $scope.setData({properties: props, geometry: {coordinates: []}});
        }
    };

    $scope.setData = function(resp){
        $scope.data = angular.copy(resp);
        //FIXME rustine
        $scope.data.properties.siteDate = $scope.data.properties.siteDate.replace(/^(\d+)-(\d+)-(\d+).*$/i, "$3/$2/$1");

        var editLayer = new L.FeatureGroup();
        $scope.editLayer = editLayer;

        mapService.map.addLayer(editLayer);
        
        if($scope.data.properties.id){
            var marker = mapService.getMarker($scope.data.properties.id);
            editLayer.addLayer(marker);
        }
        else{
            var marker = null;
        }
        
        $scope.controls = new L.Control.Draw({
            edit: {featureGroup: editLayer},
            draw: {
                circle: false,
                rectangle: false,
            },
        });

        mapService.map.addControl($scope.controls);

        mapService.map.on('draw:created', function(e){
            //console.log(e.layer);
            if(marker == null){
                editLayer.addLayer(e.layer);
                marker = e.layer;
                var coords = e.layer.getLatLng();
                $rootScope.$apply($rootScope.$broadcast('edit:coords', coords));
            }
            
        });

        mapService.map.on('draw:edited', function(e){
            //console.log(e.layers.getLayers()[0].getLatLng());
            var coords = e.layers.getLayers()[0].getLatLng();
            $rootScope.$apply($rootScope.$broadcast('edit:coords', coords));
        });

        mapService.map.on('draw:deleted', function(e){
            marker = null;
            $rootScope.$apply($rootScope.$broadcast('edit:coords', {lat: null, lng: null}));
        });
    };
    
    $scope.$on('edit:coords', function(ev, coords){
        $scope.data.geometry.coordinates[0] = coords.lng;
        $scope.data.geometry.coordinates[1] = coords.lat;
    });

    $scope.$on('$destroy', function(ev){
        mapService.map.removeControl($scope.controls);
        mapService.map.removeLayer($scope.editLayer);
        $scope.controls = null;
    });

    $scope.save = function(){
        if($routeParams.id){
            dataServ.post($scope._appName + '/site/' + $routeParams.id, $scope.data, $scope.updated, $scope.handleErrors);
        }
        else{
            dataServ.put($scope._appName + '/site', $scope.data, $scope.created, $scope.handleErrors);
        }
    };

    $scope.handleErrors = function(resp){
        $scope.errors = resp;
    };

    $scope.updated = function(resp){
        //TODO message
        dataServ.forceReload = true;
        $location.path($scope._appName + '/site');
    };

    $scope.created = function(resp){
        //TODO message
        dataServ.forceReload = true;
        $location.path($scope._appName + '/site');
    };

    $scope.remove = function(){
        dataServ.delete($scope._appName + '/site/' + $routeParams.id, $scope.removed);
    };

    $scope.removed = function(){
        //TODO message
        dataServ.forceReload = true;
        $location.path($scope._appName + '/site');
    };

    // initialisation du formulaire
    configServ.getUrl($scope._appName + '/siteConfig', $scope.setSchema);

});

