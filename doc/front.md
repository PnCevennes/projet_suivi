#Projet suivi protocoles 

La partie frontale de l'application se base sur :

- https://angularjs.org/(AngularJS) Pour le coeur de l'application
- http://leafletjs.com/(Leaflet) Pour la gestion des données cartographiques
- http://getbootstrap.com/(Bootstrap) Pour le style d'affichage des éléments HTML 


##app.js - Point d'entrée de l'application

Initialise les différents modules et les routes de base qui composent l'application et définit le controleur principal **baseController**

###BaseController

La fonction de **baseController** est de controler l'état de l'utilisateur (identifié, connecté à une appli), rediriger la vue utilisateur vers la fonction adéquate selon son statut et gérer le menu principal de l'application.


###loginController

La fonction de **loginController** est de permettre à l'utilisateur de s'identifier. Il affiche un formulaire de connexion et redirige la vue utilisateur vers **appsController** lorsque la connexion est réussie


###logoutController

**logoutController** se charge de signaler au serveur la deconnexion de l'utilisateur. Supprimer de la mémoire les informations relatives à celui-ci et rediriger la vue utilisateur vers **loginController**


###appsController

**appsController** permet à l'utilisateur de choisir entre les diverses applications auxquelles il a accès. Lorsque l'utilisateur sélectionne une application, un message est envoyé à **baseController** qui redirige celui-ci vers la vue adéquate



##modules métier

###baseSites

Définit les controleurs et initialise les routes relatifs à la gestion des sites.


####siteListController

Controleur chargé de récupérer les schémas et données nécessaires pour afficher une liste de sites et leur localisation géographique en s'appuyant sur les directives *maplist*, *leaflet-map* et *tablewrapper*
Selon les droits de l'utilisateur, affiche un bouton de création d'un nouveau site


####siteDetailController

Controleur chargé d'initialiser les directives *leaflet-map* et *detail-display* pour l'affichage détaillé des données relatives à un site

####siteEditController

Controleur chargé d'initialiser la directive *simpleform* afin d'afficher un formulaire de création/modification de site, puis de rediriger la vue utilisateur lorsque celui-ci enregistre ses données.


###baseObservations

Définit les controleurs et initialise les routes relatifs à la gestion des observations


####observationListController

Controleur chargé de récupérer les schémas et données nécessaires pour afficher une liste d'inventaires. Les seules différences avec *siteListController* sont les urls et et la valeur des droits nécéssaires à l'affichage du bouton de création d'une nouvelle observation.


####observationDetailController & observationSsSiteDetailController

Controleurs permettant d'afficher le detail des données relatives respectivement à des observations sur site et des observations sans site. Les deux controleurs sont à peu de choses près les mêmes (seules les urls d'initialisation changent), et ressemblent fortement à *siteDetailController* (la seule différence autre que les urls est un formatage du titre).
Les templates d'affichage sont exactement les mêmes, et la différence avec le template d'affichage de *siteDetailController* est uniquement dans les styles bootstrap.


####observationEditController & observationSsSiteEditController

Controleurs chargés d'initialiser la directive *simpleform* afin d'afficher un formulaire de création/modification d'observations (respectivement avec ou sans site). Les différences avec *siteEditController* sont les urls et le formatage du titre.


###baseTaxons

Définit les controleurs spécifiques pour la gestion des taxons


####taxonDetailController

Controleur chargé d'initialiser la directive *detail-display* pour l'affichage détaillé des données relatives à un taxon
Les différences avec les controleurs précédents sont relatives à l'absence d'affichage de données carto


####taxonEditController

Controleurs chargés d'initialiser la directive *simpleform* afin d'afficher un formulaire de création/modification d'observations de taxon.
Très proche du controleur *observationEditController* 


###baseBiometrie

Définit les controleurs spécifiques pour la gestion des biométries


#### biometrieEditController & biometrieDetailController

Les controleurs sont semblables à leur équivalent dans baseTaxon, les templates sont exactement les mêmes.

