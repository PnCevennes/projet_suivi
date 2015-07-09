#Directives formulaires

Description des directives utilisées par *simpleform*


##dynform

Directive permettant d'afficher un formulaire à partir d'un schéma

###parametres

 - group: '=': schéma décrivant la liste des champs (cf schemas.md)
 - data: '=': jeu de données liées au formulaire
 - errors: '=': liste des messages d'erreur liés aux champs du formulaire



##multi

Directive permettant de répéter un champ plusieurs fois pour lier une liste à une variable.

###parametres

 - refer: '=' : equivalent ng-model
 - schema: '=' : schéma décrivant le type de champ à utiliser (cf schemas.md)



##angucompletewrapper

Directive fournissant un champ texte avec autocompletion par appel serveur. La valeur liée n'est pas le texte écrit mais une valeur retournée par le serveur liée au label choisi

Utilisée pour la saisie des observateurs ou des taxons dans le module chiro.

S'appuie sur la directive typeahead de la librairie [angular-ui](http://angular-ui.github.io/bootstrap/#/typeahead)

###parametres

 - inputclass: '@' : classe css a appliquer sur le champ de saisie
 - decorated: '@' : booleen affichant une glyphicon bootstrap permettant de différencier le typeahead d'un champ texte classique. Active également la possibilité d'ajouter des boutons (bootstrap input-group-btn) à droite de la zone de saisie
 - selectedobject: '=' : variable liée (ng-model mais avec connexion à sens unique saisie -> variable)
 - ngBlur: '=' : callback lorsque le champ perd le focus
 - url: '@' : url contactée lors de la frappe pour récupérer les valeurs possibles 
 - initial: '=' : valeur initiale du champ (dans un cas d'édition)
 - reverseurl: '@' : url contactée pour lier un label (texte saisi) à une valeur fournie (initial)
 - ngrequired: '=' : booleen (cf [input argument ngRequired](https://docs.angularjs.org/api/ng/directive/input)


####requetes serveur :
les vues doivent répondre a des requêtes GET et retourner soit une liste d'objets {id: xx, label: yy} pour l'url passée en param `url`, soit un seul objet {id: xx, label: yy} pour l'url passée en param `reverseurl`.




##fileinput

Directive d'upload de fichiers

S'appuie sur la directive [ng-file-upload](https://github.com/danialfarid/ng-file-upload) version 3.2

###parametres

 - fileids: '=': equivalent ng-model
 - options: '=': options de configuration de la directive sous forme d'objet js

####options
    
 - target: chemin cible pour stocker les fichiers sur le serveur
 - maxSize: poids en octets maximum autorisé
 - accepted: liste des extensions de fichiers autorisé
    
    <fileinput fileids="xx" options="{target:'my/dir', maxSize: 2048000, accepted: ['png', 'jpg']}"></fileinput>



##calculated

Champ de type numérique calculé


###parametres

 - id: '@': id html
 - ngClass: '@': classe css du champ de saisie
 - ngBlur: "=": callback lorsque le champ de saisie perd le focus
 - min: '=': valeur minimum
 - max: '=': valeur maximum
 - data: '=': référence au jeu de données pour la les valeurs de référence
 - refs: '=': liste des noms des valeurs de référence pour le calcul
 - model: '=': equivalent ng-model
 - modifiable: '=': booleen déterminant si le champs est en lecture seule ou pas


##geometry

Directive pour l'édition des données cartographiques.

###parametres:

 - geom: '=': equivalent ngmodel
 - options: '=': options de configuration la directive sous forme d'objet
 - origin: '=': identifiant du point à éditer

####options:

 - `geometryType` : type de donnée cartographique à éditer (Point, Polygone...)
 - `dataUrl` : url à contacter pour récupérer les données parmis lesquelles l'élément identifié par `origin` sera sélectionné



##datepick

Directive permettant d'afficher un champ date sous forme de calendrier

S'appuie sur la directive datepicker de la librairie [angular-ui](http://angular-ui.github.io/bootstrap/#/datepicker)

###parametres

 - uid: '@': un identifiant html unique pour le champ de saisie
 - date: '=': equivalent ng-model
 - required: '=': booleen 


##spreadSheet

Directive permettant d'afficher un formulaire complet dans une présentation tabulaire

S'appuie sur les directives: `angucompletewrapper` et `calculated` en plus des champs classiques HTML

###parametres

 - schemaurl: '=': url à contacter pour récupérer le schéma du formulaire
 - data: '=': conteneur de données
 - dataref: '=': libellé du champ à utiliser dans le conteneur de pour stocker les données du formulaire
 - subtitle: '=': libellé du formulaire
 
