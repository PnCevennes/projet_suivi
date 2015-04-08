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
        .when('/:appName/edit/taxons/:id', {
            controller: 'taxonEditController',
            templateUrl: 'js/templates/taxon/edit.htm'
        });
});

app.controller('taxonDetailController', function($scope, $routeParams, configServ, dataServ){
    $scope._appName = $routeParams.appName;
    $scope.errors = [];
    $scope.setSchema = function(resp){
        $scope.schema = angular.copy(resp);
        dataServ.get($scope._appName + '/obs_taxon/' + $routeParams.id, $scope.setData);
    };

    $scope.setData = function(resp){
        $scope.data = angular.copy(resp)

    };
    configServ.getUrl($scope._appName + '/obsTxConfig', $scope.setSchema);
});

app.controller('taxonEditController', function($scope, $routeParams, $location, configServ, dataServ){
    $scope._appName = $routeParams.appName;
    $scope.setSchema = function(resp){
        $scope.schema = angular.copy(resp.formObsTx);
        if($routeParams.id){
            dataServ.get($scope._appName + '/obs_taxon/' + $routeParams.id, $scope.setData);
        }
        else{
            $scope.tmp = {};
            angular.forEach($scope.schema, function(item){
                $scope.tmp[item.name] = item.default || null;
            }, $scope);
            $scope.setData($scope.tmp);
        }
    };

    $scope.setData = function(resp){
        $scope.data = angular.copy(resp)

    };

    $scope.save = function(){
        if($routeParams.id){
            dataServ.post($scope._appName + '/obs_taxon/' + $routeParams.id, $scope.data, $scope.saved, $scope.unsaved);
        }
        else{
            dataServ.put($scope._appName + '/obs_taxon', $scope.data, $scope.saved, $scope.unsaved);
        }
    };

    $scope.saved = function(resp){
        dataServ.forceReload = true;
        $location.path($scope._appName + '/taxons/' + $resp.id);
    };

    $scope.unsaved = function(resp){
        $scope.errors = resp;
    }

    $scope.remove = function(){
        if(confirm('Effacement obs. taxon')){
            dataServ.delete($scope._appName + '/obs_taxon/' + $routeParams.id, $scope.removed);
        }
    };

    $scope.removed = function(resp){
        dataServ.forceReload = true;
        $location.path($scope._appName + '/taxons/' + $scope.data.obsId);
    }

    configServ.getUrl($scope._appName + '/obsTxConfig', $scope.setSchema);
});

app.controller('taxonListController', function(){
    $scope._appName = $routeParams.appName;
});
