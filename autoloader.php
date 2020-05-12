<?php

/*
 * Ce fichier permet de charger toutes les dépendances nécessaires au fonctionnement du site
 * (Il charge Composer, DotEnv, et autres...)
 */

require __ROOT__ . '/vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__ROOT__)->load(); // Charge le fichier .env
