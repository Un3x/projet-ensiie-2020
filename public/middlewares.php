<?php
/**
 * @see https://laravel.com/docs/6.x/middleware
 *
 * Un middleware est un moyen simple de faire de l'automatisation dans le traitement
 * des requêtes
 *
 * Un exemple est disponible dans App\Middlewares\CsrfProtection
 */


/**
 * On définit ici les middlewares globaux, c'est à dire ceux qui seront
 * exécutés à chaque requête. (Les middlewares globaux n'ont pas de nom)
 */
$app->setGlobalMiddlewares([
    App\Middlewares\CsrfProtection::class
]);

/**
 * On définit ici les middlewares disponibles à utiliser dans les définitions de Route
 *  (Route::get(..., ...)->middleware('nomDuMiddleware');
 *  ou
 *  (Route::get(..., ...)->middleware(['nomDuMiddleware1', 'nomDuMiddleware2']);
 */
$app->setRouteMiddlewares([
    'forUsers' => App\Middlewares\UserAccessMiddleware::class,
    'forAdmins' => App\Middlewares\AdminAccessMiddleware::class
]);