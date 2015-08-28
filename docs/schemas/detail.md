#Detail

Schema descriptif permettant à la directive **detail-display** d'afficher une vue détaillée d'une donnée.

Les différents champs composant la vue à afficher sont regroupés en sous groupes affichés sous forme de panneaux selon le même principe que pour les formulaires.

Chaque champ est défini par son nom, son type, et son libellé. Selon le type de champs, une liste d'options est nécéssaire.


##Options de base des vues détaillées

**editAccess** définit le niveau de droits nécéssaire pour éditer la donnée

**subEditAccess** définit le niveau de droits nécéssaire pour ajouter des données annexes

**subSchemaUrl** url du schéma de liste permettant d'afficher la liste des données annexes

**subDataUrl** url permettant de récupérer les données annexes.

**subEditSchemaUrl** url permettant de récupérer le schéma du sous-formulaire de saisie rapide des données annexes

**subEditSaveUrl** url de renvoi des données du sous-formulaire de saisie rapide

**subEditRef** nom du champ servant de référence pour identifier la donnée courante comme "parent" des données annexes

**subSchemaAdd** definit le niveau de droits nécéssaire pour utiliser le sous-formulaire de saisie rapide.

**groups** liste des panneaux de la vue


##Groupes

Chaque groupe définit un nouveau panneau dans le formulaire.

Un groupe est caractérisé par son libellé (**name**) et une liste de champs (**fields**).



##Types de champs

option disponible pour tous les types de champs:

- **multi** indique que la donnée est une liste dont chaque élément doit être traité.


###string

Affiche une donnée telle qu'elle sans la moindre transformation.


###num

Affiche une donnée numérique telle qu'elle sans la moindre transformation.


###date

Affiche une date en transformant le format Y-m-d au format d/m/Y


###file

affiche un nom sous forme de lien

options:

 - **target** complément du nom pour former l'url du fichier


###select

Affiche un libellé sélectionné dans une liste en fonction de la valeur de la donnée.

options: 

 - **choices** liste de valeurs sous la forme d'un dictionnaire {id, libelle}

note: pour les listes de choix faisant référence à la table thesaurus, il est possible de signaler la référence au type de données en ajoutant le descripteur **thesaurusID** (uniquement dans les schémas définis en YAML)

ex:

```yaml
    name: typeId
    label: "type de site"
    type: select
    thesaurusID: 7
```


###xhr

Affiche un libellé correspondant à la valeur de la donnée grâce à une requete serveur

options:

 - **url** url à contacter pour récupérer le libellé de la donnée
