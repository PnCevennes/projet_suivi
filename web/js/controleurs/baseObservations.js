var app = angular.module('baseObservations');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/observation', {
            controller: 'observationListController',
            templateUrl: 'js/templates/observation/list.htm'
        })
        .when('/:appName/observation/site/:id', {
            controller: 'observationSiteListController',
            templateUrl: 'js/templates/observation/list.htm'
        })
        .when('/:appName/edit/observation', {
            controller: 'observationEditController',
            templateUrl: 'js/templates/observation/edit.htm'
        })
        .when('/:appName/edit/observation/site/:id', {
            controller: 'observationSiteEditController',
            templateUrl: 'js/templates/observation/edit.htm'
        })
        .when('/:appName/edit/observation/:id', {
            controller: 'observationEditController',
            templateUrl: 'js/templates/observation/edit.htm'
        })
        .when('/:appName/observation/:id', {
            controller: 'observationDetailController',
            templateUrl: 'js/templates/observation/detail.htm'
        });

});


app.controller('observationListController', function($scope, $routeParams){
    $scope._appName = $routeParams.appName;
});

app.controller('observationSiteListController', function($scope, $routeParams){
    $scope._appName = $routeParams.appName;
});

app.controller('observationEditController', function($scope, $routeParams, $location, configServ, dataServ){
    $scope._appName = $routeParams.appName;

    $scope.setSchema = function(resp){
        $scope.schema = angular.copy(resp);
        if($routeParams.id){
            dataServ.get($scope._appName + '/observation/' + $routeParams.id, $scope.setData, function(resp){}, true);
        }
        else{
            $scope.setData({});
        }
    };

    $scope.setData = function(resp){
        $scope.data = angular.copy(resp);
        if($scope.data.obsDate){
            $scope.data.obsDate = $scope.data.obsDate.replace(/^(\d+)-(\d+)-(\d+).*$/i, "$3/$2/$1");
        }
        angular.forEach($scope.schema.formObs, function(value){
            if(value.name!='observateurs'){
                if($scope.data[value.name] == undefined){
                    $scope.data[value.name] = null;
                }
            }
        }, $scope);
        $scope.obrs = [];
        if($scope.data.observateurs){
            angular.forEach($scope.data.observateurs, function(obr){
                $scope.obrs.push(obr.obrId);
            }, $scope);
        }
        $scope.data.observateurs = angular.copy($scope.obrs);
        dataServ.get($scope._appName + '/site/' + $scope.data.siteId, $scope.setSite);
    };

    $scope.setSite = function(resp){
        $scope.site = resp;
    };


    $scope.save = function(){
        if($routeParams.id){
            dataServ.post($scope._appName + '/observation/' + $routeParams.id, $scope.data, $scope.saved, $scope.unsaved);
        }
        else{
            dataServ.put($scope._appName + '/observation', $scope.data, $scope.saved, $scope.unsaved);
        }
    };

    $scope.saved = function(resp){
        dataServ.forceReload = true;
        $location.path($scope._appName + '/observation/' + resp.id);
    };

    $scope.unsaved = function(resp){
        $scope.errors = resp;
    };

    $scope.remove = function(){
        if(confirm('Effacement observation')){
            dataServ.delete($scope._appName + '/observation/' + $routeParams.id, $scope.removed);
        }
    };

    $scope.removed = function(resp){
        dataServ.forceReload = true;
        $location.path($scope._appName + '/site/' + $scope.data.siteId);
    }

    configServ.getUrl($scope._appName + '/obsConfig', $scope.setSchema);
});


app.controller('observationSiteEditController', function($scope, $routeParams, $location, configServ, dataServ){
    $scope._appName = $routeParams.appName;

    $scope.setSchema = function(resp){
        $scope.schema = angular.copy(resp);
        $scope.setData({});
    };

    $scope.setData = function(resp){
        $scope.data = angular.copy(resp);
        angular.forEach($scope.schema.formObs, function(value){
            $scope.data[value.name] = value.default || null;
        }, $scope);
        $scope.data.siteId = $routeParams.id;
        $scope.data.observateurs = [null];
        dataServ.get($scope._appName + '/site/' + $routeParams.id, $scope.setSite);
    };

    $scope.setSite = function(resp){
        $scope.site = resp;
    };

    $scope.save = function(){
        dataServ.put($scope._appName + '/observation', $scope.data, function(resp){
            dataServ.forceReload = true;
            $location.path($scope._appName + '/observation/' + resp.id);

        }, function(resp, status){
            $scope.errors = resp;
        });
    };

    $scope.remove = function(){

    };

    configServ.getUrl($scope._appName + '/obsConfig', $scope.setSchema);

});

app.controller('observationDetailController', function($scope, $routeParams, dataServ, configServ){
    $scope._appName = $routeParams.appName;

    $scope.setSchema = function(resp){
        $scope.schema = angular.copy(resp);
        dataServ.get($scope._appName + '/observation/' + $routeParams.id, $scope.setData);
    };

    $scope.setData = function(resp){
        $scope.data = angular.copy(resp);
    }
    configServ.getUrl($scope._appName + '/obsConfig', $scope.setSchema);
});
