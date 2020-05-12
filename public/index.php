<?php
require __DIR__ . '/../autoloader.php';

// On définit la langue par défaut
setlocale(LC_TIME, 'fr_FR');
Carbon\Carbon::setLocale('fr');

// On définit la taille maximale d'upload (8 Mo)
define('MAX_FILE_UPLOAD', 8000000);

use App\Core\App;
use App\Core\Blade;
use App\Core\Pgsql;
use App\Core\Request;

$app = new App(new Request());

/*
 * Ici on définit les classes qui doivent être définies une seule fois !
 *
 * Ca s'utilise comme ça : App::resolve(Objet::class);
 */

// Par exemple, une connexion à la base de donnée peut être appellée par : App::resolve(Pgsql::class)->...
$app->singleton(Pgsql::class, function(){
    return new Pgsql(
        getenv('DB_HOST'),
        getenv('DB_NAME'),
        getenv('DB_USER'),
        getenv('DB_PASS')
    );
});

Blade::compose('components.comments', '\App\Composers\CommentsComposer');
Blade::compose('components.fav-wines-section', '\App\Composers\FavoriteWinesComposer');

// On définit les routes dans ce fichier
include_once 'web.php';

// On définit les middlewares dans ce fichier
include_once 'middlewares.php';

// On résout le routeur (après avoir déclaré toutes les routes, on choisit lequel est adapté)
return $app->handle();