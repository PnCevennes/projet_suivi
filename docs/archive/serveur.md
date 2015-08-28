#Serveur

##Démarrage serveur en dev

    $ app/console server:run [ip:port]

par défaut le serveur répond sur 127.0.0.1:8000 


##Mise a jour des entités

    $ app/console doctrine:generate:entities NameSpace\Bundle

NB: Lors de la mise à jour des entités : les champs et accesseurs ajoutés le sont à la suite du code existant. 



##Mise à jour de la DB

    $ app/console doctrine:schema:update


## A retenir divers PHP

passer 'true' en deuxième parametre de json_decode pour récupérer un tableau associatif et non une StdClass



##Dépendances :

**Doctrine2-spatial** 
ajouter à composer.json section "require"-> "creof/doctrine2-spatial": "dev-master"
puis
    
    $ composer update



#Utils

Services utilitaires génériques

**GeomertryService** est un raccourci pour créer les instances géométriques utilisées par le plugin doctrine2-spatial

depuis un controleur :

    ...
    $geo = $this->get('geometry');
    $geo->geoJsonToPoint($geoJsonPoint);
    ...

**NormalizeService** est un raccourci pour récupérer une instance de GetSetMethodNormalizer qui permet de transformer une entité doctrine en dictionnaire directement sérialisable en JSON

Limitations : Certains types de champs ne sont pas normalisables. 

- date (Objet DateTime qui peut être réinjecté tel quel dans le dictionnaire (directement sérialisable), ou alors converti en str via DateTime::format())
- geometry (normalement inutilisé en lecture -> lecture via vue DB)
- listes
- relations suivant le type de relation (et celles qui le sont peuvent parfois engendrer des boucles infinies)

depuis un controleur :

    ...
    $norm = $this->get('normalizer');
    $norm->normalize($entite, array('ignore1', 'ignore2');
    ...


#/Commons

Modules communs pouvant être partagés par plusieurs applications

##/Commons/Users

Module d'identification des utilisateurs et gestion des sessions

###Entités

 - Login : Entité fournissant les données relatives aux utilisateurs

###Vues 

 - POST /users/login : Identification des utilisateurs et ouverture de session utilisateur
 - GET /users/logout : Cloture d'une session utilisateur
 - GET /users/name/{app}/{droit}/{q} : retourne une liste d'utilisateurs d'une application {app} filtrée par le niveau de droits {droit} et par des éléments du nom {q} - utilisée par les autocomplétions
 - GET /users/id/{id} : retourne un nom d'utilisateur identifié par l'id fourni {id}

###Services

 - UserService : Service utilisé par les différents modules pour gérer les différents niveaux de droits de l'utilisateur connecté.


##/Commons/Exceptions

Définition des types d'exceptions utilisables par les différentes applications

 - CascadeException : Exception levée en cas d'interdiction de suppression d'un élément relative à un problème de hiérarchie des éléments et des droits de l'utilisateur
 - DataObjectException : Exception levée lors de l'hydratation des entités en cas de valeur invalide



#/PNC

Modules regroupant les bundles spécifiques à l'application suivi_protocoles


##/PNC/BaseAppBundle

Module servant de base aux autres modules.

###Entités

 - Site : Entité abstraite définissant les éléments communs aux différents types de sites
 - Observation : Entité abstraite définissant les éléments communs aux différents types d'observations
 - Thésaurus : Mapping de la table de vocabulaire controlé utilisé par les listes à choix multiples
 - Fichiers : Metadonnées d'identification des fichiers téléchargés
 - Observateurs : Mapping de la table des utilisateurs utilisé par les autocomplétions
 - Taxons : Mapping de taxref utilisé par les autocomplétions

###Vues

 - GET config/apps : retourne le schéma d'initialisation des applications
 - POST upload_file : réception des fichiers uploadés -Enregistre en base les métadonnées et déplace le fichier dans le dossier adéquat - retourne l'identifiant généré pour le fichier
 - DELETE upload_file/{file_id} : supprime le fichier identifié par {file_id}
 - GET commune/{insee} : retourne le nom d'une commune identifiée par son numéro insee {insee}


###Services

 - BaseSiteService
