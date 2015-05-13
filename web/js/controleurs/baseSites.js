var app = angular.module('baseSites');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/site', {
            controller: 'siteListController',
            templateUrl: 'js/views/site/list.htm'
        })
        .when('/:appName/edit/site', {
            controller: 'siteEditController',
            templateUrl: 'js/views/site/edit.htm'
        })
        .when('/:appName/edit/site/:id', {
            controller: 'siteEditController',
            templateUrl: 'js/views/site/edit.htm'
        })
        .when('/:appName/site/:id', {
            controller: 'siteDetailController',
            templateUrl: 'js/views/site/detail.htm'
        });
});


/*
 * controleur pour la carte et la liste des sites
 */
app.controller('siteListController', function($scope, $rootScope, $routeParams, $filter, dataServ, ngTableParams, mapService, configServ, userMessages, $loading, userServ, $q){

    var data = [];
    $rootScope.$broadcast('map:show');
    $rootScope._function='site'; 
    $scope._appName = $routeParams.appName;
    $scope.nb_sites = {};
    configServ.addBc(0, 'Sites', '#/' + $scope._appName + '/site'); 

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
        counts: [10, 25, 50],
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

    
    /*
     * Spinner
     * */
    
    $loading.start('spinner-1');
    var dfd = $q.defer();
    var promise = dfd.promise;
    promise.then(function(result) {
        $loading.finish('spinner-1');
    });
    
    mapService.clear();
    mapService.map.setZoom(10);

    $scope.setData = function(resp){
        $scope.items = resp;
        $scope.createAccess = userServ.checkLevel(3);
        $scope.editAccess = userServ.checkLevel(3);
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


        configServ.get('listSite:ngTable:Filter', function(filter){
            $scope.tableParams.filter(filter);
        });
        configServ.get('listSite:ngTable:Sorting', function(sorting){
            $scope.tableParams.sorting(sorting);
        });

        $scope.data = data;
        $scope.tableParams.reload();
        dfd.resolve('loading data');
    };

    $scope.setSchema = function(schema){
        $scope.schema = schema;
        dataServ.get($scope._appName + '/site', $scope.setData);
    };

    configServ.getUrl($scope._appName + '/config/site/list', $scope.setSchema);
    

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
        mapService.map.setView(res[0].getLatLng(), Math.max(14, mapService.map.getZoom()));
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
            var pg = (idx+1) / $scope.tableParams.count();
            $scope.tableParams.page(Math.ceil(pg) || 1);

        });
        var old = $filter('filter')(mapService.marks, {feature: {properties: {$selected: true}}}, function(act, exp){return act==exp;});
        if(old[0]){
            $scope.changeIcon(old[0]);
        }
        $scope.changeIcon(item);
    };


    /*
     * change la couleur d'un point sur la carte et dans la liste
     * lorsqu'il est sélectionné
     */
    $scope.changeIcon = function(item){
        item.feature.properties.$selected = !item.feature.properties.$selected;
        if(item.feature.properties.$selected){
            item.setIcon(L.icon({
                iconUrl: 'js/lib/leaflet/images/marker-icon-rouge.png', 
                iconSize: [25, 41], 
                iconAnchor: [13, 41],
                popupAnchor: [0, -41],
            }));
        }
        else{
            item.setIcon(L.icon({
                iconUrl: 'js/lib/leaflet/images/marker-icon.png', 
                iconSize: [25, 41], 
                iconAnchor: [13, 41],
                popupAnchor: [0, -41],
            }));
        }
    };
});


/*
 * controleur pour l'affichage basique des détails d'un site
 */
app.controller('siteDetailController', function($scope, $rootScope, $routeParams, configServ, userServ){

    $rootScope.$broadcast('map:show');
    $scope._appName = $routeParams.appName;
    $scope.schemaUrl = $scope._appName + '/config/site/detail';
    $scope.dataUrl = $scope._appName + '/site/' + $routeParams.id;
    $scope.dataId = $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/site/' + $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        $scope.title = data.siteNom;
        configServ.addBc(1, data.siteNom, '#/'+$scope._appName+'/site/'+$routeParams.id);
    });

});





/*
 * controleur pour l'édition d'un site
 */
app.controller('siteEditController', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages){

    $scope._appName = $routeParams.appName;
    $rootScope.$broadcast('map:show');
    $scope.configUrl = $scope._appName + '/config/site/form';

    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/site/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/site/' + $routeParams.id;
        var marker = mapService.getMarker($routeParams.id);
        $scope.data = {__origin__: {geom: $routeParams.id}};
    }
    else{
        $scope.saveUrl = $scope._appName + '/site';
        $scope.data = {}
    }

    $scope.$on('form:init', function(ev, data){
        if(data.siteNom){
            $scope.title = 'Modification du site ' + data.siteNom;
            configServ.addBc(1, data.siteNom, '#/' + $scope._appName + '/site/' + data.id);
            configServ.addBc(2, 'Modification');
        }
        else{
            $scope.title = 'Nouveau site';
            configServ.addBc(2, $scope.title, ''); 
        }
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.infoMessage = 'le site ' + data.siteNom + ' a été créé avec succès.'
        $location.url($scope._appName + '/site/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){

        userMessages.infoMessage = 'le site ' + data.siteNom + ' a été mis à jour avec succès.'
        $location.url($scope._appName + '/site/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){

        userMessages.infoMessage = 'le site ' + data.siteNom + ' a été supprimé avec violence.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/site/');
    });
});

