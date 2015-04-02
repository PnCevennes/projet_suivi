#Schémas

Les schémas sont prévus pour configurer coté serveur l'aspect de la plupart des éléments coté client afin de permettre un maximum de réutilisabilité de la partie front

Les schémas se présentent dans la plupart des cas sous forme de liste.


les schémas sont censés être récupérés coté client via le service configServ. Ils sont systématiquement mis en cache coté client afin de n'avoir à les charger qu'une seule fois. Il est inutile de scinder les configurations selon le type de vue pour gagner en performances.


##Formulaires

###Exemple

    $schema = array(
        array(
            'name'=>'variable1',
            'label'=>'libellé var 1',
            'type'=>'hidden',
            'help'=>'',
            'options'=>array()
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
    );


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
les champs label et help ne sont plus visibles non plus

aucune option définie


####string

crée un input type `text`

les options possibles sont `minLength` et `maxLength`


####text

crée un textarea

aucune option définie.


####num

crée un input type `numeric`

aucune option définie (?TODO)


####date

crée un input type `date` (fonctionnel sous chrome, equivalent text sous firefox)

aucune option définie


####select

crée un select

option obligatoire : `choices` sous la forme d'une liste de dicos [{id: ?, libelle: ?}]


####file

crée un bouton d'upload de fichiers

aucune option définie
options à définir : filtre d'extensions acceptées + voir les possibilité de la directive


####xhr

crée un champ texte avec autocompletion ajax

option obligatoire : `url` pour indiquer l'url à contacter pour obtenir les possibilités de completion

l'url contactée doit renvoyer une liste de dicos [{id: x, label: y}] où x est la valeur souhaitée, et y les libellés de réponse.



###Options non liées au type de champ

####multi (bool)

un champ avec l'option `'multi'=>true` devient répétable

?TODO voir une limite de répétition ('multi'=>3) ne permettrait de répéter que 3 fois le champ



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

en cours d'adaptation

        array(
            'name'=>'siteCode',
            'label'=>'Code site',
            'type'=>'string',
            'help'=>'',
            'options'=>array()
        ),
        array(
            'name'=>'nomObservateur',
            'label'=>'Observateur',
            'type'=>'string',
            'help'=>'',
            'options'=>array(),
        ),
        array(
            'name'=>'siteDate',
            'label'=>'Date de création',
            'type'=>'date',
            'help'=>"Date d'ajout du site à la base de données",
            'options'=>array(),
        ),

Voir le paragraphe sur les formulaires pour la description des champs

Seule chose à noter, un filtre est automatiquement appliqué sur les types `date` pour transformer le format `Y-m-d` au format `d/m/Y`
