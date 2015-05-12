var app = angular.module('appSuiviProtocoles', ['baseSites', 'baseObservations', 'baseTaxons', 'biometrie', 'suiviProtocoleServices', 'FormDirectives', 'DisplayDirectives', 'ui.bootstrap', 'darthwade.loading']);

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
app.controller('baseController', function($scope, dataServ, configServ, mapService, userMessages, userServ){
    $scope.success = function(resp){
        $scope.data = resp;
        $scope.showMap = false;
        $scope.user = null;

        // FIXME DEBUG
        configServ.put('debug', true);
        userServ.login('as_test', 'test', 100);

        
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
app.controller('loginController', function($scope, $location, $rootScope, userServ, userMessages, configServ){
    $scope.data = {
        login: userServ.getUser().identifiant,
        pass: userServ.getUser().pass,
        idApp: userServ.getUser().idApplication
    };
    $rootScope.$broadcast('map:hide');
    configServ.bcShown = false;

    $scope.$on('user:login', function(ev, user){
        userMessages.infoMessage = user.nomComplet.replace(/(\w+) (\w+)/, 'Bienvenue $2 $1 !');
        
        configServ.bcShown = true;
        var curBc = configServ.getBc();
        try{
            $location.path(curBc[curBc.length-1].url.slice(2));
        }
        catch(e){
            $location.path(''); //FIXME
        }
    });

    $scope.$on('user:error', function(ev){
        userMessages.errorMessage = "Erreur d'identification. Respirez un coup et recommencez."
    });

    $scope.send = function(){
        userServ.login($scope.data.login, $scope.data.pass, $scope.data.idApp);
    };
});


/*
 * controleur logout
 */
app.controller('logoutController', function($scope, $location, userServ, userMessages, configServ){
    $scope.$on('user:logout', function(ev){
        userMessages.infoMessage = "Tchuss !";
        var curBc = configServ.getBc();
        try{
            $location.path(curBc[curBc.length-1].url.slice(2));
        }
        catch(e){
            $location.path('login');
        }
    });

    userServ.logout();
});
