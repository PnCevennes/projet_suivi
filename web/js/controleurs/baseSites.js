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
app.controller('siteListController', function($scope, $routeParams, dataServ, mapService, configServ, $loading, userServ, $q, $timeout){

    var data = [];
    $scope._appName = $routeParams.appName;
    $scope.editAccess = userServ.checkLevel(3);
    $scope.data_url = $routeParams.appName + '/site';
    $scope.data = [];

    
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
        $scope.items = resp;
        mapService.initialize('js/resources/chiro_site.json').then(function(){
            $scope.data = resp.map(function(item){
                mapService.addGeom(item); 
                return item.properties;
            });
        });
        $scope.geoms = resp;
        dfd.resolve('loading data');
    };

    $scope.setSchema = function(schema){
        $scope.schema = schema;

    };

    $timeout(function(){
        configServ.getUrl($scope._appName + '/config/site/list', $scope.setSchema);
    }, 0);

});


/*
 * controleur pour l'affichage basique des détails d'un site
 */
app.controller('siteDetailController', function($scope, $rootScope, $routeParams, configServ, userServ, mapService){

    $scope._appName = $routeParams.appName;
    $scope.schemaUrl = $scope._appName + '/config/site/detail';
    $scope.dataUrl = $scope._appName + '/site/' + $routeParams.id;
    $scope.dataId = $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/site/' + $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        mapService.initialize('js/resources/chiro_site.json').then(function(){
            mapService.loadData($scope._appName + '/site').then(
                function(){
                    mapService.selectItem($routeParams.id);
                }
                );
            $scope.title = data.siteNom;
        });
    });

});





/*
 * controleur pour l'édition d'un site
 */
app.controller('siteEditController', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ, userMessages){

    $scope._appName = $routeParams.appName;
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

    $scope.$on('form:init', function(ev, data){
        if(data.siteNom){
            $scope.title = 'Modification du site ' + data.siteNom;
        }
        else{
            $scope.title = 'Nouveau site';
        }
    });

    $scope.$on('form:cancel', function(ev, data){
        $location.url($scope._appName + '/site/');
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.successMessage = 'le site ' + data.siteNom + ' a été créé avec succès.'
        $location.url($scope._appName + '/site/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){

        userMessages.successMessage = 'le site ' + data.siteNom + ' a été mis à jour avec succès.'
        $location.url($scope._appName + '/site/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){

        userMessages.successMessage = 'le site ' + data.siteNom + ' a été supprimé.'
        dataServ.forceReload = true;
        $location.url($scope._appName + '/site/');
    });
});

