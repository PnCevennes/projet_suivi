var app = angular.module('suiviProtocoleDirectives');


/**
 * fonction qui renvoie le label associé à un identifiant
 * paramètres : 
 *  xhrurl ->url du  service web
 *  inputid -> identifiant de l'élément
 * return : label
 */
app.directive('xhrdisplay', function(){
    return {
        restrict: 'E',
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
                dataServ.post($scope.xhrurl, {id: newval}, $scope.setResult);
            });
        }
    };
});


/**
 * directive de type champ input qui permet à l'utilisateur de selectionner un élément à partir d'une recherche textuelle (autocompletion)
 * fonctions : 
 *  params :
 *      url : l'url à contacter pour obtenir les données (doit renvoyer une liste de dictionnaires {id: ?, label: ?})
 *      initial : la valeur d'initialisation (un ID)
 *      target : la donnée cible de la directive (eq. ng-model)
 *  find : interrogation du serveur 
 *      return liste identifiant
 *  select : selection d'un item dans la liste renvoyée par le serveur. Stocke cette valeur dans la propriété target
 */
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
            //FIXME
            $scope.target = angular.copy($scope.initial);
            $scope.find = function(){
                if($scope._input.length){
                    $scope.show = true;
                    dataServ.post($scope.url, {label: $scope._input}, function(resp){
                        $scope.hints = resp;
                    });
                }
                else{
                    $scope.show = false;
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


/**
 * génération automatique de formulaire à partir d'un json qui représente le schéma du formulaire
 * params:
 *  schema: le squelette du formulaire (cf. doc schémas)
 *  data: le dictionnaire de données source/cible
 *  onsave: la callback de sauvegarde du controleur
 *  onremove: la callback de suppression du controleur
 *  errors: liste d'erreurs de saisie (dictionnaire {nomChamp: errMessage})
 */
app.directive('dynform', function(){
    return {
        restrict: 'E',
        scope: {
            schema: '=',
            data: '=',
            onsave: '=',
            onremove: '=',
            errors: '=',
        },
        templateUrl: 'js/templates/dynform.htm',
        controller: function($scope){
            $scope.save = function(){
                $scope.onsave();
            };

            $scope.remove = function(){
                $scope.onremove();
            }
        },
    };
});


/**
 * génération d'un champ formulaire de type multivalué
 * params:
 *  refer: la valeur source/cible du champ (une liste)
 *  schema: le schema descripteur du champ (cf. doc schemas)
 */
app.directive('multi', function(){
    return {
        restrict: 'E',
        scope: {
            refer: '=',
            schema: '=',
        },
        templateUrl: 'js/templates/multi.htm',
        controller: function($scope){
            $scope.$watch(function(){return $scope.refer;}, function(newval, oldval){
                $scope.data = $scope.refer;
            });
            $scope.add = function(){
                $scope.data.push(null);
            };
            $scope.remove = function(idx){
                $scope.data.splice(idx, 1);
            };
        }
    }
});


/*
 * Directive qui permet d'avoir un champ de formulaire de type fichier et qui l'envoie au serveur
 * envoie un fichier au serveur qui renvoie un identifiant de création.
 * params:
 *  fileids: la valeur source/cible du champ (liste d'identifiants)
 */
app.directive('fileinput', function(){
    return {
        restrict: 'E',
        scope: {
            fileids: '='
        },
        templateUrl: 'js/templates/fileinput.htm',
        controller: function($scope, $rootScope, $upload){
            if($scope.fileids == undefined){
                scope.fileids = [];
            }
            $scope.delete_file = function(f_id){
                alert('TODO');
            };
            $scope.$watch('upload_file', function(){
                $scope.upload($scope.upload_file);
            });
            $scope.upload = function(files){
                angular.forEach(files, function(item){
                    $scope.lock = true;
                    $upload.upload({
                        url: '/upload',
                        file: item,
                        })
                        .progress(function(evt){
                            $scope.progress = parseInt(100.0 * evt.loaded / evt.total);    
                        })
                        .success(function(data){
                            $scope.fileids.push(data.id);
                            $scope.lock = false;
                        });
                });
            };
        }
    }
});


/**
 * Directive qui permet d'avoir un champ de formulaire de type valeur calculée modifiable
 * params: 
 *  data: la source de données du champ (une liste de références aux champs servant au calcul)
 *  refs: une liste du nom des champs à surveiller
 *  model: la source/cible du champ (eq. ng-model)
 *  modifiable: bool -> indique si le champ est modifiable ou en lecture seule
 */
app.directive('calculated', function(){
    return {
        restrict: 'E',
        scope: {
            data: '=',
            refs: '=',
            model: '=',
            modifiable: '=',
        },
        template: '<input type="number" ng-model="model" ng-disabled="!modifiable"/>',
        controller: function($scope){
            angular.forEach($scope.refs, function(elem){
                $scope.$watch(function(){
                    return $scope.data[elem];
                }, function(newval, oldval){
                    //$scope.model += newval-oldval;
                    //if($scope.model<0) $scope.model=0;
                    $scope.model = 0;
                    angular.forEach($scope.refs, function(elem){
                        $scope.model += $scope.data[elem];
                    }, $scope);
                });
            }, $scope);
        }
    }
});

