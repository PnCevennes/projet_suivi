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

app.controller('observationEditController', function($scope, $routeParams){
    $scope._appName = $routeParams.appName;
});

app.controller('observationDetailController', function($scope, $routeParams){
    $scope._appName = $routeParams.appName;
});
