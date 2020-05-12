# Ton nez dans mon vin

## Présentation

Voici le brand new site d'OenologIIE, qui permet aux utilisateurs de déposer des vins et de pouvoir en parler.

[Voir le rapport](./Rapport.pdf)

# Installation du projet

## Bibliothèques requises

Le site fonctionne avec les versions de PHP 7.1, 7.2, 7.3 et 7.4

Le site nécessite plusieurs bibliothèques natives de PHP, il faut activer les modules suivants dans le php.ini (en supposant que les paquets sont installés sur la machine) :
* PHP-Curl (`extension=curl`)
* PHP-GD (`extension=gd` ou `extension=gd2`)
* PHP-MbString (`extension=mbstring`)
* PHP-Pgsql (`extension=pgsql`)
* PHP-PDO-Pgsql (`extension=pdo_pgsql`)
* PHP-Exif (`extension=exif`)

Il faut qu'elles soient actives pour un bon fonctionnement du site !

## Installation du site

Pour installer le site, il y a trois étapes : 
* Il faut copier le fichier `.env.example` en `.env` et y configurer ses accès au PostgreSQL ([PHPDotEnv](https://github.com/vlucas/phpdotenv))
* Il faut installer [Composer](https://getcomposer.org/doc/00-intro.md) et exécuter la commande : `composer install`
  Cela va avoir pour effet de télécharger les librairies requises pour le bon fonctionnement du site et également avertir si une bibliothèque native de PHP requise est manquante.
* Il faut remplir la base de données via la commande `make db.init` ou `make db.reset` le cas échéant.

## Lancement du site

**Il faut s'assurer que le serveur PostgreSQL est démarré avant toute manipulation du site !**

Pour démarrer le serveur, il suffit juste d'effectuer la commande `make` qui va démarrer le serveur en localhost.

Pour accéder au site Web, il suffit juste d'aller sur [http://localhost:8080](http://localhost:8080)

## Informations

La documentation Doxygen est disponible dans le fichier [./doc/index.html](./doc/index.html)

La base de données contient par défaut 4 comptes avec comme nom d'utilisateur et mot de passe :
* `bleh` => `123456789`     de rôle Utilisateur
* `noctali` => `123456789`  de rôle Utilisateur
* `inako` => `123456789`    de rôle Utilisateur
* `nitorac` => `123456789`  de rôle Administrateur