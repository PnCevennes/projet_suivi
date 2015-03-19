var app = angular.module('suiviProtocole', ['ngRoute', 'ngTable']);

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
        .when('/chiro/site/:id', {
            controller: 'siteDetailController',
            templateUrl: 'js/templates/siteDetail.htm'
        })
        .otherwise({redirectTo: '/'});
});

app.service('httpServ', function($http){
    //cache de données pour ne pas recharger systématiquement les données du serveur
    var cache = {};
    this.get = function(url, success, force){
        // ne recharger les données du serveur que si le cache est vide ou 
        // si l'option force est true
        if(cache[url] == undefined || force){
            $http.get(url).then(function(data){
                cache[url] = data;
                success(data);
            }
            , function(err){});
        }
        else{
            success(cache[url]);
        }
    };

    this.post = function(url, success){};

    this.put = function(url, success){};

    this.delete = function(url, success){};
});


app.service('mapService', function($rootScope){
    this.map = L.map('map').setView([44.34, 3.5858], 10);
    var tiles = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png');
    var marks = [];
    this.marks = marks;
    this.map.addLayer(tiles);
    /*
    this.markLayer = new L.geoJson([], {
        onEachFeature: function(feature, layer){
            marks.push(layer);
            layer.bindPopup('<h6>' + feature.properties.siteNom + '<h6>');
            layer.feature.properties.$selected = false;
            layer.on('click', function(e){
                $rootScope.$apply(
                    $rootScope.$broadcast('mapService:itemClick', layer)
                    );
                });
            }
        });
        */
    this.markLayer = new L.markerClusterGroup();

    this.addPoint = function(point){
        //ajoute un point à la carte
        this.markLayer.addLayer(point);
        this.marks.push(point);
    };

    this.filterMarks = function(ids){
        this.markLayer.clearLayers();
        angular.forEach(this.marks, function(mark){
            if(ids.indexOf(mark.feature.properties.id)!=-1){
                this.markLayer.addLayer(mark);
            }
        }, this);
    };

    this.map.addLayer(this.markLayer);
});

app.filter('datefr', function(){
    // filtre basique - transforme une date yyyy-mm-dd en dd/mm/yyyy pour l'affichage
    return function(input){
        return input.replace(/^(\d+)-(\d+)-(\d+).*$/i, "$3/$2/$1");
    }
});

app.controller('siteController', function($scope, $rootScope, $filter, httpServ, ngTableParams, mapService){

    $scope.success = function(resp){
        var data=[];
        $scope.items = resp.data;
        angular.forEach(resp.data, function(item){
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
    };

    
    httpServ.get('chiro/site', $scope.success);

    /*
     * evenements
     */
    $scope.$on('mapService:itemClick', function(ev, item){
        $scope.changeIcon(item);
    });

    $scope.selectPoint = function(item){
        var res = $filter('filter')(mapService.marks, {feature: {properties: {id: item.id}}}, function(act, exp){return act==exp;});
        res[0].togglePopup();
        console.log(res[0]);
        mapService.map.setView(res[0].getLatLng(), 14);
        $scope.changeIcon(res[0]);
    };

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


app.controller('siteDetailController', function($scope, $routeParams, httpServ){
    $scope.success = function(resp){
        $scope.data = resp.data;
    };
    httpServ.get('chiro/site/' + $routeParams.id, $scope.success);
});

app.controller('baseController', function($scope, httpServ, mapService){
    $scope.success = function(resp){
        $scope.data = resp.data;
    };
    httpServ.get('config/apps', $scope.success);
});

