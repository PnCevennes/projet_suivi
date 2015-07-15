var app = angular.module('baseObservations');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/inventaire', {
            controller: 'observationListController',
            templateUrl: 'js/views/observation/list.htm'
        })
        .when('/:appName/observation/site/:id', {
            controller: 'observationSiteListController',
            templateUrl: 'js/views/observation/list.htm'
        })
        .when('/:appName/inventaire/:id', {
            controller: 'observationSsSiteDetailController',
            templateUrl: 'js/views/observation/detailSsSite.htm'
        })
        .when('/:appName/edit/observation', {
            controller: 'observationEditController',
            templateUrl: 'js/views/observation/edit.htm'
        })
        .when('/:appName/edit/observation/site/:site_id', {
            controller: 'observationEditController',
            templateUrl: 'js/views/observation/edit.htm'
        })
        .when('/:appName/edit/inventaire', {
            controller: 'observationSsSiteEditController',
            templateUrl: 'js/views/observation/edit.htm'
        })
        .when('/:appName/edit/inventaire/:id', {
            controller: 'observationSsSiteEditController',
            templateUrl: 'js/views/observation/edit.htm'
        })
        .when('/:appName/edit/observation/:id', {
            controller: 'observationEditController',
            templateUrl: 'js/views/observation/edit.htm'
        })
        .when('/:appName/observation/:id', {
            controller: 'observationDetailController',
            templateUrl: 'js/views/observation/detail.htm'
        });

});

/*
 *  Liste des observations sans site
 */
app.controller('observationListController', function($scope, $routeParams, dataServ, mapService, configServ, $loading, userServ, $q, $timeout){
    $scope._appName = $routeParams.appName;


    var data = [];
    $scope._appName = $routeParams.appName;
    $scope.editAccess = userServ.checkLevel(2);
    $scope.data = [];

    
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
        var tmp = [];
        $scope.items = resp;
        resp.forEach(function(item){
            tmp.push(item.properties);
            mapService.addGeom(item);
        });
        $scope.geoms = resp;
        $scope.data = tmp;
        dfd.resolve('loading data');
    };

    $scope.setSchema = function(schema){
        $scope.schema = schema;
        mapService.initialize('js/resources/chiro_obs.json').then(function(){
            dataServ.get($scope._appName + '/observation', $scope.setData);
        });
    };

    $timeout(function(){
        configServ.getUrl($scope._appName + '/config/observation/sans-site/list', $scope.setSchema);
    }, 0);
});

/*
 * Edition d'une observation associée à un site
 */
app.controller('observationEditController', function($scope, $rootScope, $routeParams, $location, configServ, dataServ, userMessages){
    $scope._appName = $routeParams.appName;
    $scope.configUrl = $scope._appName + '/config/observation/form';
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/observation/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/observation/' + $routeParams.id;
        $scope.data = {};
    }
    else{
        $scope.saveUrl = $scope._appName + '/observation';
        $scope.data = {siteId: $routeParams.site_id};
    }

    var frDate = function(dte){
        try{
            return dte.getDate() + '/' + dte.getMonth() + '/' + dte.getFullYear();
        }
        catch(e){
            return dte.replace(/^(\w+)-(\w+)-(\w+).*/, '$3/$2/$1');
        }
    }

    $scope.$on('form:init', function(ev, data){
        if(data.obsDate){
            $scope.title = "Modification de la visite du " + frDate(data.obsDate);
            // breadcrumbs
        }
        else{
            $scope.title = 'Nouvelle visite';
        }
    });

    $scope.$on('form:cancel', function(ev, data){
        if(data.id){
            $location.url($scope._appName + '/observation/' + data.id);
        }
        else{
            $location.url($scope._appName + '/site/' + data.siteId);
        }
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.infoMessage = "La visite n° " + data.id + " du " + frDate(data.obsDate) + ' a été créée avec succès.';
        $location.url($scope._appName + '/observation/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){
        userMessages.infoMessage = "La visite n° " + data.id + " du " + frDate(data.obsDate) + ' a été mise à jour avec succès.';
        $location.url($scope._appName + '/observation/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){
        userMessages.infoMessage = "La viste n° " + data.id + " du " + frDate(data.obsDate) + " a été supprimée.";
        dataServ.forceReload = true;
        $location.url($scope._appName + '/site/' + data.siteId);
    });
});

/*
 * Detail d'une observation associée à un site
*/
app.controller('observationDetailController', function($scope, $rootScope, $routeParams, dataServ, configServ, mapService){
    $scope._appName = $routeParams.appName;

    $scope.schemaUrl = $scope._appName + '/config/observation/detail';
    $scope.dataUrl = $scope._appName + '/observation/' + $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/observation/' + $routeParams.id;
    $scope.dataId = $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        $scope.title = "Visite du " + data.obsDate.replace(/(\d+)-(\d+)-(\d+)/, '$3/$2/$1');

        mapService.initialize('js/resources/chiro_obs.json').then(function(){
            mapService.loadData($scope._appName + '/site').then(function(){
                mapService.selectItem(data.siteId);
            });
        });

    });
});


