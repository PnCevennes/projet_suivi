#Entités

Les fichiers Yaml de définition des entités sont utilisés à plusieurs endroits dans l'application. Il est par conséquent **obligatoire** de définir les entités via Yaml et non par annotation ou XML.

Pour la validation des données, il est nécéssaire de modifier les entités générées afin de les faire hériter de `PNC\Utils\BaseEntity` qui fournit les méthodes utilisées en interne pour vérifier la validité des entités.


##Validation des données

La vérification des données se fait dans les "setters" de l'entité.

Si le test de la donnée est invalide, la classe `BaseEntity` fournit la méthode `add_error(nom_variable, message_erreur)` pour la signaler.

**nom_variable** doit être le même que le nom utilisé dans les schémas (camelCase)

ex :

```php
class Animal extends BaseEntity{
    private $taille_animal;

    public setTailleAnimal($valeur){
        if($valeur<5){
            $this->add_error('tailleAnimal', 'La taille doit être supérieure à 5.');
        }
        else{
            $this->taille_animal = $valeur;
        }
    }
}
```

La méthode `entityService::hydrate` ou les méthodes `entityService::create`, `entityService::update` lèveront une exception `Commons\Exceptions\DataObjectException` si l'entité contient des erreurs.

La méthode `DataObjectException::getErrors()` permet de récupérer la liste des erreurs.

Il convient que le controleur renvoie une erreur 400 dans ce cas.

```php
    //...
    catch(DataObjectException $e){
        return new JsonResponse($e->getErrors(), 400);
    }
```
