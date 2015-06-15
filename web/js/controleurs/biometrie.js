var app = angular.module('biometrie');

app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/biometrie/:id', {
            controller: 'biometrieDetailController',
            templateUrl: 'js/views/biometrie/detail.htm'
        })
        .when('/:appName/edit/biometrie/taxon/:otx_id', {
            controller: 'biometrieEditController',
            templateUrl: 'js/views/biometrie/edit.htm'
        })
        .when('/:appName/edit/biometrie/:id', {
            controller: 'biometrieEditController',
            templateUrl: 'js/views/biometrie/edit.htm'
        })
});

app.controller('biometrieDetailController', function($scope, $rootScope, $routeParams, configServ, dataServ){
    $scope._appName = $routeParams.appName;
    $rootScope.$broadcast('map:hide');

    $scope.schemaUrl = $scope._appName + '/config/biometrie/detail';
    $scope.dataUrl = $scope._appName + '/biometrie/' + $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/biometrie/' + $routeParams.id;

    $scope.dataId = $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        $scope.title = "Biométrie n°" + data.id;
        if($rootScope._function == 'site'){
            configServ.addBc(4, $scope.title, '#/'+$scope._appName+'/biometrie/'+data.id);
        }
        else{
            configServ.addBc(3, $scope.title, '#/'+$scope._appName+'/biometrie/'+data.id);
        }
    });

});

app.controller('biometrieEditController', function($scope, $rootScope, $routeParams, $location, configServ, dataServ, userMessages){
    $scope._appName = $routeParams.appName;
    $rootScope.$broadcast('map:hide');
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
    $scope.$on('form:init', function(ev, data){
        if($routeParams.id){
            $scope.title = "Modification de la biométrie";
            // breadcrumbs
            if($rootScope._function == 'site'){
                configServ.addBc(5, 'Modification', '');
            }
            else{
                configServ.addBc(4, 'Modification', '');
            }
        }
        else{
            $scope.title = 'Nouvelle biométrie';
            if($rootScope._function == 'site'){
                configServ.addBc(5, $scope.title, '');
            }
            else{
                configServ.addBc(4, $scope.title, '');
            }
        }
    });

    $scope.$on('form:cancel', function(ev, data){
        $location.url($scope._appName + '/biometrie/' + data.id);
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.infoMessage = "La biométrie n°" + data.id + ' a été créée avec succès.'
        $location.url($scope._appName + '/biometrie/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){
        userMessages.infoMessage = "La biométrie n°" + data.id + ' a été modifiée avec succès.'
        $location.url($scope._appName + '/biometrie/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){
        userMessages.infoMessage = "Personne n'a jamais pris la moindre mesure sur quoi que ce soit.";
        dataServ.forceReload = true;
        $location.url($scope._appName + '/taxons/' + data.obsTxId);
    });
});
