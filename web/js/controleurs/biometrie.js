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
    $scope.errors = [];

    $scope.setSchema = function(resp){
        $scope.schema = angular.copy(resp.formBiom);
        if($routeParams.id){
            dataServ.get($scope._appName + '/biometrie/' + $routeParams.id, $scope.setData);
        }
        else{
            $scope.tmp = {obsTxId: $routeParams.otx_id};
            angular.forEach($scope.schema, function(item){
                $scope.tmp[item.name] = item.default || null;
            }, $scope);
            $scope.setData($scope.tmp);
        }
    };

    $scope.save = function(){
        if($routeParams.id){
            dataServ.post(
                $scope._appName + '/biometrie/' + $routeParams.id, 
                $scope.data, 
                function(resp){
                    dataServ.forceReload = true;
                    $location.path($scope._appName + '/biometrie/' + resp.id);
                }, 
                function(resp){
                    $scope.errors = resp;
                });
        }
        else{
            dataServ.put(
                $scope._appName + '/biometrie', 
                $scope.data, 
                function(resp){
                    dataServ.forceReload = true;
                    $location.path($scope._appName + '/biometrie/' + resp.id);
                }, 
                function(resp){
                    $scope.errors = resp;
                });
        }

    };

    $scope.removed = function(resp){
        dataServ.forceReload = true;
        $location.path($scope._appName + '/taxons/' + $scope.data.obsTxId);
    }

    $scope.remove = function(){
        if(confirm('Effacement biométrie')){
            dataServ.delete($scope._appName + '/biometrie/' + $routeParams.id, $scope.removed);
        }
    };

    $scope.setData = function(resp){
        $scope.data = angular.copy(resp);
    };

    configServ.getUrl($scope._appName + '/biomConfig', $scope.setSchema);
});
