# T’Oraux

Le but est de faire un site de partage de sujets d’oraux pour la CPGE.

## Les fonctionnalités

Pour ajouter des documents, il faut un compte.

Si on n’a pas de compte, on n’a pas accès à la correction ou au chat.

Fonctionnalités:
- Possibilité de créer un compte avec un mot de passe où seront renseignés le nom, le lycée, la classe, le courriel...
- Le dépôt: possibilité de déposer des fichiers en format PDF, ODF, TEX pour les utilisateurs enregistrés.
- Consultation par catégorie/classe/année/type de concours, et éventuellement le corrigé pour chaque page.

À voir:
- Possibilité d’aimer un sujet s’il est bien relaté?
- Notification mail d’un utilisateur si quelqu’un aime son sujet, ou si il y a une nouvelle publication d’un sujet
- Redirection vers des rappels de cours liés au sujet?
- Chat, zone de commentaire?
- Proposer un sujet aléatoire
- Un onglet où l’utilisateur pourra faire son retour d’expérience
- Onglet pour nous contacter.

Si vraiment on est en avance:
- Un générateur de citations maths/physique.


# Installation du projet

## Makefile

Le makefile dispose de 4 commandes :
* make start qui permet de lancer le serveur sur localhost:8080
* make db.init qui initialise la db a partir du fichier `./data/toraux.sql`
* make db.drop qui détruit la db
* make db.reset qui détruit puis initialise la db

## Accès db

Pour que le code applicatif accède a la db il faut changer lkes paramètres dans le fichier `./src/config/config.php`.

Pour que le makefile se connecte a la db il faut changer les paramètre directement dans le fichier `Makefile`.

La mise en place de la db fait partie du projet  et vous devez vous en occuper.

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


## Documentation

Le compte-rendu sera typographié en TeX. Il faut installer texlive sur votre ordinateur. Vous pourrez ensuite génerer le fichier pdf avec la commande:
```
lualatex cr.tex
```
Seul le fichier pdf et le fichier tex seront présents sur le dépôt. Merci de ne pas faire y ajouter les fichiers.log et/ou .aux qui seront générés par la commande ci-dessus.
