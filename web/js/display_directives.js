var app = angular.module('DisplayDirectives');


/**
 * Directive pour l'affichage des messages utilisateur en popover
 */
app.directive('usermsg', function(userMessages, $timeout){
    return {
        restrict: 'A',
        templateUrl: 'js/templates/modalMsg.htm',
        controller: function($scope){
            $scope.hideMsg=true;
            $scope.$watch(
                function(){return userMessages.infoMessage},
                function(newval){
                    console.log(newval);
                    $scope.userMessage = newval;
                    if(newval){
                        $scope.hideMsg=false;
                        $timeout(function(){
                            $scope.hideMsg=true;
                        }, 3500);
                    }
                }
            );
        }
    };
});


/**
 * fonction qui renvoie le label associé à un identifiant
 * paramètres : 
 *  xhrurl ->url du  service web
 *  inputid -> identifiant de l'élément
 */
app.directive('xhrdisplay', function(){
    return {
        restrict: 'A',
        scope: {
            inputid: '=',
            xhrurl: '=',
        },
        template: '{{value}}',
        controller: function($scope, dataServ){
            $scope.setResult = function(resp){
                $scope.value = resp.label;
            };
            $scope.$watch(function(){return $scope.inputid}, function(newval, oldval){
                if(newval){
                    dataServ.get($scope.xhrurl + '/' + newval, $scope.setResult);
                }
            });
        }
    };
});


app.directive('detailDisplay', function(){
    return{
        restrict: 'A',
        scope: {
            schemaUrl: '@schemaurl',
            dataUrl: '@dataurl',
            updateUrl: '@updateurl',
            dataId: '@dataid'
        },
        templateUrl: 'js/templates/display/detail.htm',
        controller: function($scope, $rootScope, dataServ, configServ){
            $scope.setSchema = function(resp){
                $scope.schema = angular.copy(resp);
                //récupération des données
                dataServ.get($scope.dataUrl, $scope.setData);
            };

            $scope.setData = function(resp){
                $scope.data = angular.copy(resp);

                // envoi des données vers le controleur
                $rootScope.$broadcast('display:init', $scope.data);

                // si le schema a un sous-schema (sous-protocole)
                // récupération du sous-schema
                if($scope.schema.subSchemaUrl){
                    configServ.getUrl($scope.schema.subSchemaUrl, $scope.setSubSchema);
                }
            }

            $scope.setSubSchema = function(resp){
                $scope.subSchema = angular.copy(resp);
                // récupération des données liées au sous-schéma (sous-protocole)
                dataServ.get($scope.schema.subDataUrl + $scope.dataId, $scope.setSubData);
            }

            $scope.setSubData = function(resp){
                $scope.subData = angular.copy(resp);
            }

            // récupération du schéma
            configServ.getUrl($scope.schemaUrl, $scope.setSchema);
        }
    }
});


app.directive('fieldDisplay', function(){
    return {
        restrict: 'A',
        scope: {
            field: '=',
            data: '=',
        },
        templateUrl: 'js/templates/display/field.htm',
        controller: function(){}
    };
});


app.directive('breadcrumbs', function(){
    return {
        restrict: 'A',
        templateUrl: 'js/templates/display/breadcrumbs.htm',
        controller: function($scope, configServ){
            console.log(configServ.bc);
            $scope.data = configServ.bc;
        },
    };
});
