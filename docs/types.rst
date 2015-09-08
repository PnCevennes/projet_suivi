Définition des schémas
======================

Liste des types de données qui peuvent être déclarés dans les différents schémas




Options disponibles pour tous les types
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Les options sont définies dans la variable "options" du champ

.. code:: yaml
    
    name: maVar
    label: "Ma variable"
    type: text
    options:
        visible: true
    default: "valeur par défaut"



* visible (bool) : rend la colonne de la liste visible par défaut.
* style (xl|l|s|xs) : définit la taille de la colonne


Configuration des filtres
~~~~~~~~~~~~~~~~~~~~~~~~~

Les filtres sont définis dans la variable "filter" du champ

.. code:: yaml

    name: maVar
    label: "Ma variable"
    type: text
    filter:
        maVar: text


Des filtres spéciaux peuvent être utilisés en ajoutant la directive "filterFunc: nom_du_filtre" 

.. code:: yaml

    name: maVar
    label: "Ma variable"
    type: text
    filter:
        maVar: text
    filterFunc: monFiltre

Il existe deux fonctions de filtres actuellement : 
starting : qui recherche une chaîne débutant par la recherche écrite (LIKE recherche%)
integer : qui permet de rechercher un entier avec des comparaisons < = ou >


Types de données utilisables dans les listes
============================================



text
~~~~

Affiche un texte sans la moindre transformation

.. code:: yaml

    name: maVar1
    label: "Ma variable 1"
    type: text




num
~~~

Affiche une donnée numérique sans transformation. Peut être utilisé avec la fonction de filtrage "integer"





select
~~~~~~

Affiche un libellé correspondant à une valeur numérique sélectionné dans une liste fournie en options

Afin de faciliter l'utilisation de ce genre de type, lorsque la liste des libellés est issue du lexique, il est possible de faire une référence directe au lexique via `thesaurusID`



date
~~~~


Le serveur renvoie des données brutes avec des dates au format YYYY-MM-DD. Les champs de type date transforment cette date au format DD/MM/YYYY




Types de données utilisables dans les formulaires
=================================================


Options disponibles pour tous les types
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

* required: rend le champ obligatoire.


Options disponibles pour certains types
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

* multi: permet de répéter un champ à volonté afin d'obtenir une liste plutot qu'une simple donnée.
  N'est pas disponible pour les champs de type `text`, `sum`, `geom`, `group` ou `file`


hidden
~~~~~~

crée un champ de type `<input type="hidden">`. Ce champ accepte l'option "referParent: true" qui permet de faire référence au parametre d'identifiant passé par l'url ou l'option "ref: userId" qui permet de faire référence à l'ID de l'utilisateur. 


string
~~~~~~

affiche un champ de saisie du type `<input type="text">`

options :

* minLength: longueur minimum valide
* maxLength: longueur maximale autorisée


text
~~~~

afficher un champ de saisie du type `<textarea>`

options :

* minLength: longueur minimum valide
* maxLength: longueur maximale autorisée


num
~~~

affiche un champ de type `<input type="number">`

options :

* min: valeur minimum
* max: valeur maximum
* step: pas d'incrément pour l'incrémentation à la souris et pour l'activation des décimales.

sum
~~~

affiche un champ de type `<input type="number">` dont la valeur est calculée en fontion d'autres champs `num`

options :

* min: valeur minimum
* max: valeur maximum
* step: pas d'incrément pour l'incrémentation à la souris et pour l'activation des décimales.
* ref: liste des champs servant de référence pour le calcul de la valeur
* modifiable (bool:true): permet de mettre le champ en lecture seule. 


bool
~~~~

affiche une case à cocher type `<input type="checkbox">`



select
~~~~~~

affiche une liste déroulante dont les éléments sont passés en option

.. code::
    name: varX
    label: "ma selection"
    type: select
    options:
        choices:
            -   id: 1
                libelle: "option 1"
            -   id: 2
                libelle: "option 2"

.. note::
    
    Il est possible d'utiliser le raccourci `thesaurusID: num` au lieu de définir les différents choix pour les listes de sélection faisant référence au lexique 

    .. code::

        name: varX
        label: "ma selection"
        type: select
        thesaurusID: 1



date
~~~~

affiche un champ date sous forme de calendrier



file
~~~~

affiche une directive d'upload de fichier

options requises:

* target: dossier de stockage des fichier uploadés
* maxSize: "poids" maximum autorisé (en octets)
* accepted: liste des types d'extensions autorisés



xhr
~~~

affiche un champ de saisie du type `<input type="text">` pour les références avec autocompletion par appel au serveur

options requises:

* url : url à contacter pour obtenir les données d'autocompletion 
* reverseurl : url à contacter pour obtenir le libellé lié à une référence


group
~~~~~

Le type group n'est pas un champ à part entière.
Il permet de regrouper un nombre de champs en tableau de saisie

.. code::
    name: mesVars
    type: group
    titles: 
        -   "colonne 1"
        -   "colonne 2"
    fields:
        -   name: lig1
            label: "ligne 1"
            fields:
                -   name: l1c1
                    label: "ligne1/colonne1"
                    type: num
                -   name: l1c2
                    label: "ligne1/colonne2"
                    type: num
        -   name: lig2
            label: "ligne2"
            fields:
                -   name: l2c1
                    label: "ligne2/colonne1"
                    type: num
                -   name: l2c2
                    label: "ligne2/colonne2"
                    type: num



geom
~~~~

affiche une carte pour la saisie des données géométriques

options: 

* geometryType (point|linestring|polygon) : type de géométrie traçable
* dataUrl: url des données de contexte pour l'édition d'une géométrie

.. note::

    Il est préférable que le champ geom soit dans un groupe dédié
