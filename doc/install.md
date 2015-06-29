
=======
SERVEUR
=======


Prérequis
=========

* Ressources minimum serveur :

Un serveur disposant d'au moins de 1 Go RAM et de 10 Go d'espace disque.

* Applications : 
 * postgresl
 * apache


Installation et configuration du serveur
========================================

* Activer le mod_rewrite et les configurations requises pour symfony et redémarrer apache

  ::  
        
        sudo a2enmod rewrite
        sudo apache2ctl restart


Installation et configuration de PosgreSQL
==========================================

* Création de 2 utilisateurs PostgreSQL

    ::
    
        sudo su postgres
        psql
        CREATE ROLE simpleuser WITH LOGIN PASSWORD 'monpassachanger';
        CREATE ROLE dbadmin WITH SUPERUSER LOGIN PASSWORD 'monpassachanger';
        \q
