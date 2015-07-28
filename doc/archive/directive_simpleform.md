#Directive simpleform

La directive `simpleform` sert à générer automatiquement des formulaires de création/édition/suppression de données à partir d'un schema fourni par le serveur.

Elle utilise les services 

- *dataServ* pour la récupération et l'envoi des données au serveur
- *configServ* pour la récupération du schéma du formulaire
- *userServ* pour la vérification des niveaux de droits de l'utilisateur 
- *userMessages* pour l'affichage de messages d'erreur
- *$loading* (librairie angular-loading-1.0)
- *SpreadSheet* pour la gestion des sous formulaires de saisie rapide

Elle s'appuie sur la directive dynform pour la génération des champs.


Elle prend 4 parametres, passés par référence:

 - schemaurl : L'url du schéma du formulaire
 - dataurl: L'url des données (Pour un formulaire d'édition. À ne pas fournir pour un formulaire de création). Fournir cette url fait aussi apparaitre le bouton supprimer (url: `DELETE saveurl`)
 - saveurl: Url où envoyer les données en cas de validation (données envoyées en POST si `dataurl` a été fourni, en PUT dans le cas contraire)
 - data: Un conteneur de référence pour les données (un simple {} suffit, il sera "rempli" grace au schéma du formulaire) qui permet au controleur "hôte" d'accéder aux données si nécessaire.


##Schéma de configuration du formulaire

les schémas sont envoyés par le serveur sous forme de JSON qui doivent respecter la forme suivante:

```json
    {
        "deleteAccess": valeur,
        "groups": [
            {
                "name": "Nom du groupe",
                "fields": [
                    {
                        "name": "nom du champ",
                        "label": "label du champ (affichage)",
                        "type": "type de champ",
                        "help": "message d'aide apparaissant en tooltip sur le label",
                        "options": {
                            "nomOption": "valeurOption"
                        },
                        "default": "valeur par défaut du champ",
                    }
                ]
            }
        ]
    }
```


###Explication de la structure


*groups* est la liste des panneaux du formulaire de saisie (style wizard)
Chaque panneau est défini par son nom (**name** qui sert de titre au panneau) et par la liste des champs qui le compose (**fields**).

Chaque champ est un objet comportant au minimum un nom (**name**), un type (**type**), et un label (**label**). Seuls les champs de type **hidden** n'ont pas besoin de label.

###Types de champs

####string et text

*string* affiche un input type="text"

*text* affiche un textarea

les options possibles sont *minLength* et *maxLength*. Un champ dont *minLength* est >0 définit systématiquement *required*



####num et sum

*num* affiche un input type="number". Les options possibles sont *min*, *max* et *step*

*sum* affiche un input type="number" dont la valeur est la somme des champs qui lui sont passés en référence

Option obligatoire: 

- ref: liste des champs de référence pour la somme


####select

*select* affiche une liste déroulante (balise select)

Option obligatoire:

- choices: liste d'objets {label: titre, id: valeur}

**default** doit fournir une valeur compatible avec le champ **id** de la liste des choix

####bool

*bool* affiche une simple case à cocher


####date

*date* affiche un "date picker" et formate son résultat au format français `jj/mm/aaaa`

####xhr

*xhr* affiche un input type="text" avec autocomplétion et retourne une valeur numérique (à moins de passer autre chose en réponse serveur) au modele de données
Options obligatoires:
    
- url: l'url interrogée pour récupérer les données
- reverseurl: url pour obtenir l'inverse (une chaine label en fonction d'une valeur fournie)

le serveur doit renvoyer une liste de données sous forme d'objets {libelle: libelle, id: id}


####geom

*geom* affiche une carte pour la saisie des données carto.

Options:

- geometryType: point, linestring, polygon
- dataUrl: pour la récupération des coordonnées en édition


####file

*file* affiche un bouton de sélection de fichiers pour l'upload de fichiers



###Options diverses pour les champs

- *required* rend un champ obligatoire
- *multi* permet de répéter un champ un nombre indéfini de fois



###Options du formulaire

- *deleteAccess* : *nombre* => niveau de droit minimum pour afficher le bouton de suppression (valeur type userHub)
- *deleteAccessOverride* : *reference champ* => permet d'outre-passer la restriction de niveau de droit si l'Id utilisateur a la même valeur que le champ fourni en référence
- *subSchemaUrl* : *url* => permet d'afficher un sous formulaire de saisie rapide dont le schéma est fourni par *url*
- *subDataRef* : *champ* => champ à utiliser dans le dictionnaire de données du formulaire parent pour collecter les données du sous-formulaire
- *subSchemaAdd*: *nombre* => niveau de droits nécéssaire pour faire apparaitre le sous formulaire (cf. *deleteAccess*)
- *subTitle*: *texte* => titre pour le sous formulaire


Exemple de configuration : PNC/ChiroBundle/Resources/clientConf/observation/form_ssite.yml


###Exemple d'utilisation de la directive coté JS

###template.htm

```html
    <div simpleform schemaurl="schemaUrl" dataurl="dataUrl" data="data" saveurl="saveUrl">
        <h1>{{title}}</h1>
    </div>
```

###controller.js

```javascript
    app.controller('trucMucheController', function($scope){
        $scope.schemaUrl = "monAppServeur/maVueSchema";
        $scope.dataUrl = "monAppServeur/maVueQuiEnvoieLesDonnéesAModifier";
        $scope.saveUrl = "monAppServeur/maVueQuiEnregistre";
        $scope.data = {};

        /*
         * Connexion aux événements de simpleform
         */
        $scope.$on('form:init', function(ev, data){
            /*
         * trucs qu'on peut faire à l'initialisation du formulaire
             * le param ev reçoit l'évenement angular, qui n'a pas grand intérêt
             * le param data reçoit les données qui ont été chargées par simpleform au cas où elles devraient $etre affichées
             * ex :
             */
             $scope.title = data.nomDeMaDonnée;
        });

        $scope.$on('form:create', function(ev, data){
            /*
             * trucs à faire lors de la création d'un nouvel enregistrement (cas où dataUrl n'aurait pas été fourni)
             * data contient les données envoyées au serveur + l'ID d'enregistrement renvoyé par le serveur
             */
             console.log('enregistrement n°' + data.id);
        });

        $scope.$on('form:update', function(ev, data){
            /*
             * idem que form:create mais dans le cas d'une mise à jour (dataUrl fourni)
             */
             console.log('mise à jour de l'enregistrement n°' + data.id);
        });

        $scope.$on('form.delete', function(ev, data){
            /*
             * Evenement lancé en cas de suppression de l'enregistrement 
             * data contient toutes les données de l'enregistrement effacé en cas de besoin
             * potentiellement modifiées par une saisie de l'utilisateur avant la décision d'effacement.
             */
        })
    });
```
