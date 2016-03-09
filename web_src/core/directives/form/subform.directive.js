angular.module('FormDirectives').directive('subform', function(){
    return {
        restrict: 'E',
        scope: {
            refer: '=',
            schema: '=',
        },
        templateUrl: 'js/templates/form/subform.htm',
        controller: ['$scope', function($scope){
            if($scope.refer == undefined){
                $scope.refer = [{}];
            }
            
            $scope.$watch(function(){return $scope.refer}, function(nv, ov){
                if(nv !== ov){
                    $scope.refer = nv; 
                }
            });
            
            $scope.add_item = function(){
                $scope.refer.push({});
            };

            $scope.remove_item = function(idx){
                $scope.refer.splice(idx, 1);
            };
        }]
    };
});

