var app = angular.module('baseValidation');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/validation', {
            controller: 'validationListController',
            templateUrl: 'js/views/validation/list.htm'
        });
});


app.controller('validationListController', function($scope, $rootScope, ngTableParams, $routeParams, $loading, $q, dataServ, configServ, userServ, mapService){

    $scope._appName = $routeParams.appName;
    $scope.geoms = [];
    $scope.data = [];
    $scope.selection = [];
    $scope.action = 55;
    $scope.data_url = $routeParams.appName + '/obs_taxon';
    var data = [];
    var checked = [];
    $scope.checkedSelection = checked;
    
    /*
     * Spinner
     * */
    $loading.start('spinner-1');
    var dfd = $q.defer();
    var promise = dfd.promise;
    promise.then(function(result) {
        $loading.finish('spinner-1');
    });


    $scope.send = function(){
        var act = {action: $scope.action, selection: $scope.selection};
        dataServ.post($scope._appName + '/validate_taxon', act, function(resp){
            checked.forEach(function(item){
                item.obsObjStatusValidation = $scope.action;
                item.validateur = userServ.getUser().nom_complet;
                var today = new Date();
                item.dateValidation = today.getFullYear() + '-' + ('00'+(today.getMonth()+1)).slice(-2) + '-' + today.getDate();
            });
        });
    };
 
    $scope.clear = function(emit){
        $scope.selection.splice(0);
        checked.splice(0);
        if(emit===true){
            $rootScope.$broadcast('chiro/validation:clearChecked');
        }
    };

    $scope.$on('chiro/validation:cleared', function(){
        $scope.clear();
    });
   
    $scope.setData = function(resp){
        $scope.selection.splice(0);
        checked.splice(0);

        mapService.initialize('js/resources/chiro_obs.json').then(function(){

            /*
             * initialisation des listeners d'évenements carte 
             */

            // click sur la carte
            $scope.$on('mapService:itemClick', function(ev, item){
                mapService.selectItem(item.feature.properties.id);
                $rootScope.$broadcast('chiro/validation:select', item.feature.properties);
            });

            // sélection dans la liste
            $scope.$on('chiro/validation:ngTable:ItemSelected', function(ev, item){
                var geom = mapService.selectItem(item.id);
                geom.openPopup();
            });

            // filtrage de la liste
            $scope.$on('chiro/validation:ngTable:Filtered', function(ev, data){
                ids = [];
                data.forEach(function(item){
                    ids.push(item.id);
                });
                mapService.filterData(ids);
            });

            $scope.$on('chiro/validation:ngTable:itemChecked', function(ev, item){
                if(item._checked){
                    if(checked.indexOf(item)==-1){
                        checked.push(item);
                    }
                }
                else{
                    if(checked.indexOf(item)>=-1){
                        checked.splice(checked.indexOf(item), 1);
                    }
                }
                var checked_ids = [];
                checked.forEach(function(item){
                    checked_ids.push(item.id);
                });
                $scope.selection = checked_ids;
            });

            var tmp = [];
            $scope.items = resp;
            resp.forEach(function(item){
                tmp.push(item.properties);
                mapService.addGeom(item);
            });
            $scope.geoms = resp;
            $scope.data = tmp;

            dfd.resolve('loading data');
        });
    };

    configServ.getUrl($scope._appName + '/config/obstaxon/validation', function(resp){
        $scope.schema = resp;
    });

});
