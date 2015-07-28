#Formulaires

Schemas descriptifs permettant à la directive **simpleform** de générer des formulaires.

Les différents champs composant les formulaire sont regroupés en sous groupes affichés sous forme de panneaux (style wizard) afin d'alléger la
saisie de l'utilisateur.

Chaque champ est défini par son nom, son type, et son libellé. Selon le type de champs, une liste d'options est possible ou requise.

Il est possible de définir un sous-formulaire de saisie rapide pour les protocoles dépendants, sous formulaire qui sera affiché comme un panneau complémentaire
au formulaire en cours.


##Options de base des formulaires

**deleteAccess** définit le niveau de droits nécéssaire pour supprimer la donnée.

**deleteAccessOverride** (facultatif) référence à un champ de la donnée qui permet de définir que l'utilisateur courant est "propriétaire" de la donnée et outre-passe le droit de suppression défini avec **deleteAccess**.

**subSchemaAdd** (facultatif) définit le niveau de droits nécéssaire pour afficher un sous formulaire.

**subSchemaUrl** (facultatif) définit l'url permettant de récupérer le schéma du sous formulaire.

**subDataRef** (factultatif) définit le conteneur dans le jeu de données du formulaire pour les données issues du sous formulaire.

**subTitle** (factultatif) définit le titre du sous formulaire.

**groups** liste des panneaux du formulaire


##Groupes

Chaque groupe définit un nouveau panneau dans le formulaire.

Un groupe est caractérisé par son libellé (**name**) et une liste de champs (**fields**).


##Exemple de formulaire minimal

```json
    {
        "deleteAccess": 5,
        "groups": [
            {
                "name": "Personne",
                "fields": [
                    {
                        "name": "nom",
                        "label": "Nom",
                        "type": "string",
                        "help": "Nom du contact",
                        "options": {
                            "minLength": 1
                        }
                    },
                    {
                        "name": "prenom",
                        "label": "Prénom",
                        "type": "string",
                    },
                    {
                        "name": "dateNais",
                        "label": "Date de naissance",
                        "type": "date",
                        "options": {
                            "required": true
                        }
                    },
                ]
            }
        ]
    }
```

##Types de champs

option disponible pour tous types de champs sauf **file** 


 - **required** (bool) : Rend le champ obligatoire pour la validation du formulaire
 - **multi** (bool) : Permet de répéter un champ afin de saisir une liste au lieu d'une donnée simple.


###hidden

Définit un input type hidden

options:

 - **ref: userid** fait référence à l'ID de l'utilisateur courant


###string

Définit un input type text

options:

 - **required** (bool) : Rend le champ obligatoire pour la validation du formulaire
 - **minLength** (int) : longueur minimum de la donnée. Une donnée dont la valeur **minlength** est supérieure à 0 est obligatoirement **required**
 - **maxLength** (int) : longueur maximale autorisée pour la donnée.


###text

Définit un textarea

options:

 - **minLength** (int) : longueur minimum de la donnée. Une donnée dont la valeur **minlength** est supérieure à 0 est obligatoirement **required**
 - **maxLength** (int) : longueur maximale autorisée pour la donnée.


###num

Définit un input type numeric

options:

 - **min** valeur minimum
 - **max** valeur maximum
 - **step** précision de la donnée et pas d'incrémentation lorsqu'on incrémente avec les fleches clavier ou la molette de la souris

lorsque step n'est pas défini, un champ de type numeric ne peut être initialisé qu'avec des entiers. Lorsque l'on utilise des décimaux, il est nécéssaire de préciser un step adéquat.


###sum

Définit un input type numeric dont la valeur est calculée en faisant la somme des valeurs des champs qui lui servent de référence.

options:

 - **min** valeur minimale du champ 
 - **ref** liste des champs qui servent de référence pour le calcul de la valeur du champ
 - **modifiable** (bool) détermine si le champ est modifiable ou en lecture seule (modifiable par défaut)


###date

Définit un input de type date (en utilisant la directive **datepick**)

 
###file

Permet d'uploader un fichier 

 options:

  - **target** dossier de stockage des fichiers uploadés (complément au dossier par défaut)
  - **maxSize** "poids" maximum autorisé en octets
  - **accepted** liste des extensions de fichiers acceptées


###xhr

Définit une directive de type **angucompletewrapper** qui permet de récupérer un ID de donnée à partir d'une saisie partielle

options:

 - **url**: url interrogée avec la saisie partielle pour récupérer la donnée réelle
 - **reverseurl**: url interrogée avec la donnée réelle pour récupérer son libellé


###select

Définit un champ de type select

options:

 - **choices** : liste de valeurs pour le select sous la forme d'un dictionnaire {id, libelle}

note: pour les listes de choix faisant référence à la table thesaurus, il est possible de signaler la référence au type de données en ajoutant le descripteur **thesaurusID** (uniquement dans les schémas définis en YAML)

ex:

```yaml
    name: typeId
    label: "type de site"
    type: select
    thesaurusID: 7
    default: 37
```


#Formulaires de saisie rapide

La définition des champs d'un formulaire de saisie rapide est la même que pour un formulaire classique, hormis que :

 - Il n'y a pas de groupes - les champs sont définis dans une unique liste **fields**
 - Il n'est pas possible d'utiliser les champs de type **file** et **text**
 - Il n'y a aucune option de formulaire du style **deleteAccess**, **sub(*)** etc.

il est possible de rajouter une option **primary** à certains champs qui interdit à plusieurs éléments saisis d'avoir la même valeur pour ce champ (comme une contrainte d'unicité)