/*
 * Détail d'une observation sans site
 */
app.controller('observationSsSiteDetailController', function($scope, $rootScope, $routeParams, dataServ, configServ, mapService){
    $scope._appName = $routeParams.appName;


    $scope.schemaUrl = $scope._appName + '/config/observation/sans-site/detail';
    $scope.dataUrl = $scope._appName + '/observation/' + $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/inventaire/' + $routeParams.id;
    $scope.dataId = $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        $scope.title = "Inventaire du " + data.obsDate.replace(/(\d+)-(\d+)-(\d+)/, '$3/$2/$1');
        
        mapService.initialize('js/resources/chiro_obs.json').then(function(){
            mapService.loadData($scope._appName + '/observation').then(function(){
                mapService.selectItem($routeParams.id);
            });
        });

    });
});


/*
 * Edition d'une observation sans site
 */
app.controller('observationSsSiteEditController', function($scope, $rootScope, $routeParams, $location, configServ, dataServ, userMessages){
    $scope._appName = $routeParams.appName;
    $scope.configUrl = $scope._appName + '/config/observation/sans-site/form';
    if($routeParams.id){
        $scope.saveUrl = $scope._appName + '/observation/' + $routeParams.id;
        $scope.dataUrl = $scope._appName + '/observation/' + $routeParams.id;
        $scope.data = {__origin__: {geom: $routeParams.id}};
    }
    else{
        $scope.saveUrl = $scope._appName + '/observation';
        $scope.data = {};
    }

    var frDate = function(dte){
        try{
            return dte.getDate() + '/' + dte.getMonth() + '/' + dte.getFullYear();
        }
        catch(e){
            return dte.replace(/^(\w+)-(\w+)-(\w+).*/, '$3/$2/$1');
        }
    }

    $scope.$on('form:init', function(ev, data){
        if(data.obsDate){
            $scope.title = "Modification de l'inventaire du " + frDate(data.obsDate)
            // breadcrumbs
        }
        else{
            $scope.title = 'Nouvel inventaire';
        }
    });

    $scope.$on('form:cancel', function(ev, data){
        if(data.id){
            $location.url($scope._appName + '/inventaire/' + data.id);
        }
        else{
            $location.url($scope._appName + '/inventaire');
        }
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.infoMessage = "l'inventaire n° " + data.id + " du " + frDate(data.obsDate) + ' a été créée avec succès.';
        $location.url($scope._appName + '/inventaire/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){
        userMessages.infoMessage = "l'inventaire n° " + data.id + " du " + frDate(data.obsDate) + ' a été mise à jour avec succès.';
        $location.url($scope._appName + '/inventaire/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){
        userMessages.infoMessage = "l'inventaire n° " + data.id + " du " + frDate(data.obsDate) + " a été supprimé.";
        dataServ.forceReload = true;
        $location.url($scope._appName + '/inventaire');
    });
});


