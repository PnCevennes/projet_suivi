var app = angular.module('baseSites');


/*
 * configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/:appName/site', {
            controller: 'siteListController',
            templateUrl: 'js/templates/site/list.htm'
        })
        .when('/:appName/edit/site', {
            controller: 'siteEditController',
            templateUrl: 'js/templates/site/edit.htm'
        })
        .when('/:appName/edit/site/:id', {
            controller: 'siteEditController',
            templateUrl: 'js/templates/site/edit.htm'
        })
        .when('/:appName/site/:id', {
            controller: 'siteDetailController',
            templateUrl: 'js/templates/site/detail.htm'
        });
});


/*
 * controleur pour la carte et la liste des sites
 */
app.controller('siteListController', function($scope, $rootScope, $routeParams, $filter, dataServ, ngTableParams, mapService, configServ){
    
    $scope._appName = $routeParams.appName;
    $scope.nb_sites = {};

    mapService.clear();
    mapService.map.setZoom(10);
    $scope.success = function(resp){
        var data=[];
        $scope.items = resp;
        mapService.markLayer.clearLayers();
        angular.forEach(resp, function(item){
            var mark = L.marker(L.latLng([item.geometry.coordinates[1], item.geometry.coordinates[0]]));
            mark.bindPopup('<h5><a href="#/'+$scope._appName+'/site/'+item.properties.id+'">' + item.properties.siteNom + '</a><h5>');
            mark.feature = item;
            mark.on('click', function(e){
                $rootScope.$apply(
                    $rootScope.$broadcast('mapService:itemClick', mark)
                    );
                });
            mapService.addPoint(mark);
            data.push(item.properties);
        }, $scope);


        /*
         *  initialisation des parametres du tableau
         */
        $scope.tableParams = new ngTableParams({
            page: 1,
            count: 10,
            filter: {},
            sorting: {}
        },
        {
            counts: [],
            total: data.length, // length of data
            getData: function ($defer, params) {
                // use build-in angular filter
                var filteredData = params.filter() ?
                        $filter('filter')(data, params.filter()) :
                        data;
                var orderedData = params.sorting() ?
                        $filter('orderBy')(filteredData, params.orderBy()) :
                        data;
                var ids = [];
                configServ.put('listSite:ngTable:Filter', params.filter());
                configServ.put('listSite:ngTable:Sorting', params.sorting());
                angular.forEach(orderedData, function(item){
                    ids.push(item.id);
                });
                mapService.filterMarks(ids);
                configServ.put('listSite:ngTable:orderedData', orderedData);
                params.total(orderedData.length); // set total for recalc pagination
                $scope.nb_sites = {total: data.length, current: orderedData.length};
                $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
            } 
        });
        configServ.get('listSite:ngTable:Filter', function(filter){
            $scope.tableParams.filter(filter);
        });
        configServ.get('listSite:ngTable:Sorting', function(sorting){
            $scope.tableParams.sorting(sorting);
        });

        $scope.data = data;
        $scope.tableParams.reload();
    };

    $scope.setSchema = function(schema){
        $scope.schema = schema.listSite;
        dataServ.get($scope._appName + '/site', $scope.success);
    };

    configServ.getUrl($scope._appName + '/siteConfig', $scope.setSchema);
    

    /*
     * evenements
     */
    $scope.$on('mapService:itemClick', function(ev, item){
        $scope.selectPoint(item);
    });


    /*
     * repercute la sélection d'un point dans la liste
     */
    $scope.selectSite = function(item){
        // changement d'état du point précédemment sélectionné
        var old = $filter('filter')(mapService.marks, {feature: {properties: {$selected: true}}}, function(act, exp){return act==exp;});
        if(old[0]){
            $scope.changeIcon(old[0]);
        }
        var res = $filter('filter')(mapService.marks, {feature: {properties: {id: item.id}}}, function(act, exp){return act==exp;});
        res[0].togglePopup();
        mapService.map.setView(res[0].getLatLng(), 14);
        $scope.changeIcon(res[0]);
    };

    /*
     * repercute la selection d'un point sur la carte
     */
    $scope.selectPoint = function(item){
        // changement d'état du point précédemment sélectionné
        configServ.get('listSite:ngTable:orderedData', function(data){
            var cnt = data.length;
            var res = $filter('filter')(data, {id: item.feature.properties.id});
            var idx = data.indexOf(res[0]);
            var pg = idx / $scope.tableParams.count();
            $scope.tableParams.page(Math.ceil(pg) || 1);

        });
        var old = $filter('filter')(mapService.marks, {feature: {properties: {$selected: true}}}, function(act, exp){return act==exp;});
        if(old[0]){
            $scope.changeIcon(old[0]);
        }
        $scope.changeIcon(item);
    }


    /*
     * change la couleur d'un point sur la carte et dans la liste
     * lorsqu'il est sélectionné
     */
    $scope.changeIcon = function(item){
        item.feature.properties.$selected = !item.feature.properties.$selected;
        if(item.feature.properties.$selected){
            item.setIcon(L.icon({iconUrl: 'js/lib/leaflet/images/marker-icon-rouge.png'}));
        }
        else{
            item.setIcon(L.icon({iconUrl: 'js/lib/leaflet/images/marker-icon.png'}));
        }
    }
});


