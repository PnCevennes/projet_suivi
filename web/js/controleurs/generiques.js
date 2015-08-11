var app = angular.module('generiques');
/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/g/:appName/:viewName/list', {
            controller: 'genericListController',
            templateUrl: 'js/views/generic/list.htm'
        })
        .when('/g/:appName/:viewName/edit', {
            controller: 'genericEditController',
            templateUrl: 'js/views/generic/edit.htm'
        })
        .when('/g/:appName/:viewName/edit/:id', {
            controller: 'genericEditController',
            templateUrl: 'js/views/generic/edit.htm'
        })
        .when('/g/:appName/:viewName/:protocoleReference/edit/:idReference', {
            controller: 'genericEditController',
            templateUrl: 'js/views/generic/edit.htm'
        })
        .when('/g/:appName/:viewName/detail/:id', {
            controller: 'genericDetailController',
            templateUrl: 'js/views/generic/detail.htm'
        });
});


app.controller('genericListController', function($scope, $routeParams, configServ, dataServ, userServ, $loading, mapService, $q, $timeout){

    $scope._appName = $routeParams.appName;
    $scope.editAccess = false;
    $scope.data_url = '';

    var _configUrl = $routeParams.appName + '/config/' + $routeParams.viewName + '/list';

    /*
     * Spinner
     * */
    
    $loading.start('spinner-1');
    var dfd = $q.defer();
    var promise = dfd.promise;
    promise.then(function(result) {
        $loading.finish('spinner-1');
    });
    

    $scope.setData = function(resp){
        if($scope.schema.mapConfig){
            $scope.items = resp;
            mapService.initialize($scope.schema.mapConfig).then(function(){
                $scope.data = resp.map(function(item){
                    mapService.addGeom(item); 
                    return item.properties;
                });
            });
        }
        else{
            $scope.data = resp;
        }
        dfd.resolve('data');
    };


    $timeout(function(){
        configServ.getUrl(_configUrl, function(resp){
            $scope.schema = resp;
            $scope.editAccess = userServ.checkLevel(resp.editAccess);
            $scope.data_url = resp.dataUrl;
        });
    }, 0);
});


app.controller('genericEditController', function($scope, $routeParams, configServ, dataServ, userServ, $loading, mapService, $q, $timeout, userMessages, $location){

    $scope._appName = $routeParams.appName;
    $scope.configUrl = $routeParams.appName + '/config/' + $routeParams.viewName + '/form';

    var _redirectUrl = $routeParams.appName + '/' + $routeParams.viewName + '/';

    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/' + $routeParams.viewName + '/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/' + $routeParams.viewName + '/' + $routeParams.id;
        $scope.data = {__origin__: {geom: $routeParams.id}};
    }
    else{
        $scope.saveUrl = $scope._appName + '/' + $routeParams.viewName; 
        $scope.data = {}
    }
    
    $scope.$on('schema:init', function(ev, schema){
        $scope.schema = schema;
        if($routeParams.protocoleReference){
            schema.groups.forEach(function(_group){
                _group.fields.forEach(function(_field){
                    if(_field.options && _field.options.referParent){
                        $scope.data[_field.name] = $routeParams.idReference;
                    }
                });
            });
        }
    });

    $scope.$on('form:init', function(ev, data){
        if(data[$scope.schema.formTitleRef]){
            $scope.title = $scope.schema.formTitleUpdate + data[$scope.schema.formTitleRef];
        }
        else{
            $scope.title = $scope.schema.formTitleCreate;
        }
    });

    $scope.$on('form:cancel', function(ev, data){
        if($routeParams.id){
            $location.url($scope.schema.formCreateCancelUrl);
        }
        else{
            $location.url(_redirectUrl + data.id);
        }
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.successMessage = $scope.schema.createSuccessMessage;
        $location.url(_redirectUrl + data.id);
    });

    $scope.$on('form:update', function(ev, data){
        userMessages.successMessage = $scope.schema.updateSuccessMessage;
        $location.url(_redirectUrl + data.id);
    });

    $scope.$on('form:delete', function(ev, data){
        userMessages.successMessage = $scope.schema.deleteSuccessMessage;
        dataServ.forceReload = true;
        $location.url($scope.schema.formDeleteRedirectUrl);
    });
});


app.controller('genericDetailController', function($scope, $routeParams, configServ, dataServ, userServ, $loading, mapService, $q, $timeout){

    $scope._appName = $routeParams.appName;
    $scope.configUrl = $routeParams.appName + '/config/' + $routeParams.viewName + '/detail';
    $scope.dataUrl = null;

    $scope.$on('schema:init', function(ev, schema){
        if(schema){
            $scope.schema = schema;
            $scope.dataUrl = schema.dataUrl + $routeParams.id;
            $scope.dataId = $routeParams.id;
        }
    });

    $scope.$on('display:init', function(ev, data){
        if($scope.schema.mapConfig){
            mapService.initialize($scope.schema.mapConfig).then(function(){
                mapService.loadData($scope.schema.mapData).then(
                    function(){
                        mapService.selectItem($routeParams.id);
                    }
                    );
                $scope.title = data.bsNom;
            });
        }
    });
});
