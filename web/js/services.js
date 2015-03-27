var app = angular.module('suiviProtocole', ['ngRoute', 'ngTable']);


/*
 * Service de gestion des communications avec le serveur
 */
app.service('dataServ', function($http, $filter){
    //cache de données pour ne pas recharger systématiquement les données du serveur
    var cache = {};

    //flag ordonnant la recharge des données plutôt que l'utilisation du cache
    this.forceReload = false;

    this.get = function(url, success, error=function(err){console.log(err);}, force=false){
        // ne recharger les données du serveur que si le cache est vide ou 
        // si l'option force est true
        if(cache[url] == undefined || force || this.forceReload){
            $http.get(url)
                .then(function(data){
                    this.forceReload = false;
                    cache[url] = data.data;
                    success(data.data);
                },
                error);
        }
        else{
            success(cache[url]);
        }
    };

    this.post = function(url, data, success, error){
        $http.post(url, data).success(success).error(error || function(err){console.log(err);});
    };

    this.put = function(url, data, success, error){
        $http.put(url, data).success(success).error(error || function(err){console.log(err);});
    };

    this.delete = function(url, success, error){
        $http.delete(url).success(success).error(error || function(err){console.log(err);});
    };
        

    this.addToCache = function(cacheName, obj){
        cache[cacheName].push(obj);
    };

    this.getFromCache = function(cacheName, path){
        var res = $filter('filter')(cache[cacheName], path, function(act, exp){return act==exp;});
        if(res){
            return res[0];
        }
        return null;
    };

    this.getCacheLength = function(cachename){
        if(cache[cachename]){
            return cache[cachename].length;
        }
        return 0;
    };
});


/*
 * Service de récupération et stockage des configurations
 */
app.service('configServ', function(dataServ){
    var cache = {};

    this.getUrl = function(serv, success){
        if(cache[serv]){
            success(cache[serv]);
        }
        else{
            dataServ.get(serv, function(resp){
                cache[serv] = resp;
                success(cache[serv]);
            });
        }
    };

    this.get = function(key, success){
        success(cache[key]);
    };

    this.put = function(key, data){
        cache[key] = data;
    };
});


/*
 * Service de gestion de la carte leaflet
 */
app.service('mapService', function($rootScope, $filter){
    // conteneur pour les points de la carte
    this.marks = [];

    this.map = L.map('map').setView([44.34, 3.5858], 10);

    var tiles = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png');
    this.map.addLayer(tiles);

    this.markLayer = new L.markerClusterGroup({disableClusteringAtZoom: 13});
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

    this.clear = function(){
        this.marks = [];
        this.markLayer.clearLayers();
    }
    
    this.getMarker = function(_id){
        var res = $filter('filter')(this.marks, {feature: {properties: {id: _id}}}, function(act, exp){return act==exp;});
        try{
            return res[0];
        }
        catch(e){
            return null;
        }
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
            return input;
        }
    }
});


app.directive('xhrinput', function(){
    return {
        restrict: 'E',
        scope: {
            url: '=',
            initial: '=',
            target: '='
        },
        templateUrl: 'js/templates/xhrinput.htm',
        controller: function($scope, dataServ){
            $scope.target = $scope.initial;
            $scope.find = function(){
                if($scope._input.length>1){
                    $scope.show = true;
                    dataServ.post($scope.url, {label: $scope._input}, function(resp){
                        $scope.hints = resp;
                    });
                }
            };
            $scope.select = function(idx){
                $scope.show = false;
                $scope._input = $scope.hints[idx].label;
                $scope.target = $scope.hints[idx].id;
            };
            dataServ.post($scope.url, {id: $scope.initial}, function(resp){
                $scope._input = resp.label;
            });
        }
    }
});
