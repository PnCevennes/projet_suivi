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
    $scope.selection = [];
    $scope.action = 1;
    $scope.data_url = $routeParams.appName + '/obs_taxon';
    var data = [];
    var checked = [];
    
    /*
     * Spinner
     * */
    $loading.start('spinner-1');
    var dfd = $q.defer();
    var promise = dfd.promise;
    promise.then(function(result) {
        $loading.finish('spinner-1');
    });

    $scope.send = function(){
        var act = {action: $scope.action, selection: $scope.selection};
    };
 
    $scope.schema = {
        title: 'Taxons en attente de validation',
        emptyMsg: 'Aucun taxon en attente',
        detailUrl: '#/'+$scope._appName+'/taxons/',
        editUrl: '#/'+$scope._appName+'/edit/taxons/',
        editAccess: 5,
        checkable: true,
        filtering:{
            fields: [
                {
                    name: 'taxon',
                    label: 'Taxon',
                    type: 'xhr',
                    options:{
                        url: 'chiro/taxons',
                        reverseurl: 'chiro/taxons/id',
                        ref: 'taxon'
                    }
                },
                {
                    name: 'period_start',
                    label: 'Observation la plus ancienne',
                    type: 'date'
                },
                {
                    name: 'period_end',
                    label: 'Observation la plus récente',
                    type: 'date'
                },
                {
                    name: 'st_valid',
                    label: 'Statut validation',
                    type: 'select',
                    options: {
                        choices:[
                            {id: '54', libelle: 'Valide'},
                            {id: '55', libelle: 'A valider'},
                            {id: '56', libelle: 'Non valide'}
                        ]
                    },
                }
            ]
        },
        fields: [
            {
                name: 'id',
                label: 'Id',
                options: {
                    visible: true,
                    type: 'checkable'
                }
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
                filterFunc: 'starting',
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
        console.log('data recu');

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

            $scope.$on('chiro/validation:ngTable:itemChecked', function(ev, item){
                if(item._checked){
                    if(checked.indexOf(item)==-1){
                        checked.push(item);
                    }
                }
                else{
                    if(checked.indexOf(item)>=-1){
                        checked.splice(checked.indexOf(item), 1);
                    }
                }
                var checked_ids = [];
                checked.forEach(function(item){
                    checked_ids.push(item.id);
                });
                $scope.selection = checked_ids;
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

});
