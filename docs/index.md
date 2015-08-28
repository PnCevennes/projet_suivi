
=======
SERVEUR
=======


Prérequis
=========

* Ressources minimum serveur :

Un serveur disposant d'au moins de 1 Go RAM et de 10 Go d'espace disque.

* Applications : 
 * postgresl (>= 9.3) 
 * postgis (>=2)
 * apache

* Autres : 
 * php-cli 
 * php-curl

Installation et configuration du serveur
========================================

* Activer le mod_rewrite et les configurations requises pour symfony et redémarrer apache

```
        sudo a2enmod rewrite
        sudo apache2ctl restart
```

Installation et configuration de PosgreSQL
==========================================

* Création de 2 utilisateurs PostgreSQL

```
        sudo su postgres
        psql
        CREATE ROLE simpleuser WITH LOGIN PASSWORD 'monpassachanger';
        CREATE ROLE dbadmin WITH SUPERUSER LOGIN PASSWORD 'monpassachanger';
        \q
```


Installation et configuration de l'application
==============================================

* Configuration de symphony

```{r, engine='bash', count_lines}
      #Droits sur les répertoires log et cache
      sudo chmod -R 777 app/cache app/log
      
      #Installation du composer
      curl -s https://getcomposer.org/installer | php
      #Mise à jour et téléchargement des dépendances
      php composer.phar update
```

* 
