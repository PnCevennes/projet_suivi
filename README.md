Projet application suivis
=========================

A Symfony project created on March 10, 2015, 4:08 pm.

#Application de saisie des protocoles de suivi naturaliste

Le projet se décline en deux bundles :

*PNC/BaseAppBundle* qui est une base généraliste ayant pour vocation d'être réutilisée par chaque application

*PNC/ChiroBundle* la mise en application de cette base pour fournir une interface de saisie des protocoles de suivi des chiroptères.


Documentation
------------

http://projet-suivi.readthedocs.io


Technologies
------------

- Langages : PHP, HTML, JS, CSS
- BDD : PostgreSQL, PostGIS
- Serveur : Debian ou Ubuntu
- Framework PHP : Symfony 2
- Framework JS : Angular JS
- Framework carto : Leaflet
- Framework CSS : Bootstrap
- Fonds rasters : Geoportail, OpenStreetMap, Google Maps, WMS


Présentation
------------

**Principe général** : Projet_Suivi est une application qui permet de gérer des protocoles de suivi naturaliste. 

Elle s'appuie sur le principe que tous les protocoles de suivi sont basés sur des sites dans lequel sont réalisés des visites régulièrement. 

A chaque visite des observations de taxons sont faites avec les spécificités de chaque protocole. 

Aperçu du MLD avec l'exemple du protocole Suiv_Chiro (où la partie en rouge est commune à tous les protocoles de suivi et la partie en bleue est spécifique au protocole Suivi_Chiro) :

![MLD](http://geonature.fr/img/MLD_suivi_chiro.png)

Actuellement Projet_Suivi est fourni avec la partie générique de suivi + le protocole de suivi des chiroptères ainsi qu'un inventaire du patrimoine bati. 

Aperçu
------

![Screenshot 01](http://geonature.fr/img/screenshot_chiro_01.jpg)
*Liste des sites*

![Screenshot 02](http://geonature.fr/img/screenshot_chiro_02.jpg)
*Fiche d'une visite*

![Screenshot 03](http://geonature.fr/img/screenshot_chiro_03.jpg)
*Formulaire de saisie d'une observation chiro lors d'une visite d'un site*


Auteurs
-------

Parc national des Cévennes

* Frédéric FIDON
* Amandine SAHL


License
-------

* OpenSource - GPL V3
* Copyleft 2015 - Parc national des Cévennes

![logo-pnc](http://geonature.fr/img/logo-pnc.jpg)

