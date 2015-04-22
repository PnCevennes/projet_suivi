var app = angular.module('baseTaxons');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/taxons', {
            controller: 'taxonListController',
            templateUrl: 'js/views/taxon/list.htm'
        })
        .when('/:appName/taxons/:id', {
            controller: 'taxonDetailController',
            templateUrl: 'js/views/taxon/detail.htm'
        })
        .when('/:appName/edit/taxons', {
            controller: 'taxonEditController',
            templateUrl: 'js/views/taxon/edit.htm'
        })
        .when('/:appName/edit/taxons/observation/:obs_id', {
            controller: 'taxonEditController',
            templateUrl: 'js/views/taxon/edit.htm'
        })
        .when('/:appName/edit/taxons/:id', {
            controller: 'taxonEditController',
            templateUrl: 'js/views/taxon/edit.htm'
        });
});

app.controller('taxonDetailController', function($scope, $routeParams, configServ, dataServ){
    $scope._appName = $routeParams.appName;

    $scope.schemaUrl = $scope._appName + '/config/obstaxon/detail';
    $scope.dataUrl = $scope._appName + '/obs_taxon/' + $routeParams.id;
    $scope.dataId = $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/taxons/' + $routeParams.id;
    
    configServ.bc.splice(2, configServ.bc.length);

    $scope.$on('display:init', function(ev, data){
        $scope.title = 'Observation du taxon "' + data.nomComplet + '"';
        configServ.bc.push({label: 'Observation', url: '#/' + $scope._appName + '/observation/' + data.obsId});
    });
});

app.controller('taxonEditController', function($scope, $routeParams, $location, configServ, dataServ){
    $scope._appName = $routeParams.appName;
    
    $scope.configUrl = $scope._appName + '/config/obstaxon/form';
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/obs_taxon/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/obs_taxon/' + $routeParams.id;
        $scope.data = {};
    }
    else{
        $scope.saveUrl = $scope._appName + '/obs_taxon';
        $scope.data = {obsId: $routeParams.obs_id};
    }
    configServ.bc.splice(3, configServ.bc.length);

    $scope.$on('form:init', function(ev, data){
        if(data.cdNom){
            $scope.title = "Modification de l'observation du taxon";
            // breadcrumbs
            configServ.bc.push({label: 'taxon', url: '#/' + $scope._appName + '/taxons/' + $routeParams.id});
        }
        else{
            $scope.title = 'Nouveau taxon';
        }
    });
});

app.controller('taxonListController', function(){
    $scope._appName = $routeParams.appName;
});
