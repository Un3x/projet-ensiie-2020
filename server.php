<?php
/*
 * Ce fichier est le démarreur du serveur PHP, il permet de déterminer si la ressource doit être redirigée ou non
 *
 * Ici, si le fichier existe à destination (fichiers js ou css), on laisse le serveur accéder aux fichiers
 *   Sinon, on charge le index.php
 */

/*
 * On définit le dossier root et public
 */
define('__ROOT__', __DIR__);
define('__PUBLIC__', __DIR__ . '/public');

if(isset($_SERVER['REQUEST_URI'])){
    $uri = urldecode(
        parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
    );

    // On simule la redirection Apache ici                           On met cette dernière condition par sécurité, évite qu'un fichier php soit accessible de l'extérieur sans passer par le routeur
    if ($uri !== '/' && file_exists(__PUBLIC__ . $uri) && substr_compare($uri, ".php", -4) !== 0) {
        return false;
    }
}

if(substr_compare($uri, ".php", -4) !== 0)

require_once __PUBLIC__ . '/index.php';