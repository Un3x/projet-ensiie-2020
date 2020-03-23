# Installation du projet

## Makefile

Le makefile dispose de 4 commandes :
* make start qui permet de lancer le serveur sur localhost:8080
* make db.init qui initialise la db a partir du fichier `./data/init.sql`
* make db.drop qui détruit la db
* make db.reset qui détruit puis initialise la db

## Accès db

Pour que le code applicatif accède a la db il faut changer lkes paramètres dans le fichier `./src/config/config.php`.

Pour que le makefile se connecte a la db il faut changer les paramètre directement dans le fichier `Makefile`.

La mise en place de la db fait partit du projet  et vous devez vous en occuper.

## Sujets

Vous pourrez trouver le sujet complets détaillé dans le dossier `document`. L'un des sujet est un sujet libre, profitez en pour faire qqchose qui vous intéresse

## Application

Une base de code est déjà présente a titre d'exemple. Nous vous suggérons de bien lire le code et de le comprendre avant d'attaquer le développement et de vous inspirer de ce qui a été fait.

## Scéance

* 1ère scéance :
  * constitution des groupes
  * choix du sujets
  * définition des fonctionnalités du site
  * Modèle de base de données
* 2ème scéance :
  * relecture du code
  * support aux groupes pour la réalisation
  * réponses aux questions techniques
* 3ème scéance :
  * soutenance

## ATTENTION NOTATION

Afin que la notation se fasse simplement il est nécessaire que votre projet fonctionne directement après avoir lancer les commandes du makefile, sans quoi des pénalitées seront appliquées a la notation.