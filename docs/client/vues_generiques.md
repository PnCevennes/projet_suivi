#Vues génériques

Il est possible d'utiliser des controleurs génériques pour chaque type de vue (list/detail/edit)

Les urls à utiliser doivent alors etre préfixées par **g**, suffixées par la fonction souhaitée (list/detail/form) et complétées par l'identifiant de donnée si nécéssaire.


```
#/g/{{appli}}/{{vue}}/list -> affiche la liste des objets
#/g/{{appli}}/{{vue}}/detail/{{id}} -> affiche le détail d'un objet
#/g/{{appli}}/{{vue}}/edit/{{id?}} -> affiche le formulaire de création ou d'édition d'un objet
#/g/{{appli}}/{{vue}}/{{protocoleParent}}/edit/{{idReference}} -> affiche le formulaire de création d'un sous objet du protocole parent identifié par "idReference"
```

Afin de récupérer le schéma, les vues construisent une url correspondant à 
`{{appli}}/config/{{vue}}/{{fonction}}` pour fonction (list/detail/form)



