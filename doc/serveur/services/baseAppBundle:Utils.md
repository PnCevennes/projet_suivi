#BaseAppBundle/Utils

Dossier contenant les services utilitaires de l'application.


##ConfigService

Service de gestion des fichiers de configuration Yaml destinés au client.

La méthode`get_config` analyse le fichier yaml dont le chemin lui a été passé en paramètre et 
complète le contenu à partir de données extraites du thésaurus si besoin.


###Methodes

**public get_config($path)** lit un fichier yaml et renvoie un dictionnaire.

**private parse_list(&$list)** complete les éléments de la liste fournie lorsqu'un
champ est de type `select` et qu'une référence au thésaurus est fournie via une variable 
`thesaurusID`.


###Utilisation

```php
    function XxxConfigAction(){
        $confService = $this->get('configService');
        return new JsonResponse($confService->get_config('chemin/vers/fichier.yaml'));
    }
```




##ThesaurusService

Service facilitant le chargement d'une liste de valeurs depuis le thesaurus.


###Methodes

**public get_list($typeId [, $nullable=true])** retourne la liste de valeurs associée à `$typeId`.

lorsque $nullable vaut true (par défaut), la liste est complétée par une valeur nulle {'id': 0, libelle: ''}


###Utilisation

```php
    //contexte controleur
    $thesaurus = $this->get('thesaurusService');
    $typeSites = $thesaurus->get_list(7, false);
```



##EntityService

Service factorisant l'"hydratation" et la normalisation des entités.


###Methodes

**public hydrate($object, $schema, $data)** insère les données issues de `$data` dans l'entité doctrine `$object` en
suivant le schema fourni `$schema`

le parametre schema peut être 

- soit un dictionnaire avec comme clés les champs à insérer et comme valeurs les méthodes de transformation (null lorsque la donnée n'est pas à modifier)
- soit le chemin du mapping doctrine de l'entité.

Une exception DataObjectException est levée si les données contenues dans `$data` ne sont pas valides.
La validation des données de fait dans les setters de l'entité fournie.

note : la méthode ne retourne rien, l'objet fourni est modifié par référence.


**public normalize($object, $schema)** extrait les données d'une entité doctrine `$object` en suivant le schéma
fourni `$schema` 

- soit un dictionnaire avec comme clés les champs à insérer et comme valeurs les méthodes de transformation (null lorsque la donnée n'est pas à modifier)
- soit le chemin du mapping doctrine de l'entité.


**private read_mapping($path)** méthode utilisée par `hydrate` et `normalize`. Lit le fichier mapping dont le chemin
est fourni et retourne le contenu sous forme de dictionnaire

**private camelize($value)** transforme une chaîne utilisant une _ pour séparer les mots en chaîne camelCase.

**private transform_to($method, $data)** methode utilisée par `normalize`. Transforme une donnée selon la méthode fournie.

Par exemple un objet de type \DateTime sera transformé en chaîne "Y-m-d"

**private transform_from($method, $data)** methode utilisée par `hydrate`. Transforme une donnée selon la méthode fournie.

Par exemple une chaine "d/m/Y" sera transformée en objet \DateTime.


#Utilisation

```php
    $schema = '../src/PNC/ChiroBundle/Resources/config/doctrine/ObservationTaxon.orm.yml';
    $repo = $this->db->getRepository('PNCChiroBundle:ObservationTaxon');
    $data = $repo->findOneBy(array('id'=>$id));
    if($data){
        $out = $this->entityService->normalize($data, $schema);
        return $out;
    }
    return null;
```

```php
    $schema = array(
        'id'=>null,
        'obsTxId'=>null,
        'ageId'=>null,
        'sexeId'=>null,
        'biomAb'=>null,
        'biomPoids'=>null,
        'biomD3mf1'=>null,
        'biomD3f2f3'=>null,
        'biomD3total'=>null,
        'biomD5'=>null,
        'biomCm3sup'=>null,
        'biomCm3inf'=>null,
        'biomCb'=>null,
        'biomLm'=>null,
        'biomOreille'=>null,
        'biomCommentaire'=>null,
        'numerisateurId'=>null,
    );

    $biom = new Biometrie();
    $this->entityService->hydrate($biom, $schema, $data);
    $manager->persist($biom);
    $manager->flush();
```


##GeometryService

Service générant des types compatibles doctrine à partir de données géometriques


###Methodes

**getPoint($coords)** retourne un type Point

$coords est une liste de coordonnées dont seule la première est prise en compte

```
    [[1, 1]]
```

**getLineString($coords)** retourne un type LineString à partir d'une liste de coordonnées

**getPolygon($coords)** retourne un type Polygon à partir d'une liste de coordonnées

note : Le premier point est dupliqué en dernière position afin de fermer le polygone



##PaginationService

Service utilitaire pour paginer et filtrer les requêtes renvoyant des listes de données


###Methodes

**filter($entity, $fields [, $curPage=null [, $maxResults=null [, $cpl=null]]])** retourne 
le résultat d'une requête sur l'entité `$entity` filtrée en fonction de `$fields`

`$fields` est une liste de dictionnaires de configuration de filtre
```
    {
    name: "nom du champ",
    compare: "type de comparaison (=, >, <, <=, >=, !=, between, like)
    value: "valeur de comparaison"
    }
```

`$curPage` est le numéro de page en cours pour la pagination des données

`$maxResults` le nombre de résultats par page

`$cpl` filtres complémentaires utilisés également pour le calcul du total des données existantes

Le résultat retourné est un dictionnaire :
```
    {
    total: nombre total de données non filtrées, hormis par $cpl
    filteredCount: nombre total de données filtrées, non paginées
    filtered: liste des données filtrées et paginées
    }
```

**filter_request($entity, $request, $cpl)** methode facilitant le filtrage en acceptant directement 
les filtres envoyés via une requête http.
