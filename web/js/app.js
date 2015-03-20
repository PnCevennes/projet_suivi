var app = angular.module('suiviProtocole', ['ngRoute', 'ngTable']);


/*
 * Configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/', {
            controller: 'baseController',
            templateUrl: 'js/templates/index.htm'
        })
        .when('/chiro/site', {
            controller: 'siteController',
            templateUrl: 'js/templates/siteList.htm'
        })
        .when('/chiro/edit/site/:id', {
            controller: 'siteEditController',
            templateUrl: 'js/templates/siteEdit.htm'
        })
        .when('/chiro/site/:id', {
            controller: 'siteDetailController',
            templateUrl: 'js/templates/siteDetail.htm'
        })
        .otherwise({redirectTo: '/'});
});


/*
 * Service de gestion des communications avec le serveur
 */
app.service('dataServ', function($http, $filter){
    //cache de données pour ne pas recharger systématiquement les données du serveur
    var cache = {};
    this.get = function(url, success, force){
        // ne recharger les données du serveur que si le cache est vide ou 
        // si l'option force est true
        console.log('GET ' + url);
        if(cache[url] == undefined || force){
            $http.get(url).then(function(data){
                cache[url] = data.data;
                success(data.data);
            }
            , function(err){});
        }
        else{
            success(cache[url]);
        }
    };

    this.post = function(url, data, success){};

    this.put = function(url, data, success){};

    this.delete = function(url, success){};
        

    this.addToCache = function(cacheName, obj){
        cache[cacheName].push(obj);
    };

    this.getFromCache = function(cacheName, path){
        var res = $filter('filter')(cache[cacheName], path, function(act, exp){return act==exp;});
        console.log(res);
        if(res){
            return res[0];
        }
        return null;
    }
});


/*
 * Service de gestion de la carte leaflet
 */
app.service('mapService', function($rootScope){
    // conteneur pour les points de la carte
    this.marks = [];

    this.map = L.map('map').setView([44.34, 3.5858], 10);

    var tiles = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png');
    this.map.addLayer(tiles);

    this.markLayer = new L.markerClusterGroup();
    this.map.addLayer(this.markLayer);


    /*
     * ajoute un point à la carte
     */
    this.addPoint = function(point){
        this.markLayer.addLayer(point);
        this.marks.push(point);
    };


    /*
    * retire tous les points de la carte et n'affiche que les points dont
    * les ids sont fournis
    */
    this.filterMarks = function(ids){
        this.markLayer.clearLayers();
        angular.forEach(this.marks, function(mark){
            if(ids.indexOf(mark.feature.properties.id)!=-1){
                this.markLayer.addLayer(mark);
            }
        }, this);
    };

});


/*
 * filtre basique - transforme une date yyyy-mm-dd en dd/mm/yyyy pour l'affichage
 */
app.filter('datefr', function(){
    return function(input){
        try{
            return input.replace(/^(\d+)-(\d+)-(\d+).*$/i, "$3/$2/$1");
        }
        catch(e){
            return '';
        }
    }
});


/*
 * controleur pour la carte et la liste des sites
 */
app.controller('siteController', function($scope, $rootScope, $filter, dataServ, ngTableParams, mapService){

    $scope.success = function(resp){
        var data=[];
        $scope.items = resp;
        mapService.markLayer.clearLayers();
        angular.forEach(resp, function(item){
            //mapService.markLayer.addData(item);
            var mark = L.marker(L.latLng([item.geometry.coordinates[1], item.geometry.coordinates[0]]));
            mark.bindPopup('<h6>' + item.properties.siteNom + '</h6>');
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
            count: 20,
            filter: {},
            sorting: {}
        },
        {
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
                angular.forEach(orderedData, function(item){
                    ids.push(item.id);
                });
                mapService.filterMarks(ids);
                params.total(orderedData.length); // set total for recalc pagination
                $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
            } 
        });

        $scope.data = data;
        $scope.tableParams.reload();
    };

    
    dataServ.get('chiro/site', $scope.success);

    /*
     * evenements
     */
    $scope.$on('mapService:itemClick', function(ev, item){
        $scope.changeIcon(item);
    });


    /*
     * repercute la sélection d'un point dans la liste
     */
    $scope.selectPoint = function(item){
        var res = $filter('filter')(mapService.marks, {feature: {properties: {id: item.id}}}, function(act, exp){return act==exp;});
        res[0].togglePopup();
        mapService.map.setView(res[0].getLatLng(), 14);
        $scope.changeIcon(res[0]);
    };


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
app.controller('siteDetailController', function($scope, $routeParams, dataServ){
    // enregistrement des données <- dataServ.get(chiro/site/:id)
    $scope.setData = function(resp){
        $scope.data = {};
        $scope.data.properties = resp.properties;
    };

    // enregisrement du schéma <- dataServ.get(chiro/config)
    $scope.setSchema = function(resp){
        $scope.schema = resp;
    };

    // récupération de la configuration d'affichage
    dataServ.get('chiro/config', $scope.setSchema);

    // récupération des données à afficher
    dataServ.get('chiro/site/' + $routeParams.id, $scope.setData);
});


/*
 * controleur pour l'édition d'un site
 */
app.controller('siteEditController', function($scope, $rootScope, $routeParams, $location, dataServ, mapService){

    // enregistrement du schéma <- dataServ.get(chiro/config)
    $scope.setSchema = function(resp){
        $scope.schema = resp;
    };


    // récupération de la configuration d'affichage
    dataServ.get('chiro/config', $scope.setSchema);

    // récupération des données à traiter
    $scope.ref = dataServ.getFromCache('chiro/site', {properties: {id: $routeParams.id}});

    console.log($scope.ref);

    //TODO faire une copie plus profonde
    $scope.data = {};
    $scope.data.properties = angular.copy($scope.ref.properties);
    $scope.data.geometry = angular.copy($scope.ref.geometry);

    var tmpLayer = L.layerGroup();
    var marker = L.marker(
        L.latLng(
            $scope.data.geometry.coordinates[1],
            $scope.data.geometry.coordinates[0]), {draggable: true});

    marker.on('dragend', function(ev){
        // evenement lancé lorsque le point est déplacé et relaché
        $rootScope.$apply($scope.updatePos(ev.target));
    });
    marker.addTo(tmpLayer);
    mapService.map.addLayer(tmpLayer);

    $scope.updatePos = function(mark){
        $scope.data.geometry.coordinates[0] = mark.getLatLng().lng;
        $scope.data.geometry.coordinates[1] = mark.getLatLng().lat;
    }
    
    /*
     * enregistrement des données
     */
    $scope.save = function(){
        if($scope.data.properties.id == undefined){
            /*
            dataServ.put('chiro/site', $scope.data, function(resp){
                //TODO
            });
            */
        }
        else{
            /*
            dataServ.post('chiro/site/'+$scope.data.properties.id, $scope.data, function(resp){
                //TODO
            });
            */
        }
        $scope.ref.properties = $scope.data.properties;
        //$scope.ref.geometry = $scope.data.geometry;
        tmpLayer.removeLayer(marker);
        mapService.map.removeLayer(tmpLayer);
        
        $location.path('/chiro/site');
    };

});

app.controller('baseController', function($scope, dataServ, mapService){
    $scope.success = function(resp){
        $scope.data = resp;
    };
    dataServ.get('config/apps', $scope.success);
});

