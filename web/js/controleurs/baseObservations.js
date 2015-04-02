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

app.controller('observationEditController', function($scope, $routeParams, configServ, dataServ){
    $scope._appName = $routeParams.appName;

    $scope.setSchema = function(resp){
        $scope.schema = angular.copy(resp);
        if($routeParams.id){
            dataServ.get($scope._appName + '/observation/' + $routeParams.id, $scope.setData);
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
        $scope.obrs = [];
        if($scope.data.observateurs){
            angular.forEach($scope.data.observateurs, function(obr){
                $scope.obrs.push(obr.obrId);
            }, $scope);
        }
        $scope.data.observateurs = $scope.obrs;

    };

    configServ.getUrl($scope._appName + '/obsConfig', $scope.setSchema);
});


app.controller('observationSiteEditController', function($scope, $routeParams, configServ){
    $scope._appName = $routeParams.appName;

    $scope.setSchema = function(resp){
        $scope.schema = angular.copy(resp);
        $scope.setData({});
    };

    $scope.setData = function(resp){
        $scope.data = angular.copy(resp);
        $scope.data.observateurs = [null];

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
