#detail-display

Directive générant automatiquement une vue détaillée à partir d'un schéma descriptif et d'un jeu de données.

##Usage

Exemple minimaliste

template:

```html
    <div ng-controller="testCtrl">
        <div detail-display schemaurl="url/schema" dataurl="url/data" dataid="{{__dataId__}} updateurl="#/update/{{__dataId__}}" map-connect="true"></div>
    </div>
```

controleur:

```javascript
    app.controller('testCtrl', function($scope){
        $scope.__dataId__ = 1; //choix arbitraire
    })
```


##Parametres

**schemaurl** adresse à appeler pour récupérer le schema descriptif de la vue

**dataurl** adresse à appeler pour récupérer les données à afficher

**updateurl** adresse de renvoi pour l'édition de la donnée

**dataid** identifiant de la donnée (nécéssaire si la vue permet d'accéder à un sous protocole

**map-connect** (bool) signale à la directive que certaines données sont de types géométriques (ignorées par la directive) et provoque l'affichage d'un bouton de recentrage


##Evenements

###display:init

type: broadcast

Message émis lorsque la directive est totalement initialisée (cad. lorsqu'elle a réceptionné le schéma et les données)


###map:centerOnSelected

type: broadcast

Message envoyé lorsque l'utilisateur clique sur le bouton de recentrage de la carte


##Listeners

###subEdit:dataAdded 

force le rechargement des données des sous protocoles.




