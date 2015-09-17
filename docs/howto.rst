HOWTO - Créer un nouveau module
===============================

Etape 1 - Création du bundle
----------------------------

.. code:: 
    app/console generate:bundle --namespace=PNC/HowToBundle

Répondre yml à la question concernant les choix de configuration

Répondre oui à toutes les autres questions.


correction du fichier app/config/routing.yml::
    pnc_how_to:
        resource: "@PNCHowToBundle/Resources/config/routing.yml"
        prefix:   /howto/




Etape 2 - Génération de la BDD
------------------------------

.. code:: SQL
    CREATE SCHEMA howto;
    CREATE TABLE howto.t_howto (
        id serial,
        ht_nom VARCHAR(100),
        ht_valeur INTEGER,
        ht_commentaire VARCHAR(1000)
    );


    --Ajout de l'application au système d'authentification

    INSERT INTO utilisateurs.t_application (nom_application) values ('howto') RETURNING id_application;
    --valeur retournée : 1000006 (à noter utilisée plus tard pour la déclaration de l'application cliente)
    
    --en considérant qu'il y a un utilisateur Admin dont l'id_role = 1
    INSERT INTO utilisateurs.cor_role_droit_application (id_role, id_droit, id_application) VALUES (1, 6, 1000006);


    -- insertion de données test
    INSERT INTO howto.t_howto (ht_nom, ht_valeur, ht_commentaire) VALUES ('test1', 1, 'test1a'), ('test2', 2, 'test2b'), ('test3', 3, 'test3c')




Etape 3 - Création des mappings
-------------------------------


3.1 Création du schéma
~~~~~~~~~~~~~~~~~~~~~~


fichier PNC/HowToBundle/Resources/config/doctrine/howto.orm.yml::
    PNC\HowToBundle\Entity\Howto:
        type: entity
        table: howto.t_howto
        schema: howto
        id:
            id:
                type: integer
                id: true
                generator:
                    strategy: AUTO
        fields:
            ht_nom:
                type: text
            ht_valeur:
                type: integer
            ht_commentaire:
                type: text

.. note::
    Les mappings étant réalisés pour une table existante, il est possible d'être un peu laxiste sur le typage des données. 
    
    Il est par contre nécéssaire de controler les données dans les mutateurs de la classe Entité générée.



3.2 Génération de l'entité
~~~~~~~~~~~~~~~~~~~~~~~~~~


.. code::
    app/console doctrine:generate:entities PNC

.. note::
    Cette méthode régénere toutes les entités existantes dans l'application. Les modifications apportées aux entités régénérées ne sont cependant pas affectées.



3.3 Modification de l'entité générée
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


fichier PNC/HowToBundle/Entity/Howto.php (condensé)::
    <?php
    namespace PNC\HowToBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use PNC\Utils\BaseEntity;

    class Howto extends BaseEntity{
        private $id;
        private $ht_nom;
        private $ht_valeur;
        private $ht_commentaire;

        //...
        public function setHtNom($nom){
            if(strlen($nom)>100){
                $this->add_error('htNom', 'La longueur doit être inférieure à 100 caractères');
            }
            $this->ht_nom = $nom;
        }
        //...
    }


Cette modification permet d'utiliser la classe BaseEntity pour la gestion des erreurs.


Etape 4 - Création des contrôleurs
----------------------------------

4.1 Controleur liste
~~~~~~~~~~~~~~~~~~~~

Ajout au fichier PNC/HowToBundle/Resources/config/routing.yml::

    howto_list:
        path: /howto
        defaults: { _controller: PNCHowToBundle:Default:list }
        requirements:
            _method: GET


Création du controleur (fichier PNC/HowToBundle/Controller/DefaultController.php)::
    <?php
    namespace PNC\HowToBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;

    class DefaultController extends Controller{
        public function listAction(Request $req){
            // entité a charger
            $entity = 'PNCHowToBundle::Howto';

            // schéma utilisé pour la normalisation
            $schema = array(
                'id'=>null,
                'htNom'=>null,
                'htValeur'=>null
            );

            // initialisation des services
            $ps = $this->get('pagination');
            $es = $this->get('entityService');

            // requête
            $result = $ps->filter_request($entity, $req);

            // mise en forme du résultat
            $out = array();
            foreach($result['filtered'] as $item){
                $out[] = $es->normalize($item, $schema);
            }

            $result['filtered'] = $out;
            return new JsonResponse($result);
        }
    }


À cette étape, l'url *appurl/howto/howto* doit renvoyer la liste des données sous forme de JSON.



4.2 Configuration de l'application cliente
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


Déclaration du module à l'application cliente::

    -   id: 2
        name: Howto
        base_url: "g/howto/howto/list"
        appId: 1000006
        menu:
            -   url: "#g/howto/howto/list"
                label: "Howto"
                restrict: 1



4.3 Creation du controleur de configuration
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


Déclaration de la route dans le fichier PNC/HowToBundle/Resources/config/routing.yml::

    howto_config:
        path: /config/{view_name}
        defaults: { _controller: PNCHowToBundle:Default:config }
        requirements:
            _method: GET


Création du controleur::

    public function configAction($view_name){
        $configs = array(
            'list'=>__DIR__ . '../Resources/clientConf/howto/list.yml',
        );

        // initialisation configservice
        $cs = $this->get('configService');
        
        if(isset($config[$view_name])){
            return new JsonResponse($cs->get_config($configs[$view_name]));
        }
        else{
            return new JsonResponse(array(), 404);
        }
    }


Création du fichier de configuration *PNC/HowToBundle/Resources/clientConf/howto/list.yml*::

    title: "howto"
    emptyMsg: "Aucun howto enregistré"
    dataUrl: "howto/howto"
    editAccess: 6
    createBtnLabel: "Nouveau howto"
    createUrl: "#/g/howto/howto/edit"
    editUrl: "#/g/howto/howto/edit/"
    detailUrl: "#/g/howto/howto/detail/"
    filtering:
        limit: null
    fields:
        -   name: id
            label: ID
            type: text
            filter:
                id: text
            options:
                visible: false
        -   name: ht_nom
            label: "Nom"
            type: text
            filter:
                ht_nom: text
            options:
                visible: true
        -   name: ht_valeur
            label: "Valeur"
            type: text
            filter:
                ht_valeur: text
            options:
                visible: true

À cette étape, l'url *appurl/#/g/howto/howto/list* doit afficher un tableau de données 




