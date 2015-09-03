Application serveur
===================


Chaque nouvelle application doit être développée dans un bundle qui lui est propre


création d'un nouveau bundle::

    app/console generate:bundle



Base de données
---------------

Chaque nouveau module doit définir son propre schéma.

La base de données contient un schema de base à utiliser pour définir ses données.

Les sites doivent utiliser la table suivi.pr_base_site, les informations complémentaires relatives aux protocoles sont à définir dans une table qui y est liée par une relation 1-1

les visites doivent utiliser la table doivent utiliser la table suivi.pr_base_visite, les infos complémentaires suivent la même regle que pour les sites.


Tables de références
~~~~~~~~~~~~~~~~~~~~

layers.l_communes -> codes insee communes 

taxonomie.taxref -> liste des taxons

lexique.t_thesaurus -> lexique

utilisateurs.t_roles -> utilisateurs



Entités
-------------------


Mapping
~~~~~~~

Le mapping doit être fait en YAML

Il n'est pas recommendé de mapper les relations


Génération des entités::
    
    app/console doctrine:generate:entities PNC


Modification des entités pour la gestion des erreurs
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Les entités doivent hériter de la classe Utils/BaseEntity::

    use PNC\Utils\BaseEntity;

    class MonEntite extends BaseEntity { 
        ...
    }


La vérification de la validité des données fournies à l'entité se fait dans les setters::

    function setMaVariable($variable){
        if($variable != "bonne valeur"){
            $this->add_error('maVariable', "la variable n'a pas la bonne valeur");
        }
        $this->maVariable = $variable;
    }



Création des routes
~~~~~~~~~~~~~~~~~~~

5 routes par type de page

GET module/objet retourne une liste des objets 

GET module/objet/{id} retourne un objet particulier identifié par {id}

PUT module/objet crée un nouvel objet 

POST module/objet/{id} met à jour l'objet identifié par {id}

DELETE module/objet/{id} supprime l'objet identifié par {id}



Services utilisables dans les controleurs
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

dans les routes GET 

récupérer une liste d'objets en utilisant EntityService::

    //GET monModule/monObjet
    function getAllMonObjetAction(){
        $et = $this->get('entityService');
        $entite = 'monModule:MonObjet';
        $mapping = '../src/PNC/MonBundle/Resources/config/doctrine/monObjet.orm.yml';
        $results = $et->getAll($entite);
        $out = array();
        foreach($results as $result){
            $out[] = $et->normalize($result, $mapping);
        }
        return new JsonResponse($out);
    }

la fonction présentée utilise le fichier yaml de mapping pour normaliser les objets.

.. NOTE::
    La normalisation d'un objet consiste à le transformer en dictionnaire (tableau associatif) directement sérialisable en JSON


Il est également possible de passer un tableau pour sélectionner les données que l'on souhaite récupérer::

    ...
    foreach($results as $result){
        $out[] = $et->normalize($result, array(
            'maVar1'=>null,
            'maVar2'=>'date',
            ...
        ));
    }
    ...

le tableau prend en clé le nom de la variable, et en valeur une déclaration de fonction à utiliser pour transformer la donnée.
la valeur `null` implique qu'aucune transformation n'est à faire. 
    


récupérer une liste d'objets en utilisant PaginationService::

    //GET monModule/monObjet
    function getAllMonObjetAction(Request $request){
        $ps = $this->get('paginationService');
        $entite = 'monModule:MonObjet';
        $mapping = '../src/PNC/MonBundle/Resources/config/doctrine/monObjet.orm.yml';
        $results = $ps->filter_request($entite, $request);
        $out = array();
        foreach($results as $result){
            $out[] = $et->normalize($result, $mapping);
        }
        return new JsonResponse($out);
    }



récupérer un seul objet::

    //GET monModule/monObjet/{id}
    function getOneMonObjetAction($id){
        $et = $this->get('entityService');
        $entite = 'monModule:MonObjet';
        $mapping = '../src/PNC/MonBundle/Resources/config/doctrine/monObjet.orm.yml';
        $results = $et->getOne($entite, array('id'=>$id));
        $out = $et->normalize($result, $mapping);
        return new JsonResponse($out);
    }
