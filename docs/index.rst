.. test documentation master file, created by
   sphinx-quickstart on Wed Sep  2 11:29:03 2015.
   You can adapt this file completely to your liking, but it should at least
   contain the root `toctree` directive.



Projet suivi 
============


Présentation du projet
======================

@TODO


Installation et configuration
=============================


Prérequis
---------


Ressources minimum serveur :
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Un serveur disposant d'au moins de 1 Go RAM et de 10 Go d'espace disque.

Applications : 

 * postgresl (>= 9.3) 
 * postgis (>=2)
 * apache

Autres : 

 * php-cli 
 * php-curl

Installation et configuration du serveur
----------------------------------------

Activer le mod_rewrite et les configurations requises pour symfony et redémarrer apache::

    sudo a2enmod rewrite
    sudo apache2ctl restart


Installation et configuration de PosgreSQL
------------------------------------------


Création de 2 utilisateurs PostgreSQL::

    sudo su postgres
    psql
    CREATE ROLE simpleuser WITH LOGIN PASSWORD 'monpassachanger';
    CREATE ROLE dbadmin WITH SUPERUSER LOGIN PASSWORD 'monpassachanger';
    \q


Installation et configuration de la base de données
---------------------------------------------------

Créer un fichier de configuration de la base de données::

    cd installation
    cp db_settings.ini.sample db_settings.ini


Spécifier les bon paramètres de configuration de la base de données


Lancer l'installation::

    cd installation
    sudo ./install_db.sh 


Installation et configuration de l'application
----------------------------------------------


Configuration de symphony 
~~~~~~~~~~~~~~~~~~~~~~~~~

@TODO




Droits sur les répertoires log et cache::

    sudo chmod -R 777 app/cache app/log


Installation du composer::

    curl -s https://getcomposer.org/installer | php



Mise à jour et téléchargement des dépendances::

    php composer.phar update




License
=======


* OpenSource - GPL V3
* Copyleft 2015 - Parc national des Cévennes

.. image:: _static/logo_pnc_orange.png
    :alt: Logo PNC


.. toctree::
   :maxdepth: 2

   index
   serveur

