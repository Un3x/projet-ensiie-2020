# Installation du projet en local
Pour plus de facilité, vous pouvez consulter la version en ligne du projet directement à l'adresse : http://dlu02.freeboxos.fr

## Makefile

Le makefile dispose de 4 commandes :
* make start qui permet de lancer le serveur sur localhost:8080
* make db.init qui initialise la db a partir du fichier `./data/init.sql`
* make db.drop qui détruit la db
* make db.reset qui détruit puis initialise la db

## Prérequis

- Le package PHP php-pgsql doit être installé.

- L'extension PDO-pgsql doit être active, ie. la ligne ';extension=pdo-pgsql' doit être décommentée (retirer le point-virgule) dans le fichier php.ini.

## Lancement du site
Après avoir effectué les prérequis, exécuter les commandes suivantes :
```
$ make db.init
$ make start
```
Le site est alors accessible à l'adresse localhost:8080. 
