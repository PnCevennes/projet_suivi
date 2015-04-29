var app = angular.module('appSuiviProtocoles', ['baseSites', 'baseObservations', 'baseTaxons', 'biometrie', 'suiviProtocoleServices', 'FormDirectives', 'DisplayDirectives', 'angucomplete', 'ui.bootstrap', 'darthwade.loading']);

// module de gestion des sites
angular.module('baseSites', ['suiviProtocoleServices', 'ngRoute', 'ngTable']);

// module de gestion des observations
angular.module('baseObservations', ['suiviProtocoleServices', 'ngRoute', 'ngTable']);

// module de gestion des taxons
angular.module('baseTaxons', ['suiviProtocoleServices', 'ngRoute', 'ngTable']);

// module de gestion des biometries
angular.module('biometrie', ['suiviProtocoleServices', 'ngRoute']);

// services de l'application
angular.module('suiviProtocoleServices', []);

// directives formulaires
angular.module('FormDirectives', ['angularFileUpload']);

// directives affichage
angular.module('DisplayDirectives', []);


/*
 * Configuration des routes
 */
app.config(function($routeProvider){
    $routeProvider
        .when('/', {
            controller: 'baseController',
            templateUrl: 'js/templates/index.htm'
        })
        .when('/login', {
            controller: 'loginController',
            templateUrl: 'js/views/login.htm',
        })
        .when('/logout', {
            controller: 'logoutController',
            templateUrl: 'js/templates/index.htm'
        })
        .otherwise({redirectTo: '/'});
});


/*
 * Controleur de base
 */
app.controller('baseController', function($scope, dataServ, configServ, mapService, userMessages){
    $scope.success = function(resp){
        $scope.data = resp;
        $scope.showMap = false;
        $scope.user = null;
        configServ.put('debug', true);
        configServ.put('app', $scope.data[0]);
        userMessages.infoMessage = "bienvenue !";
        $scope._appName = $scope.data[0].name;

        $scope.$on('user:login', function(ev, user){
            $scope.user = user;
        });

        $scope.$on('user:logout', function(ev){
            $scope.user = null;
        });

        $scope.$on('map:show', function(ev){
            $scope.showMap = true;
        });

        $scope.$on('map:hide', function(ev){
            $scope.showMap = false;
        });


    };
    dataServ.get('config/apps', $scope.success);
});


/*
 * controleur login
 */
app.controller('loginController', function($scope, $location, $rootScope, dataServ, configServ, userMessages){
    $scope.data = {
        login: '',
        pass: '',
        idApp: 100, //FIXME
    };
    $rootScope.$broadcast('map:hide');

    $scope.login = function(resp){
        configServ.put('loggedUser', resp);
        userMessages.infoMessage = resp.nomComplet.replace(/(\w+) (\w+)/, 'Bienvenue $2 $1 !');
        $rootScope.$broadcast('user:login', resp);
        $location.path('chiro/site'); //FIXME
    };

    $scope.send = function(){
        dataServ.post('users/login', $scope.data, $scope.login);
    };
});


/*
 * controleur logout
 */
app.controller('logoutController', function($scope, $rootScope, $location, dataServ, configServ, userMessages){
    $scope.logout = function(resp){
        configServ.put('loggedUser', null);
        userMessages.infoMessage = "Tchuss !";
        $rootScope.$broadcast('user:logout');
        $location.path('login');
    };

    dataServ.get('users/logout', $scope.logout);
});
