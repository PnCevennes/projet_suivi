#Filterform

Directive de filtrage et pagination des données

##Usage

template:

```html
    <div ng-controller="testCtrl">
        <filterform url="{{data_url}}" schema="schema.filtering" callback="setData"></filterform>
        <div tablewrapper schema="__schema__" data="__data__" refname="test">
            <h1>Titre de la liste</h1>
        </div>
    </div>
```

controleur:

```javascript
    app.controller('testCtrl', function($scope, $http){
        $scope.data_url = 'url/data';

        var setData = function(resp){
            $scope.__data__ = resp;
        }

        var setSchema = function(resp){
            $scope.__schema__ = resp.data;
        };

        $http.get('url/schema').success(setSchema);
    });
```


##Parametres


###url

url à contacter pour récupérer les données


###schema 

objet javascript représentant le schéma de filtrage

le schéma de filtrage est une section du schéma général d'initialisation de la directive **tablewrapper**


###callback

fonction de rappel du controleur pour passer les données filtrées
