var app = angular.module('baseTaxons');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/taxons', {
            controller: 'taxonListController',
            templateUrl: 'js/templates/taxon/list.htm'
        })
        .when('/:appName/taxons/:id', {
            controller: 'taxonDetailController',
            templateUrl: 'js/templates/taxon/detail.htm'
        })
        .when('/:appName/edit/taxons', {
            controller: 'taxonEditController',
            templateUrl: 'js/templates/taxon/edit.htm'
        })
        .when('/:appName/edit/taxons/observation/:obs_id', {
            controller: 'taxonEditController',
            templateUrl: 'js/templates/taxon/edit.htm'
        })
        .when('/:appName/edit/taxons/:id', {
            controller: 'taxonEditController',
            templateUrl: 'js/templates/taxon/edit.htm'
        });
});

app.controller('taxonDetailController', function($scope, $routeParams, configServ, dataServ){
    $scope._appName = $routeParams.appName;
    $scope.setSchema = function(resp){
        $scope.schema = angular.copy(resp);
        dataServ.get($scope._appName + '/obs_taxon/' + $routeParams.id, $scope.setData);
    };

    $scope.setData = function(resp){
        $scope.data = angular.copy(resp);
        $scope.select_group('Général');
        dataServ.get($scope._appName + '/biometrie/taxon/' + $routeParams.id, $scope.setBiometries);
    };

    $scope.setBiometries = function(resp){
        $scope.biometries = angular.copy(resp);
    };

    $scope.select_group = function(group){
        angular.forEach($scope.schema.detailObsTx.__groups__, function(grp){
            $scope.schema.detailObsTx[grp].shown = false;
        });
        $scope.schema.detailObsTx[group].shown = true;
    };

    configServ.getUrl($scope._appName + '/obsTxConfig', $scope.setSchema);
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
});

app.controller('taxonListController', function(){
    $scope._appName = $routeParams.appName;
});
