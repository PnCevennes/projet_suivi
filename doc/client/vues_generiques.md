#Vues génériques

Il est possible d'utiliser des controleurs génériques pour chaque type de vue (list/detail/edit)

Les urls à utiliser doivent alors etre préfixées par **g** et suffixées par la vue souhaitée

```
#/g/{{appli}}/{{vue}}/list
#/g/{{appli}}/{{vue}}/detail/{{id}}
#/g/{{appli}}/{{vue}}/edit/{{id?}}
```

Afin de récupérer le schéma, les vues construisent une url correspondant à 
`{{appli}}/config/{{vue}}/{{fonction}}` pour fonction (list/detail/form)