/*
 * controleur pour l'affichage basique des détails d'un site
 */
app.controller('siteDetailController', function($scope, $filter, $routeParams, dataServ, configServ, mapService){

    $scope._appName = $routeParams.appName;

    // chargement des données sites <- dataServ.get(chiro/site/:id)
    $scope.setSites = function(resp){
        $scope.data= angular.copy(resp);

        //affichage du type de lieu en fonction de son type_id
        var field = $filter('filter')($scope.schema.formSite, {name: 'typeId'}, function(act, exp){return act==exp});
        var label = $filter('filter')(field[0].options.choices, {id: $scope.data.properties.typeId}, function(act, exp){
            return act==exp;
        });
        $scope.data.properties.typeId = label[0].libelle;
        mapService.map.setView([$scope.data.geometry.coordinates[1], $scope.data.geometry.coordinates[0]], 14);
        dataServ.get($scope._appName + '/observation/site/' + $routeParams.id, $scope.setObs);
    };

    $scope.setObs = function(resp){
        $scope.observations = angular.copy(resp);
    }

    // chargement du schéma <- dataServ.get(chiro/siteForm)
    $scope.setSchema = function(resp){
        $scope.schema = angular.copy(resp);
        $scope.schema.detailSite.Informations.shown = true;

        // récupération des données à afficher
        dataServ.get($scope._appName + '/site/' + $routeParams.id, $scope.setSites);
    };

    $scope.select_group = function(group){
        angular.forEach($scope.schema.detailSite.__groups__, function(grp){
            $scope.schema.detailSite[grp].shown = false;
        });
        $scope.schema.detailSite[group].shown = true;
    };

    $scope.$on('$destroy', function(){});
    // récupération de la configuration d'affichage
    configServ.getUrl($scope._appName + '/siteConfig', $scope.setSchema, function(err){console.log(err);}, true);
});





/*
 * controleur pour l'édition d'un site
 */
