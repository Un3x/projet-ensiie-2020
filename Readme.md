# Installation du projet

## Makefile

Le makefile dispose de 4 commandes :
* make start qui permet de lancer le serveur sur localhost:8080
* make db.init qui initialise la db a partir du fichier `./data/init.sql`
* make db.drop qui détruit la db
* make db.reset qui détruit puis initialise la db

## Accès db

Pour que le code applicatif accède a la db il faut changer les paramètres dans le fichier `./src/config/config.php`.

Pour que le makefile se connecte a la db il faut changer les paramètre directement dans le fichier `Makefile`.

La mise en place de la db fait partit du projet  et vous devez vous en occuper.

Il est nécessaire d'avoir un user nommé "ensiie" avec un mot de passe étant 'ensiie' pour se connecter à la base de données.