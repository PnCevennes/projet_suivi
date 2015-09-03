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




