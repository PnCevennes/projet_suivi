#Front

##Services (services.js)


###dataServ

Service gerant les communications avec le serveur.


####dataServ.get(url, success, [error, [force]])

Envoie une requete GET au serveur.
Les résultats renvoyés sont mis en cache automatiquement et réutilisés à la requete suivante, à moins qu'elle passe le parametre "force" à true.
Il est également possible de passer le parametre dataServ.forceReload à true pour forcer la requête suivante.
les parametres "success" et "error" sont des fonctions qui seront appelées pour traiter le retour du serveur. 


    //récupération de la liste des sites chiro
    dataServ.get('chiro/site', function(response){
        $scope.sites = response
    }, function(error){
        console.log(error.status); //affiche le n° d'erreur serveur (404, 500, etc.)
    });



####dataServ.post(url, data, success, [error])

Envoie une requete POST au serveur.

    
    dataServ.post('test/foo', {foo: 'foo', bar: 'bar'}, function(response){
        //succès 
    }, function(error){
        //erreur
    });


####dataServ.put(url, data, success, [error])

Envoie une requete PUT au serveur avec la même syntaxe que *dataServ.post*


####dataServ.delete(url, success, [error])

Envoie une requete DELETE au serveur


    dataServ.delete('test/foo?bar=bar', function(resp){
        //succès
    }, function(error){
        //erreur
    })




###configServ

Service permettant de stocker les configurations ou n'importe quelle variable pour les réutiliser de page en page


####configServ.getUrl(url, success)

Envoie une requete GET au serveur, stocke la réponse en cache et renvoie la réponse via la callback success
Une fois chargées depuis le serveur, les données sont mises en cache et peuvent être modifiées par référence.
Utilisée généralement pour récupérer les schémas.


    //récupération du schéma de base de l'application
    configServ.getUrl('config/apps', function(response){
        $scope.schema = response;
    });



####configServ.put(key, value)

Stocke la valeur 'value' dans le cache


    configServ.put('whatever', 'whatever');


####configServ.get(key, success)

Retourne la valeur associée à 'key' via la callback success


    configServ.get('whatever', function(response){
        $scope.whatever = response
    });



###userServ

Service permettant de gérer les données relatives à l'utilisateur connecté


####userServ.getUser()

Retourne les informations relatives à l'utilisateur courant. 
A l'ouverture de l'application, reconnecte l'utilisateur précédemment connecté.


####userServ.setUser()

Enregistre l'utilisateur courant en session navigateur.


####userServ.getCurrentApp()

Retourne l'ID de l'application prédémment utilisée par l'utilisateur lors d'une reconnexion à l'application


####userServ.setCurrentApp(appId)

Enregistre l'ID de l'application courante pour reconnecter automatiquement l'utilisateur à l'ouverture de sa prochaine session


####userServ.checkLevel(level)

Vérifie que l'utilisateur a un niveau de droits équivalent ou supérieur au niveau fourni


####userServ.isOwner(ownerId)

Permet de vérifier que l'utilisateur est considéré comme "propriétaire" d'une donnée
Vérifie que l'ID de l'utilisateur est le même que le l'ID "propriétaire" fourni


####userServ.login(login, password)

Envoie les informations de connexion au serveur et enregistre les parametres de l'utilisateur en session en cas de succès
messages : 

`user:login`, user

message broadcasté lorsque l'utilisateur est connecté avec succès


`user:error`

message broadcasté en cas d'erreur de connexion


####userServ.logout()

Envoie un message de déconnexion au serveur et efface les données relatives à l'utilisateur de la session application
messages :

`user:logout`

message broadcasté lorsque l'utilisateur est déconnecté




##Filtres

###datefr

Filtre d'affichage à appliquer sur une date format iso (YYYY-MM-DD...)
retourne la date au format français (DD/MM/YYYY)


###tselect

Filtre d'affichage
Affiche un label tiré d'une liste de choix en fonction de son ID


