#Schémas

Les schémas sont prévus pour configurer coté serveur l'aspect de la plupart des éléments coté client afin de permettre un maximum de réutilisabilité de la partie front

Les schémas se présentent dans la plupart des cas sous forme de liste.


les schémas sont censés être récupérés coté client via le service configServ. Ils sont systématiquement mis en cache coté client afin de n'avoir à les charger qu'une seule fois. 

##Formulaires

###Exemple

    $schema = array( //objet schema
        'groups'=>array( //liste des groupes 
            array( // objet groupe
                'name'=>'Nom du groupe',
                'fields'=>array( // liste des champs
                    array( // objet champ
                        'name'=>'variable1',
                        'type'=>'hidden',
                    ),
                    array(
                        'name'=>'variable2',
                        'label'=>'libellé var 2',
                        'type'=>'string',
                        'help'=>'complément au libellé var 2',
                        'options'=>array('minLength'=>5, 'maxLength'=>250)
                    ),
                    array(
                        'name'=>'typeId',
                        'label'=>'Type',
                        'type'=>'select',
                        'help'=>'Type de lieu',
                        'options'=>array('choices'=>$typesLieu),
                        'default'=>37
                    ),
                ),
            ),
        ),
    );


S'il y a plus d'un groupe, l'affichage du formulaire est scindé en différents panneaux avec une sous-validation style "wizard".


###Champs

`name` identifie la variable
`label` le label associé au champ de formulaire
`type` le type de donnée
`help` un sous label explicatif si besoin (écrit en plus petit sous le label du champ)
`options` les options possibles au type de champs
`default` la valeur par défaut du champ


###Types

####hidden
crée un input type `hidden`
les champs label et help ne sont pas affichés.

aucune option définie


####string

crée un input type `text`

options : 
 - minLength : longueur minimum du texte 
 - maxLength : longueur maximum du texte

un champ dont la minlength est supérieure à 0 est automatiquement passé en "required"


####text

crée un textarea

aucune option définie.


####num

crée un input type `numeric`

options : 
- min : la valeur minimale
- max : la valeur maximale
- step : le pas d'incrémentation


####date

crée un datepicker

pas d'options particulières
format de date : yyyy-MM-dd

####select

crée une liste déroulante

option obligatoire : `choices` sous la forme d'une liste de d'objets [{id: ?, libelle: ?}]


####file

crée un bouton d'upload de fichiers

aucune option définie
options à définir : filtre d'extensions acceptées + voir les possibilité de la directive


####xhr

crée un champ texte avec autocompletion ajax

options obligatoires : 
- url : pour indiquer l'url à contacter pour obtenir les possibilités de completion
- reverseurl : pour indiquer l'url à contacter pour obtenir le label lié à la donnée fournie (cas d'un formulaire de modification)

les url contactées doivent renvoyer une liste de dicos [{id: x, label: y}] où x est la valeur souhaitée, et y les libellés de réponse.



###Options non liées au type de champ

####multi (bool)

un champ avec l'option `'multi'=>true` devient répétable

?TODO voir une limite de répétition ('multi'=>3) ne permettrait de répéter que 3 fois le champ


####required (bool)
indique qu'un champ est obligatoire


##Tables ng-table

###Exemple


    array(
        'name'=>'id',
        'label'=>'ID',
        'filter'=>array('id'=>'text'),
        'options'=>array('visible'=>true)
    ),
    array(
        'name'=>'siteNom',
        'label'=>'Nom',
        'filter'=>array('siteNom'=>'text'),
        'options'=>array('visible'=>true)
    ),
    array(
        'name'=>'siteCode',
        'label'=>'Code site',
        'filter'=>array('siteCode'=>'text'),
        'options'=>array()
    ),

`name` le nom de la clé 
`label` le libellé de la colonne
`filter` configure le filtre de ng-table 
`options` une seule option disponible `visible=>bool` pour faire apparaitre cette colonne à l'initialisation du formulaire ou pas.


##Detail (table html)


        $out = array(
            'subSchemaUrl'=>'chiro/config/obstaxon/list',
            'subDataUrl'=>'chiro/obs_taxon/observation/',
            'groups'=>array(
                array(
                    'name'=>'Observation',
                    'fields'=>array(
                        array(
                            'name'=>'siteNom',
                            'label'=>'Site',
                            'type'=>'string',
                        ),
                        array(
                            'name'=>'obsDate',
                            'label'=>'Date',
                            'type'=>'date',
                            'help'=>'',
                            'options'=>array()
                        ),
                        array(
                            'name'=>'numerisateur',
                            'label'=>'Numerisateur',
                            'type'=>'xhr',
                            'help'=>'',
                            'options'=>array('url'=>'chiro/observateurs/id')
                        ),
                        ...

Le format des schémas d'affichage suit le même format que celui des formulaires.
Les groupes servent à séparer les données affichées en plusieurs panneaux.


Voir le paragraphe sur les formulaires pour la description des champs

Seule chose à noter, un filtre est automatiquement appliqué sur les types `date` pour transformer le format `Y-m-d` au format `d/m/Y`
