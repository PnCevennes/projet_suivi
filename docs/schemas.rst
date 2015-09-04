Configuration de l'appli cliente
================================

Pour ne rien avoir à coder coté client, l'appli AngularJS propose des vues génériques qui déterminent l'url à contacter pour récupérer leur configuration en se basant sur leur propre url.

Par exemple `#/monModule/monObjet/list` contactera l'url `serveur.tld/monModule/config/monObjet/list`

    
Vues serveur pour la configuration du client
--------------------------------------------



Déclaration du module pour l'application
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~



En premier lieu, pour ajouter un module, il faut le déclarer dans `PNC/BaseAppBundle/Resources/clientConf/application.yml`::

    - id: 1
      name: monModule
      base_url: "g/monModule/monObjet"
      img: "chemin/vers/image/appli" #non obligatoire
      appId: 150
      menu: 
        -   url: "#/g/monModule/monObjet"
            label: "mon module"
            restrict: 1

ID : Numéro de module utilisé par l'appli cliente
name : nom du module tel qu'il apparaitra dans la barre d'entête
base_url : url de base du module vers laquelle l'utilisateur est renvoyé par défaut
img : image d'accueil pour la sélection du module (non obligatoire, dans ce cas c'est "name" qui est affiché
appId : identification de l'application dans userHub
menu: liste des différents sous-modules (par ex le module chiro: Sites/Inventaire/Validation
    url: url de base du sous-module
    label: libellé du sous-module
    restrict: niveau de droit nécéssaire à l'utilisateur pour afficher le sous module.

Si le module ne comporte pas de sous modules, le menu reste obligatoire et dans ce cas il ne contient qu'un élément.




Différents schémas à définir
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

pour chaque objet il faut définir au minimum 3 schémas :

* list
* detail
* form

Dans le cas d'utilisation des vues génériques, il est nécéssaire de créer une route pour chacun d'eux::
    
    /monModule/config/monObjet/+leSchema


Controleurs config

.. code:: php

    //GET monModule/config/monObjet/list
    function getMonObjetListSchema(){
        $cs = $this->get('configService');
        $schema = $cs->get_config('chemin/vers/mon/schema.yml')
        return new JsonResponse($schema);
    }


Schema liste
~~~~~~~~~~~~


configuration de base d'une vue générique

.. code:: yaml

    title: "monObjet"
    emptyMsg: "Aucun monObjet"
    createBtnLabel: "nouveau monObjet"
    createUrl: "#/g/monModule/monObjet/edit"
    editUrl: "#/g/monModule/monObjet/edit/"
    detailUrl: "#/g/monModule/monObjet/detail"
    dataUrl: "monModule/monObjet"
    mapConfig: "fichier_config_map.json"
    mapSize: large
    editAccess: 1


* title: Titre de la page
* emptyMsg: texte affiché lorsqu'il n'existe aucune donnée
* createBtnLabel: libellé du bouton de création d'un nouvel objet
* createUrl: url angular du formulaire de création
* editUrl: url angular du formulaire de mise à jour
* detailUrl: url angular de la vue détaillée
* dataUrl: url serveur à contacter pour charger les données
* mapConfig: url du fichier (ou vue) de configuration des fonds carto - supprimer si pas de carte
* mapSize: taille de la carte (large|small)
* editAccess: niveau de droit nécéssaire pour éditer un objet


.. code:: yaml
    
    filtering:
        limit: 200
        fields:
            -   name: var_a
                label: "Var A"
                type: string
            -   name: var_b
                label: "Var B"
                type: date


* filtering: définit les options de filtrage - le controleur qui renvoie les données doit alors utiliser paginationService plutôt que entityService
* limit: nombre maximum de données renvoyées par défaut
* fields: liste des champs qui permettent de filtrer les données
* name: nom de l'attribut de l'objet à filtrer (au format mot_mot et non camelCase)
* label: libellé du filtre
* type: type de donnée: détermine les différents comparateurs


.. code:: yaml

    fields:
        -   name: varA
            label: "Var A"
            type: text
        -   name: varB
            label: "Var B"
            type: date
        -   name: varC
            type: select
            thesaurusID: 1


* fields: liste des champs de l'objet à afficher
* name: nom du champ (format camelCase)
* label: libellé du champ (titre de la colonne)
* type: type de donnée
* thesaurusID: utilisable uniquement sur les champs select - cherche les lignes référent au chiffre fourni dans le lexique et complete le schéma avec les options de la liste déroulante
