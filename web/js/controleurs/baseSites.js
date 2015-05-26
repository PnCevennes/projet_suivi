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
    $rootScope._function='site'; 
    $scope._appName = $routeParams.appName;
    $scope.createAccess = userServ.checkLevel(3);
    $scope.editAccess = userServ.checkLevel(3);
    $scope.data = [];
    configServ.addBc(0, 'Sites', '#/' + $scope._appName + '/site'); 

    
    /*
     * Spinner
     * */
    
    $loading.start('spinner-1');
    var dfd = $q.defer();
    var promise = dfd.promise;
    promise.then(function(result) {
        $loading.finish('spinner-1');
    });
    
    $scope.setData = function(resp){
        var tmp = [];
        $scope.items = resp;
        resp.forEach(function(item){
            tmp.push(item.properties);
            mapService.addGeom(item);
        });
        $scope.geoms = resp;
        $scope.data = tmp;
        dfd.resolve('loading data');
    };

    $scope.setSchema = function(schema){
        $scope.schema = schema;
        mapService.initialize().then(function(){

            /*
             * initialisation des listeners d'évenements carte 
             */

            // click sur la carte
            $scope.$on('mapService:itemClick', function(ev, item){
                mapService.selectItem(item.feature.properties.id);
                $rootScope.$broadcast('chiro/site:select', item.feature.properties);
            });

            // sélection dans la liste
            $scope.$on('chiro/site:ngTable:ItemSelected', function(ev, item){
                var geom = mapService.selectItem(item.id);
                geom.openPopup();
            });

            // filtrage de la liste
            $scope.$on('chiro/site:ngTable:Filtered', function(ev, data){
                ids = [];
                data.forEach(function(item){
                    ids.push(item.id);
                });
                mapService.filterData(ids);
            });

            dataServ.get($scope._appName + '/site', $scope.setData);
        });
    };

    configServ.getUrl($scope._appName + '/config/site/list', $scope.setSchema);
    

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
        $scope.data = {__origin__: {geom: $routeParams.id}};
    }
    else{
        $scope.saveUrl = $scope._appName + '/site';
        $scope.data = {}
    }

    mapService.loadData($scope._appName + '/site').then(function(){
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
});

