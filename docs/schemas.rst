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



Schémas
=======


Différents schémas à définir
----------------------------

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


filtrage des données

.. code:: yaml
    
    filtering:
        limit: 200
        fields:
            -   name: ma_var_a
                label: "Var A"
                type: string
            -   name: ma_var_b
                label: "Var B"
                type: date


* filtering: définit les options de filtrage - le controleur qui renvoie les données doit alors utiliser paginationService plutôt que entityService
* limit: nombre maximum de données renvoyées par défaut - null équivaut à aucune limite
* fields: liste des champs qui permettent de filtrer les données - non obligatoire si aucun filtre n'a besoin d'être appliqué
* name: nom de l'attribut de l'objet à filtrer (au format mot_mot et non camelCase)
* label: libellé du filtre
* type: type de donnée: détermine les différents comparateurs


.. note::
    Pour une utilisation des vues génériques, la directive de filtrage doit obligatoirement être déclarée. 


liste des champs

.. code:: yaml

    fields:
        -   name: maVarA
            label: "Var A"
            type: text
        -   name: maVarB
            label: "Var B"
            type: date
        -   name: maVarC
            type: select
            thesaurusID: 1


* fields: liste des champs de l'objet à afficher
* name: nom du champ (format camelCase)
* label: libellé du champ (titre de la colonne)
* type: type de donnée
* thesaurusID: utilisable uniquement sur les champs select - cherche les lignes référent au chiffre fourni dans le lexique et complete le schéma avec les options de la liste déroulante


Schema detail
~~~~~~~~~~~~~

configuration de base d'une vue générique

.. code:: yaml

    dataUrl: "monModule/monObjet/"
    mapConfig: "fichier_config_map.json"
    mapData: "monModule/mesDonneesmap"
    mapSize: large
    editAccess: 1
    subEditAccess: 1
    subSchemaUrl: "monModule/config/monSubObjet/list"
    subDataUrl: "monModule/monSubObjet/monObjet/"

* dataUrl: url à contacter pour récupérer l'objet à afficher (complétée par l'appli angular avec ID passé en param de l'url)
* mapConfig: fichier de configuration des fonds carto (si omis, pas d'affichage carto)
* mapData: url des données carto (contexte de l'objet)
* mapSize: taille de la carte (large|small)
* editAccess: droits nécéssaires pour éditer la donnée
* subEditAccess: droits nécéssaires pour ajouter une sous donnée
* subSchemaUrl: adresse à contacter pour le schema de la liste des sous données
* subDataUrl: adresse pour charger les sous données 

liste des champs

.. code:: yaml

    groups:
        - name: "monGroupe1"
          glyphicon: glyphicon-info-sign
          fields:
            -   name: maVarA
                label: "Var A"
                type: string
            -   name: maVarB
                label: "Var B"
                type: date
        - name: "monGroupe2"
          fields:
            -   name: maVarC
                label: "Var C"
                type: select
                thesaurusID: 1

* groups: liste de groupes de données - seront affichés sous forme de boites à onglets.
* groups.name: nom et libellé du groupe
* glyphicon: glyphicon décorative pour l'onglet - facultatif
* fields: liste des champs affiché dans l'onglet
    * name: nom de la variable (camelCase)
    * label: libellé
    * type: type de donnée
    * thesaurusID: uniquement pour les types select - permet d'afficher le libellé correspondant à la valeur numérique du champ



schema formulaire
~~~~~~~~~~~~~~~~~

configuration de base d'une vue générique

.. code:: yaml

    editAccess: 1
    deleteAccess: 1
    formTitleCreate: "nouveau monObjet"
    formTitleUpdate: "edition de "
    formTitleRef: maVarA
    createSuccessMessage: "monObjet créé"
    updateSuccessMessage: "monObjet modifié"
    deleteSuccessMessage: "monObjet supprimé"
    formDeleteRedirectUrl: "g/monModule/monObjet/list"
    formCreateCancelUrl: "g/monModule/monObjet/list"

* editAccess: droits nécéssaires pour éditer, en cas de droits insuffisant l'utilisateur est redirigé
* deleteAccess: droits nécéssaires pour faire apparaitre le bouton de suppression
* formTitleCreate: titre du formulaire de création d'un objet
* formTitleUpdate: titre du formulaire de modification (complété avec le contenu de formTitleRef
* formTitleRef: variable à utiliser pour compléter le titre du formulaire (cf ci dessus)
* createSuccessMessage: message affiché lorsqu'un objet est créé
* updateSuccessMessage: message affiché lorsqu'un objet est modifié
* deleteSuccessMessage: message affiché lorsqu'un objet est supprimé
* formDeleteRedirectUrl: url de redirection en cas de suppression de la donnée
* formCreateCancelUrl: url de redirection en cas d'abandon de création (en modification, l'url de redirection est la vue détaillée de l'objet)


.. code:: yaml
    
    groups:
        -   name: monGroupe1
            fields:
                -   name: maVarA
                    label: "Var A"
                    type: string
                -   name: maVarB
                    label: "Var B"
                    type: date
        -   name: monGroupe2
            fields:
                -   name: maVarC
                    label: "Var C"
                    type: select
                    thesaurusID: 1

* groups: liste des groupes de champs - affiché sous forme de boite à onglets avec sous validation (genre wizard)
    * name: nom du groupe
    * fields: liste des champs composant le groupe
        * name: nom de la donnée (camelCase)
        * label: libellé du champ
        * type: type de champ


