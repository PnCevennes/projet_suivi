#tablewrapper

Directive encapsulant ng-table afin de gérer plus simplement les listes et les événements qui y sont liés.


##Usage

Exemple minimaliste

template:

```html
    <div ng-controller="testCtrl">
        <div tablewrapper schema="__schema__" data="__data__" refname="test">
            <h1>Titre de la liste</h1>
        </div>
    </div>
```

controleur:

```javascript
    app.controller('testCtrl', function($scope, $http){
        var setData = function(resp){
            $scope.__data__ = resp.data;
        };

        var setSchema = function(resp){
            $scope.__schema__ = resp.data;
            $http.get('url/data').success(setData);
        };

        $http.get('url/schema').success(setSchema);
    });
```

##Parametres

**schema** objet javascript représentant le schéma des données

**data** liste d'objets javascript à afficher

**refname** nom de référence pour permettre à plusieurs listes de cohabiter dans une seule page sans risquer de confondre les messages émis par chacune d'elles ou permettre aux différentes listes d'une application de stocker leurs états.


##Evenements

###{{refname}}:ngTable:ItemSelected

type: broadcast

données : objet javascript élément sélectionné.

Message émis lorsque l'utilisateur clique sur un élément de la liste


###{{refname}}:cleared

type: broadcast

Message émis lorsque le formulaire est configuré pour permettre la sélection de plusieurs données par checkbox et que cette sélection est effacée


###{{refname}}:ngTable:filtered

type: broadcast

données : liste d'objets

Message émis lorsque la liste est triée ou filtrée afin de transmettre l'état de la liste


##Listeners


###{{refname}}:select reçoit un objet en parametre et sélectionne celui ci dans la liste.


###{{refname}}:filterIds reçoit une liste d'IDs et filtre la liste à partir de cette liste en ne gardant que les éléments dont l'ID est présent dans la liste.


###{{refname}}:clearChecked permet de donner l'ordre à la liste de vider la sélection par checkbox. Aucun parametre requis. 
