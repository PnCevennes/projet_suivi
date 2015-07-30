#mapService

Service servant à publier les différentes fonctions de la directive **leafletMap**


###Méthodes

####initialize(configUrl)

Initialise la carte.

params: 

 - **configUrl** adresse du fichier de configuration des fonds de carte

returns:

*promise*


####getVisibleItems()

retourne la liste des ID des éléments actuellement visibles sur la carte

returns:

*list*


####getLayerControl()

retourne le controleur de layers

returns:

*L.layerControl*


####getLayer()

retourne le layer principal de la carte (markerCluster)

returns:

*L.MarkerCluster*


####getMap()

retourne la carte

returns:

*L.map*


####getGeoms()

retourne la liste des géométries

returns:

*list*


####filterData(ids)

filtre les géométries en fonction des IDS fournis

params:

**ids** liste des IDS à afficher

returns:

*null*


####getItem(ID)

recentre la carte sur la géométrie associée à ID et retourne celle-ci

params:

**ID** ID de la géométrie

returns:

*L.marker/L.polyLine/L.polygon*


####selectItem(ID)

selectionne la géométrie associée à ID, change son style d'affichage, recentre la carte dessus et la retourne

params:

**ID** ID de la géométrie

returns:

*L.marker/L.polyLine/L.polygon*


####addGeom(geojson)

ajoute une géométrie au layer principal et retourne l'objet *leaflet* généré

params:

**geojson** géométrie au format GeoJson

returns:

*L.marker/L.polyLine/L.polygon*


####loadData(url)

charge des géométries au format GeoJson depuis l'url fournie et les affiche dans le layer principal

params:

**url** url des données à charger

returns:

*promise*




#leafletMap

Affiche une carte


##messages

###mapService:itemClick

message broadcasté lorsqu'un marker ou une géométrie est cliqué.

params: geometrie cliquée


###mapService:dataLoaded

message broadcasté lorsque la directive a fini de charger ses données.

params: aucun


###mapService:centerOnSelected

message broadcasté lorsque l'utilisateur clique sur le bouton de recentrage

params: aucun


###mapService:pan

message broadcasté lorsque l'utilisateur fait glisser la carte

params: aucun



##listeners

###mapService:centerOnSelected

recentre la carte sur la géométrie selectionnée




#mapList

Relaye les messages entre la carte et une liste.

##messages

{{target}}:select

{{target}}:filterIds


##listeners


mapService:itemClick

mapService:pan

{{target}}:ngTable:ItemSelected

{{target}}:ngTable:Filtered
