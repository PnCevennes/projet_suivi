var app = angular.module('baseValidation');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/validation', {
            controller: 'validationListController',
            templateUrl: 'js/views/validation/list.htm'
        });
});


app.controller('validationListController', function($scope, $rootScope, ngTableParams, $routeParams, $loading, $q, dataServ, configServ, mapService){

    $scope._appName = $routeParams.appName;
    $scope.geoms = [];
    $scope.data = [];
    var data = [];
    configServ.addBc(0, 'Validation', '#/'+$scope._appName+'/validation');
    
    /*
     * Spinner
     * */
    $loading.start('spinner-1');
    var dfd = $q.defer();
    var promise = dfd.promise;
    promise.then(function(result) {
        $loading.finish('spinner-1');
    });
 
    $scope.schema = {
        title: 'Taxons en attente de validation',
        emptyMsg: 'Aucun taxon en attente',
        detailUrl: '#/'+$scope._appName+'/validation/',
        fields: [
            {
                name: 'id',
                label: 'Id',
                filter: {id: 'text'}, 
                options: {visible: false}
            },
            {
                name: 'cdNom',
                label: 'CdNom',
                filter: {cdNom: 'text'},
                options: {visible: false}
            },
            {
                name: 'nomComplet',
                label: 'Nom complet',
                filter: {nomComplet: 'text'},
                options: {visible: true}
            },
            {
                name: 'obsEffectifAbs',
                label: 'Effectif total',
                filter: {obsEffectifAbs: 'text'},
                options: {visible: true}
            },
            {
                name: 'siteNom',
                label: 'Nom du site',
                filter: {siteNom: 'text'},
                options: {visible: true}
            },
            {
                name: 'obsDate',
                label: "Date d'observation",
                filter: {obsDate: 'text'},
                options: {visible: true, type: 'date'}
            },
        ]
    };
   
    $scope.setData = function(resp){

        mapService.initialize('js/resources/chiro_obs.json').then(function(){

            /*
             * initialisation des listeners d'évenements carte 
             */

            // click sur la carte
            $scope.$on('mapService:itemClick', function(ev, item){
                mapService.selectItem(item.feature.properties.id);
                $rootScope.$broadcast('chiro/validation:select', item.feature.properties);
            });

            // sélection dans la liste
            $scope.$on('chiro/validation:ngTable:ItemSelected', function(ev, item){
                var geom = mapService.selectItem(item.id);
                geom.openPopup();
            });

            // filtrage de la liste
            $scope.$on('chiro/validation:ngTable:Filtered', function(ev, data){
                ids = [];
                data.forEach(function(item){
                    ids.push(item.id);
                });
                mapService.filterData(ids);
            });

            var tmp = [];
            $scope.items = resp;
            resp.forEach(function(item){
                tmp.push(item.properties);
                mapService.addGeom(item);
            });
            $scope.geoms = resp;
            $scope.data = tmp;

            dfd.resolve('loading data');
        });
    };

    dataServ.get($scope._appName + '/obs_taxon/observation', $scope.setData);
});
