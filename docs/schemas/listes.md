#Listes

Schemas descriptifs permettant aux directives **filterform** et **tablewrapper** de générer des listes.


##Options de base des listes

**emptyMsg** message à afficher lorsque la liste ne contient aucun élément

**editAccess** niveau de droits nécéssaire pour créer ou éditer une donnée de la liste

**createBtnLabel** libellé du bouton permettant de créer un nouvel élément

**createUrl** url de la vue de création d'un nouvel élément

**editUrl** url de la vue d'édition

**detailUrl** url de la vue détaillée

**filtering** section de définition des options de filtrage des données (configuration de *filterform*

**fields** liste des champs à afficher


##fields

Chaque champ est défini par son nom *name*, son libellé *label* et un filtre ngTable *filter*. 
Définitions supplémentaires facultative : 

- *type* type de donnée - par défaut `text`
- *filterFunc* fonction de filtrage ngTable custom.

Selon le type de champs, une liste d'options est possible ou requise.

Options obligatoires quelque soit le champ :

**visible** (bool) définit si la colonne est affichée par défaut

Options disponibles pour tous les champs:

**style** [xl, l, s, xs] largeur de la colonne


##Types de champs

###text

Affiche une donnée telle qu'elle.


###date

Affiche une date formatée au format d/m/Y


###select

Affiche une donnée dont le libellé est récupéré dans une liste (voir description select detail)


###list

Affiche une liste


##filtering - Configuration du filtrage

La section filtering est utilisée pour déclarer la pagination par défaut et les différents composants utilisables pour filtrer les données.

**limit** (int) définit le nombre maximum de données renvoyées par défaut. Si **limit** n'est pas déclaré, alors la pagination est désactivée.

**fields** liste des champs utilisables pour filtrer les données.

Les champs utilisables se configurent de la même manière que pour un formulaire classique. Pour les types select, il peut être nécéssaire d'ajouter la déclaration zeroNull pour que la valeur 0 ne soit pas utilisée comme filtre.



