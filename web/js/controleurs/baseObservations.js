var app = angular.module('baseObservations');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/observation', {
            controller: 'observationListController',
            templateUrl: 'js/views/observation/list.htm'
        })
        .when('/:appName/observation/site/:id', {
            controller: 'observationSiteListController',
            templateUrl: 'js/views/observation/list.htm'
        })
        .when('/:appName/observation/sans-site/:id', {
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
        .when('/:appName/edit/observation/sans-site', {
            controller: 'observationSsSiteEditController',
            templateUrl: 'js/views/observation/edit.htm'
        })
        .when('/:appName/edit/observation/sans-site/:id', {
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
app.controller('observationListController', function($scope, $rootScope, $routeParams, $filter, dataServ, mapService, configServ, userMessages, $loading, ngTableParams, userServ, $q){
    $scope._appName = $routeParams.appName;
    $rootScope._function='observation';


    var data = [];
    $scope._appName = $routeParams.appName;
    $scope.createAccess = userServ.checkLevel(2);
    $scope.editAccess = userServ.checkLevel(3);
    $scope.data = [];
    configServ.addBc(0, 'Inventaires', '#/' + $scope._appName + '/observation'); 

    
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

            /*
             * initialisation des listeners d'évenements carte 
             */

            // click sur la carte
            $scope.$on('mapService:itemClick', function(ev, item){
                mapService.selectItem(item.feature.properties.id);
                $rootScope.$broadcast('chiro/observation:select', item.feature.properties);
            });

            // sélection dans la liste
            $scope.$on('chiro/observation:ngTable:ItemSelected', function(ev, item){
                var geom = mapService.selectItem(item.id);
                geom.openPopup();
            });

            // filtrage de la liste
            $scope.$on('chiro/observation:ngTable:Filtered', function(ev, data){
                ids = [];
                data.forEach(function(item){
                    ids.push(item.id);
                });
                mapService.filterData(ids);
            });


            dataServ.get($scope._appName + '/observation', $scope.setData);
        });
    };

    configServ.getUrl($scope._appName + '/config/observation/sans-site/list', $scope.setSchema);
    

});

/*
app.controller('observationSiteListController', function($scope, $routeParams){
    $scope._appName = $routeParams.appName;
});
*/


/*
 * Edition d'une observation associée à un site
 */
app.controller('observationEditController', function($scope, $rootScope, $routeParams, $location, configServ, dataServ, userMessages){
    $rootScope.$broadcast('map:show');
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
            configServ.addBc(2, frDate(data.obsDate), '#/' + $scope._appName + '/observation/' + data.id);
            configServ.addBc(3, $scope.title, '');
        }
        else{
            $scope.title = 'Nouvelle visite';
            configServ.addBc(3, $scope.title, '');
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

    $rootScope.$broadcast('map:show');

    $scope.schemaUrl = $scope._appName + '/config/observation/detail';
    $scope.dataUrl = $scope._appName + '/observation/' + $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/observation/' + $routeParams.id;
    $scope.dataId = $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        configServ.addBc(2, data.obsDate.replace(/(\w+)-(\w+)-(\w+)/, '$3/$2/$1'), '#/' + $scope._appName + '/observation/' + data.id);
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

    $rootScope.$broadcast('map:show');

    $scope.schemaUrl = $scope._appName + '/config/observation/sans-site/detail';
    $scope.dataUrl = $scope._appName + '/observation/' + $routeParams.id;
    $scope.updateUrl = '#/' + $scope._appName + '/edit/observation/sans-site/' + $routeParams.id;
    $scope.dataId = $routeParams.id;

    $scope.$on('display:init', function(ev, data){
        configServ.addBc(1, data.obsDate.replace(/(\w+)-(\w+)-(\w+)/, '$3/$2/$1'), '#/' + $scope._appName + '/observation/sans-site/' + data.id);
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
    $rootScope.$broadcast('map:show');
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
            configServ.addBc(1, frDate(data.obsDate), '#/' + $scope._appName + '/observation/sans-site/' + data.id);
            configServ.addBc(2, $scope.title, '');
        }
        else{
            $scope.title = 'Nouvel inventaire';
            configServ.addBc(2, $scope.title, '');
        }
    });

    $scope.$on('form:cancel', function(ev, data){
        if(data.id){
            $location.url($scope._appName + '/observation/sans-site/' + data.id);
        }
        else{
            $location.url($scope._appName + '/observation');
        }
    });

    $scope.$on('form:create', function(ev, data){
        userMessages.infoMessage = "l'inventaire n° " + data.id + " du " + frDate(data.obsDate) + ' a été créée avec succès.';
        $location.url($scope._appName + '/observation/sans-site/' + data.id);
    });

    $scope.$on('form:update', function(ev, data){
        userMessages.infoMessage = "l'inventaire n° " + data.id + " du " + frDate(data.obsDate) + ' a été mise à jour avec succès.';
        $location.url($scope._appName + '/observation/sans-site/' + data.id);
    });

    $scope.$on('form:delete', function(ev, data){
        userMessages.infoMessage = "l'inventaire n° " + data.id + " du " + frDate(data.obsDate) + " a été supprimé.";
        dataServ.forceReload = true;
        $location.url($scope._appName + '/observation');
    });
});