app.controller('siteEditController', function($scope, $rootScope, $routeParams, $location, $filter, dataServ, mapService, configServ){

    $scope._appName = $routeParams.appName;

    $scope.ref = {type: 'Feature', properties: {}, geometry: {type:'Point', coordinates: [3.593666, 44.323187]}};
    // enregistrement du schéma <- dataServ.get(chiro/siteForm)
    $scope.setSchema = function(resp){
        $scope.schema = resp;
        $scope._init_interface();
    };

    // remplace les données de référence issues du cache
    // par des données issues du serveur
    $scope.setData = function(resp){
        $scope.data.properties = resp.properties;
        $scope.data.properties.siteDate = $scope.data.properties.siteDate.replace(/^(\d+)-(\d+)-(\d+).*$/i, "$3/$2/$1");
        $scope.data.geometry = resp.geometry;
    };

    // met à jour les coordonnées affichées en fonction du déplacement du point sur la carte
    $scope.updatePos = function(mark){
        $scope.data.geometry.coordinates[0] = mark.getLatLng().lng;
        $scope.data.geometry.coordinates[1] = mark.getLatLng().lat;
    };


    // initialisation de l'interface
    $scope._init_interface = function(){
        if($routeParams.id){
            // récupération des données à traiter
            $scope.ref = dataServ.getFromCache($scope._appName + '/site', {properties: {id: $routeParams.id}});
            dataServ.get($scope._appName + '/site/' + $routeParams.id, $scope.setData, function(err){console.log(err);}, true);

        }

        // initialisation du formulaire
        $scope.data = angular.copy($scope.ref);
        for(idx in $scope.schema.formSite){
            var_ = $scope.schema.formSite[idx];
            if($scope.data.properties[var_.name] == undefined){
                $scope.data.properties[var_.name] = var_.default != undefined ? var_.default: '';
                if(var_.type=='date'){
                    $scope.data.properties[var_.name] = new Date().toISOString().replace(/^(\d+)-(\d+)-(\d+).*$/i, "$3/$2/$1");
                }
            }
        }

        $scope.tmpLayer = L.layerGroup();
        $scope.marker = L.marker(
            L.latLng(
                $scope.ref.geometry.coordinates[1],
                $scope.ref.geometry.coordinates[0]), {draggable: true});

        $scope.marker.on('dragend', function(ev){
            // evenement lancé lorsque le point est déplacé et relaché
            $rootScope.$apply($scope.updatePos(ev.target));
        });
        $scope.marker.addTo($scope.tmpLayer);
        mapService.map.addLayer($scope.tmpLayer);
        mapService.map.setView($scope.marker.getLatLng(), 14);
    };

    
    $scope.remove = function(){
        if(confirm('Attention, cette action supprimera ce site définitivement !\nPensez aux habitants avant de confirmer')){
            dataServ.delete($scope._appName + '/site/'+$routeParams.id, $scope.deleted);
        }
    };

    $scope.deleted = function(resp){
        //TODO remplacer debug par un service de messagerie
        $scope.debug = resp;

        $scope.clear();

        dataServ.forceReload = true;
        $location.path($scope._appName + '/site');
    }

    /*
     * enregistrement des données
     */
    $scope.save = function(){
        if($scope.data.properties.id == ''){
            dataServ.put($scope._appName + '/site', $scope.data, function(resp, status){
                $scope.updateClear();
                dataServ.forceReload = true;
                $location.path($scope._appName + '/site');
            }, function(resp, status){
                $scope.errors = resp;
            });
        }
        else{
            //$scope.debug = $scope.data;
            dataServ.post($scope._appName + '/site/'+$scope.data.properties.id, angular.copy($scope.data), function(resp, status){
                // succès de l'ajout/mise à jour

                //TODO remplacer debug par un service de messagerie
                $scope.errors = resp;

                // Mise à jour des données de la liste
                $scope.updateClear();
                dataServ.forceReload = true;
                $location.path($scope._appName + '/site');

            }, function(resp, status){
                // échec de l'ajout/mise à jour
                //TODO remplacer debug par un service de messagerie
                $scope.debug = status;   
            });
        }
    };

    /*
     * mise à jour des données et nettoyage
     */
    $scope.updateClear = function(){
        // mise à jour des données de référence
        $scope.ref.properties = $scope.data.properties;
        // Mise à jour du point sur la carte
        var _mark = mapService.getMarker($scope.data.properties.id);
        if(_mark){
            $scope.ref.geometry= $scope.data.geometry;
            _mark.setLatLng([$scope.data.geometry.coordinates[1], $scope.data.geometry.coordinates[0]]); 
        }
        $scope.clear();
    };

    $scope.clear = function(){
        // suppression du layer temporaire
        $scope.tmpLayer.removeLayer($scope.marker);
        mapService.map.removeLayer($scope.tmpLayer);
    }
    
    $scope.$on('$destroy', $scope.clear); 

    // initialisation du formulaire
    configServ.getUrl($scope._appName + '/siteConfig', $scope.setSchema);

});

