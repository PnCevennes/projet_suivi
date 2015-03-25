#Serveur

##Démarrage serveur en dev

    $ app/console server:run

le serveur tourne sur le port 8000


##Mise a jour des entités

    $ app/console doctrine:generate:entities NameSpace\Bundle

NB: Lors de la mise à jour des entités : les champs et accesseurs ajoutés le sont à la suite du code existant. 



##Mise à jour de la DB

    $ app/console doctrine:schema:update

Opinion : Moyen glop. il est peut-être préférable de créer la base manuellement et de mapper ensuite.



##Dépendances :

**Doctrine2-spatial** 
ajouter à composer.json section "require"-> "creof/doctrine2-spatial": "dev-master"
puis
    
    $ composer update



#Utils

Services utilitaires

**GeomertryService** est un raccourci pour créer les instances géométriques utilisées par le plugin doctrine2-spatial

depuis un controleur :

    ...
    $geo = $this->get('geometry');
    $geo->geoJsonToPoint($geoJsonPoint);
    ...

**NormalizeService** est un raccourci pour récupérer une instance de GetSetMethodNormalizer qui permet de transformer une entité doctrine en dictionnaire directement sérialisable en JSON

Limitations : Certains types de champs ne sont pas normalisables. 

- date (Objet DateTime qui peut être réinjecté tel quel dans le dictionnaire (directement sérialisable), ou alors converti en str via DateTime::format())
- geometry (normalement inutilisé en lecture -> lecture via vue DB)
- relations suivant le type de relation (et celles qui le sont peuvent parfois engendrer des boucles infinies)

depuis un controleur :

    ...
    $norm = $this->get('normalizer');
    $norm->normalize($entite, array('ignore1', 'ignore2');
    ...

#BaseAppBundle

Module servant de base aux autres modules.

##Entités définies:

- Site
- Observation
- Thésaurus

##Entités à définir: ::TODO

- Observateur
- Taxonomie


##Routes

**GET /apps**
*ConfigController::getAppsAction*

Retourne la liste des applications utilisables



#ChiroBundle

Module spécifique aux protocoles Chiro

##Entités définies:

- SiteView -- mapping de la vue spécifique aux lieux "chiro"
- InfoSite -- complément de *BaseApp:Site* spécifique aux chiro
- ConditionsObservation -- complément de *BaseApp:Observation* spécifique aux chiro
- ObservationTaxon 
- Biometrie 


##Routes


**GET /chiro/siteForm**
*ConfigController::getSiteFormAction*

retourne le schéma du formulaire de création/édition de site


**GET /chiro/site**
*SiteController::listAction*

Retourne la liste des sites "chiro" via la vue DB "chiro.vue_chiro_site" 


**GET /chiro/site/{id}**
*SiteController::detailAction*

Retourne 1 site identifié par ID via la vue DB "chiro.vue_chiro_site" 


**PUT /chiro/site**
*SiteController::createAction*

Ajoute un nouveau site
retourne une erreur 422 en cas d'échec


**POST /chiro/site/{id}**
*SiteController::updateAction*

Met à jour un site 
retourne une erreur 422 en cas d'échec


**DELETE /chiro/site/{id}**
*SiteController::deleteAction* 

Supprime un site


##Notes

les fonctions *SiteController::hydrateSite()* et *SiteController::hydrateInfoSite()* permettent de "peupler" les objets "Site" et "InfoSite"

###Récupération des données POST en provenance d'angular

La fonction "vue" doit recevoir l'objet 'Request' -> *Symfony\Component\HttpFoundation\Request*

    public function trucAction(Request $req){
        $post_data = json_decode($req->getContent(), true);
    }

NB: penser a passer 'true' en deuxième parametre de json_decode pour récupérer un tableau associatif et non une StdClass
