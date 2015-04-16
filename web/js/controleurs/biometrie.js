var app = angular.module('biometrie');

app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/biometrie/:id', {
            controller: 'biometrieDetailController',
            templateUrl: 'js/templates/biometrie/detail.htm'
        })
        .when('/:appName/edit/biometrie/taxon/:otx_id', {
            controller: 'biometrieEditController',
            templateUrl: 'js/templates/biometrie/edit.htm'
        })
        .when('/:appName/edit/biometrie/:id', {
            controller: 'biometrieEditController',
            templateUrl: 'js/templates/biometrie/edit.htm'
        })
});

app.controller('biometrieDetailController', function($scope, $routeParams, configServ, dataServ){
    $scope._appName = $routeParams.appName;
    $scope.setSchema = function(resp){
        $scope.schema = angular.copy(resp);
        dataServ.get($scope._appName + '/biometrie/' + $routeParams.id, $scope.setData);

    };

    $scope.setData = function(resp){
        $scope.data = angular.copy(resp);
    }

    configServ.getUrl($scope._appName + '/biomConfig', $scope.setSchema);
});

app.controller('biometrieEditController', function($scope, $routeParams, $location, configServ, dataServ){
    $scope._appName = $routeParams.appName;
    $scope.configUrl = $scope._appName + '/config/biometrie/form';
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/biometrie/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/biometrie/' + $routeParams.id;
        $scope.data = {};
    }
    else{
        $scope.saveUrl = $scope._appName + '/biometrie'
        $scope.data = {obsTxId: $routeParams.otx_id};
    }
});
