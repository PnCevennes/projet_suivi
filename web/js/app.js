var app = angular.module('suiviProtocole', []);

app.controller('baseController', function($scope, $http){
    $scope.url = 'chiro/site'
    $scope.getData = function(){
        $http.get($scope.url).then(function(resp){
            $scope.data = resp.data;
        }, function(err){
            $scope.data = resp.err;   
        });
    };
});

