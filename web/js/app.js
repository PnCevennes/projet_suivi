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
        .otherwise({redirectTo: '/'});
});


/*
 * Controleur de base
 * TODO authentification
 */
app.controller('baseController', function($scope, dataServ, configServ, mapService, userMessages){
    $scope.success = function(resp){
        $scope.data = resp;
        $scope.user = {nomComplet: ''};
        configServ.put('debug', true);
        configServ.put('app', $scope.data[0]);
        userMessages.infoMessage = "bienvenue !";
        $scope._appName = $scope.data[0].name;

        $scope.$on('user:logged', function(ev, user){
            console.log(user);
            $scope.user = user;
        });
        //console.log($scope.data);
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
        idApp: 100,
    };

    $scope.login = function(resp){
        configServ.put('loggedUser', resp);
        userMessages.infoMessage = "Bienvenue " + resp.nomComplet;
        $rootScope.$broadcast('user:logged', resp);
        $location.path('chiro/site');
    }

    $scope.send = function(){
        dataServ.post('users/login', $scope.data, $scope.login);
    }
});
