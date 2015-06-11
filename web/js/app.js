var app = angular.module('appSuiviProtocoles', ['baseSites', 'baseObservations', 'baseTaxons', 'baseValidation', 'biometrie', 'suiviProtocoleServices', 'FormDirectives', 'DisplayDirectives', 'ui.bootstrap', 'darthwade.loading', 'SimpleMap']);

// module de gestion des sites
angular.module('baseSites', ['suiviProtocoleServices', 'SimpleMap', 'ngRoute', 'ngTable']);

// module de gestion de la validation
angular.module('baseValidation', ['suiviProtocoleServices', 'SimpleMap', 'ngRoute', 'ngTable']);

// module de gestion des observations
angular.module('baseObservations', ['suiviProtocoleServices', 'SimpleMap', 'ngRoute', 'ngTable']);

// module de gestion des taxons
angular.module('baseTaxons', ['suiviProtocoleServices', 'ngRoute', 'ngTable']);

// module de gestion des biometries
angular.module('biometrie', ['suiviProtocoleServices', 'ngRoute']);

// services de l'application
angular.module('suiviProtocoleServices', ['SimpleMap']);

// directives formulaires
angular.module('FormDirectives', ['angularFileUpload', 'SimpleMap']);

// directives affichage
angular.module('DisplayDirectives', ['SimpleMap']);

// directives map
angular.module('SimpleMap', ['suiviProtocoleServices']);


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
        .when('/apps', {
            controller: 'appsController',
            templateUrl: 'js/views/appSelection.htm'
        })
        .otherwise({redirectTo: '/'});
});


/*
 * Controleur de base
 */
app.controller('baseController', function($scope, $location, dataServ, configServ, mapService, userMessages, userServ){
    $scope._appName = null;
    $scope.app = {name: "Suivi des protocoles", menu: []};
    $scope.user = userServ.getUser();
    configServ.bcShown = false;
    if(!$scope.user){
        $location.url('login');
    }
    $scope.success = function(resp){
        $scope.data = resp;

        // FIXME DEBUG
        configServ.put('debug', true);
        /*
        userServ.login('as_test', 'test');
        */
        
        //configServ.put('app', $scope.data[0]);
        userMessages.infoMessage = "bienvenue !";
        //$scope._appName = $scope.data[0].name;

        $scope.$on('user:login', function(ev, user){
            $scope.user = user;
            $location.url('apps');
        });

        $scope.$on('user:logout', function(ev){
            configServ.bcShown = false;
            $scope.app = {name: "Suivi des protocoles", menu: []};
            $scope.user = null;
        });

        $scope.$on('app:select', function(ev, app){
            configServ.bcShown = true;
            $scope.app = app;
            $scope.setActive(app.menu[0]);
        });

    };

    $scope.setActive = function(item){
        $scope.app.menu.forEach(function(elem){
            if(elem.url == item.url){
                elem.__active__ = true;
            }
            else{
                elem.__active__ = false;
            }
        });
    };

    $scope.check = function(val){
        return userServ.checkLevel(val); 
    };

    configServ.getUrl('config/apps', $scope.success);
});


/*
 * controleur login
 */
app.controller('loginController', function($scope, $location, $rootScope, userServ, userMessages, configServ){
    if(userServ.getUser()){
        $scope.data = {
            login: userServ.getUser().identifiant,
            pass: userServ.getUser().pass, 
        };
    }
    else{
        $scope.data = {login: null, pass: null};
    }
    configServ.bcShown = false;

    $scope.$on('user:login', function(ev, user){
        userMessages.infoMessage = user.nom_complet.replace(/(\w+) (\w+)/, 'Bienvenue $2 $1 !');
        
        configServ.bcShown = true;
        var curBc = configServ.getBc();
        $location.url('apps'); 
    });

    $scope.$on('user:error', function(ev){
        userMessages.errorMessage = "Erreur d'identification. Respirez un coup et recommencez."
    });

    $scope.send = function(){
        userServ.login($scope.data.login, $scope.data.pass);
    };
});


/*
 * controleur logout
 */
app.controller('logoutController', function($scope, $location, userServ, userMessages, configServ){
    $scope.$on('user:logout', function(ev){
        userMessages.infoMessage = "Tchuss !";
        var curBc = configServ.getBc();
        $location.url('login');
    });

    userServ.logout();
});


/*
 * controleur selection app
 */
app.controller('appsController', function($scope, $location, configServ, userServ){
    
    if(!userServ.getUser()){
        $location.url('login');
    }

    $scope.setData = function(resp){
        $scope.apps = resp;
    };

    $scope.select = function(id){
        $scope.apps.forEach(function(item){
            if(item.id == id){
                userServ.currentApp = item.appId;
                $scope.$emit('app:select', item);
            }
        });
    };

    configServ.getUrl('config/apps', $scope.setData);
});
