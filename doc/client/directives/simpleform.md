#simpleform

Directive générant automatiquement un formulaire autonome à partir d'un schéma descriptif et d'un jeu de données

##Usage

Exemple minimaliste

template:

```html
    <div ng-controller="testCtrl">
        <div simpleform schemaurl="__urlschema__" dataurl="__urldata__" saveurl="__urldestination__" data="__data__"><h1>Edition des données</h1></div>
    </div>
```

controleur:

```javascript
    app.controller('testCtrl', function($scope){
        $scope.__urlschema__ = "serveur/schema";
        $scope.__urldata__ = "serveur/data";
        $scope.__urldestination__ = "serveur/destination";
        $scope.__data__ = {};
    });
```


##Parametres

**schemaurl** adresse à appeler pour récupérer le schéma descriptif du formulaire.

**dataurl** adresse à appeler pour récupérer les données à éditer. Si le parametre n'est pas fourni, les données seront envoyées au serveur en PUT. Dans le cas contraire, elles seront transmises en POST.

**saveurl** adresse à laquelle seront envoyées les données saisies

**data** conteneur de référence pour les données. Permet au controleur "supérieur" de garder une vue sur les données.


##Evenements

Tous les événements sont de type *broadcast* et transmettent en parametre les données du formulaire


###form:init 

Message envoyé lorsque le formulaire est totalement initialisé (cad. lorsqu'il a réceptionné le schema de description et les données)


###form:cancel

Message envoyé lorsque l'utilisateur quitte le formulaire sans avoir enregistré les changements.


###form:create

Message envoyé lorsque les données du formulaires ont été postées pour créer une nouvelle donnée.


###form:update

Message envoyé lorsque les données ont été postées pour mettre à jour une donnée existante.


###form:delete

Message envoyé lorsque le donnée éditée a été supprimée du serveur à partir du formulaire.

