var app = angular.module('appSuiviProtocoles', ['generiques', 'baseSites', 'baseObservations', 'baseTaxons', 'baseValidation', 'biometrie', 'suiviProtocoleServices', 'FormDirectives', 'DisplayDirectives', 'ui.bootstrap', 'darthwade.loading', 'SimpleMap', 'LocalStorageModule', 'ngTableResizableColumns']);

// generiques
angular.module('generiques', ['suiviProtocoleServices', 'SimpleMap', 'ngRoute', 'ngTable']);

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

app.config(function (localStorageServiceProvider) {
    localStorageServiceProvider.setPrefix('projetSuivis');
})

/*
 * Controleur de base
 */
app.controller('baseController', function($scope, $location, dataServ, configServ, mapService, userMessages, userServ){
    $scope._appName = null;
    $scope.app = {name: "Suivi des protocoles", menu: []};
    $scope.success = function(resp){
        $scope.user = userServ.getUser();
        if(!$scope.user){
            $location.url('login');
        }
        $scope.data = resp;

        // FIXME DEBUG
        configServ.put('debug', true);
        /*
        userServ.login('as_test', 'test');
        */
        
        //configServ.put('app', $scope.data[0]);
        //$scope._appName = $scope.data[0].name;

        $scope.$on('user:login', function(ev, user){
            $scope.user = user;
            
            var app = userServ.getCurrentApp();
            if(!app){
                $location.url('apps');
            }
            else{
                $scope.app = app;
                if($location.path() == '/'){
                    $scope.setActive(app.menu[0]);
                    $location.url(app.menu[0].url.slice(2));
                }
            }
        });

        $scope.$on('user:logout', function(ev){
            $scope.app = {name: "Suivi des protocoles", menu: []};
            $scope.user = null;
        });

        $scope.$on('app:select', function(ev, app){
            $scope.app = app;
            $scope.setActive(app.menu[0]);
        });

        $scope.$on('app:selection', function(ev){
            $scope.app = {name: "Suivi des protocoles", menu: []};
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
        userServ.setCurrentApp($scope.app);
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

    $scope.$on('user:login', function(ev, user){
        userMessages.infoMessage = user.nom_complet.replace(/(\w+) (\w+)/, 'Bienvenue $2 $1 !');
        
        $location.url('apps'); 
    });

    $scope.$on('user:error', function(ev){
        userMessages.errorMessage = "Erreur d'identification."
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

    $scope.$emit('app:selection');

    $scope.setData = function(resp){
        $scope.apps = resp;
    };

    $scope.select = function(id){
        $scope.apps.forEach(function(item){
            if(item.id == id){
                userServ.setCurrentApp(item);
                $scope.$emit('app:select', item);
            }
        });
    };

    configServ.getUrl('config/apps', $scope.setData);
});
