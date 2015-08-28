#Commons

Namespace ou sont définis les vues et services utilisables dans différentes applications.


#Commons/UsersBundle

Bundle destiné à gérer l'authentification des utilisateurs et les sessions.


##UserService

Service permettant de récupérer les informations concernant l'utilisateur et de vérifier son niveau d'accréditation.

###Methodes

**public getUser()** retourne les informations sur l'utilisateur connecté.


**public checkLevel($level, $app)** retourne true si l'utilisateur connecté possede un niveau de droit supérieur ou égal à `$level` pour l'application `$app` demandée.


**public isOwner($item_owner)** retourne true si l'ID de l'utilisateur connecté est le même que l'ID fourni `$item_owner`
