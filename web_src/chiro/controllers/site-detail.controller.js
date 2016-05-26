/*
 * controleur pour l'affichage basique des détails d'un site
 */
angular.module('baseSites').controller('siteDetailController', function($scope, $rootScope, $routeParams, configServ, userServ, mapService, $timeout){

    $scope._appName = $routeParams.appName;
    $scope.schemaUrl = $scope._appName + '/config/site/detail';
    $scope.dataUrl = $scope._appName + '/site/' + $routeParams.id;
    $scope.dataId = $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/site/' + $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        mapService.initialize($scope.schema.mapConfig).then(function(){
            mapService.loadData($scope._appName + '/site').then(
                function(){
                    mapService.selectItem($routeParams.id);
                }
                );
            $scope.title = data.bsNom;
        });
    });

    $scope.setSchema = function(schema){
        $scope.schema = schema;
    };

    $timeout(function(){
        configServ.getUrl($scope.schemaUrl, $scope.setSchema);
    }, 0);
});
