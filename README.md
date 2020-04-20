# Description du code source de l'espace membre 

Cette application permet de : 
1. S’inscrire et réservoir l’activation de son compte pas mail 
2. Se connecter et se déconnecter de son espace 
3. Contrôle de validation l’or de l’inscription et l’or de l’oublie  des mots de passe 
4. Modifier son mot de passe avec un lien reçu par mail  
5. Possibilité de cocher une case pour se garder en souvenir 
6. Notification visuelle à chaque action 


## Technologie utilisée était : 
> - php
> - HTML
> - CSS
> - Java Script     

## Les classes
### App.php
> Contient les fonctions telle que :
> getDatabase() - permet de récupéré la basse de donnée 
> redirect() - permet de rediriger vert un autre page 
> getAuth() - permet de récupéré l’instance de la session 

### Auth.php
Cette classe contient toutes les méthodes relatives à la gestion des données fournir par le client :
* un constructeur qui repère la session en cours   
> des fonctions : 
> - hashPassword() 
> - register () – pour inscrire un utilisateur après validation des données entre. 
> - confirm() - qui permet d’envoie a l’utilisateur d’être enregistre dans la session si son mail de confirmation  est valide.
> - restrict() - empêche un utilisateur de d’utiliser deux sont token de validation.
> - user () – permet de mettre l’utilisateur dans la session en cours.
> - connect () - récupéré l’utilisateur dans la session en cours.
> - connectFromCookie() – pour récupérer la sessions qui on n’a cocher se souvenir de moi. 
> - login () – permet la connexion des personnes déjà inscrire.
> - logout () – pour la déconnexion.
> - remember () – permet le rappelle se session du client 
> - checkResetToken() – verifie si l’utilisateur a déjà utiliser le token qui lui a été envoie par mail ou pas.

### Database.php
Permet la connections à la base de donne 
Dispose d’un constructeur qui permet un connexion une foi pour tout a la base de données. 
> - query() - pour les requête préparer
> - lastInsertId() – returne la dernier entre dans la base  

### Session.php
Elle est construite uniquement pour la gestion des sessions 
Avec des fonction comme : 
> - getInstance() – récupéré l’instante en cours 
> - setFlash() – pour ajouter les message flache a une session 
> - hasFlashes() – pour vérifier si on a des message en session 
> - getFlashes() – renvoie le message contenue dans le flash
> - write() – permet d’écrire un message avec une clé
> - read () – permet de lire un message à partir de la clé 
> - delete() – permet d’effacer un message flache 

### Str.php
Elle est construite uniquement pour la gestion des token

### Validator 
Avec un constructeur qui initialise une base de données 
il contient des fonctions comme :
> - getField() – vérifie l’existence dans la base de l’argument qui lui est passe.
> - isAlpha() – renvoie un message d’erreur relative a l’absence de l’objet cherche.
> - isUnique () – vérifie un enregistrement unique dans la base.
> - isEmail () – vérifie le mail.
> - isConfirmed – vérifie le mots de passe.
> - isValid() – vérifie s’il n’y pas d’erreur.
> - getErrors() – pour récupéré les erreur.


## les fichers 

* Register.php - pour s’inscrire 
* logout.php - ce déconnecter 
* forget.php - Mots de passe oublier 
* login.php - Connexion 
* reset.php - Réinitialisation des mots de passe 
* account.php - Espace personnelle 

## la_base_et_des_Donnees
Représente la base de données avec quelques enregistrements 

# Pour exécuter l’appli 
Il faut installer un serveur avec une base de données sql 
Puis lancer le ficher register.php
