#Front

##Services (services.js)


###dataServ

Service gerant les communications avec le serveur.


####dataServ.get(url, success, [error, [force]])

Envoie une requete GET au serveur.
Les résultats renvoyés sont mis en cache automatiquement et réutilisés à la requete suivante, à moins qu'elle passe le parametre "force" à true.
Il est également possible de passer le parametre dataServ.forceReload à true pour forcer la requête suivante.
les parametres "success" et "error" sont des fonctions qui seront appelées pour traiter le retour du serveur. 


####dataServ.post(url, data, success, [error])

Envoie une requete POST au serveur.


####dataServ.put(url, data, success, [error])

Envoie une requete PUT au serveur


####dataServ.delete(url, success, [error])

Envoie une requete DELETE au serveur


####dataServ.getFromCache(cacheName, path)

Recherche un élément particulier dans le cache "cacheName" en fonction de "path"
Cf: [documentation angular filter](https://docs.angularjs.org/api/ng/filter/filter)

exemple:

    $scope.ref = dataServ.getFromCache('chiro/site', {properties: {id: $routeParams.id}});
    
ira chercher dans le cache "chiro/site" (la liste des sites) l'élément correspondant à l'id passé en parametre de la vue.



###ConfigServ

Service permettant de stocker les configurations ou n'importe quelle variable pour les réutiliser de page en page


####ConfigServ.getUrl(url, success)

Envoie une requete GET au serveur, stocke la réponse en cache et renvoie la réponse via la callback success
Une fois chargées depuis le serveur, les données ne sont plus jamais rechargées et sont modifiables par référence.


####ConfigServ.get(key, success)

Retourne la valeur associée à 'key' via la callback success


####ConfigServ.put(key, value)

Stocke la valeur 'value' dans le cache




###mapService

Service gerant la carte leaflet

**mapService.map** : la carte

**mapService.markLayer** : le layer contenant les markers (markerClusterGroup)

**mapService.marks** : la liste des points existants

**mapService.addPoint(point)** : ajoute un point à la carte

**mapService.filterMarks(ids)** : reçoit une liste d'ids et ne laisse sur la carte que les points correspondants

**mapService.clear()** : vide la carte et la liste des points

**mapService.getMarker(id)** retourne le marker correspondant à l'id fourni


###datefr

Filtre d'affichage à appliquer sur une date format iso (YYYY-MM-DD...)
retourne la date au format français (DD/MM/YYYY)
