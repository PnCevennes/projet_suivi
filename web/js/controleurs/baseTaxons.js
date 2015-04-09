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
    $scope.errors = [];
    $scope.setSchema = function(resp){
        $scope.schema = angular.copy(resp.formObsTx);
        if($routeParams.id){
            dataServ.get($scope._appName + '/obs_taxon/' + $routeParams.id, $scope.setData);
        }
        else{
            $scope.tmp = {obsId: $routeParams.obs_id};
            angular.forEach($scope.schema, function(item){
                $scope.tmp[item.name] = item.default || null;
            }, $scope);
            $scope.setData($scope.tmp);
        }
    };

    $scope.setData = function(resp){
        $scope.data = angular.copy(resp);

    };

    $scope.save = function(){
        if($routeParams.id){
            dataServ.post(
                $scope._appName + '/obs_taxon/' + $routeParams.id, 
                $scope.data, 
                function(resp){
                    dataServ.forceReload = true;
                    $location.path($scope._appName + '/taxons/' + resp.id);
                }, 
                function(resp){
                    $scope.errors = resp;
                });
        }
        else{
            dataServ.put(
                $scope._appName + '/obs_taxon', 
                $scope.data, 
                function(resp){
                    dataServ.forceReload = true;
                    $location.path($scope._appName + '/taxons/' + resp.id);
                }, 
                function(resp){
                    $scope.errors = resp;
                });
        }
    };

    $scope.removed = function(resp){
        dataServ.forceReload = true;
        $location.path($scope._appName + '/observation/' + $scope.data.obsId);
    }

    $scope.remove = function(){
        if(confirm('Effacement obs. taxon')){
            dataServ.delete($scope._appName + '/obs_taxon/' + $routeParams.id, $scope.removed);
        }
    };

    configServ.getUrl($scope._appName + '/obsTxConfig', $scope.setSchema);
});

app.controller('taxonListController', function(){
    $scope._appName = $routeParams.appName;
});
