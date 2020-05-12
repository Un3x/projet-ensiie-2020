<?php
// URI without GET parameters
$request = strtok($_SERVER["REQUEST_URI"], '?');
// Starting session
session_start();
require_once 'view/template.php';

if (isset($_SESSION["id"])) {
    // Quand la session est ouverte
    switch ($request) {
        case '':
        case '/':
        case '/home':
            require_once 'controller/home.php';
            break;
        case '/timeline':
            require_once 'controller/timeline.php';
            break;
        case '/games':
            require_once 'controller/games.php';
            break;
        case '/game':
            require_once 'controller/game.php';
            break;
        case '/user':
            require_once 'controller/user.php';
            break;
        case '/logout':
            require_once 'controller/logout.php';
            break;
        case '/send-message':
            require_once 'controller/send-message.php';
            break;
        case '/delete-message':
            require_once 'controller/delete-message.php';
            break;
        case '/admin':
            require_once 'adminer.php';
            break;
        case '/doc-api':
            loadView("api", null);
            break;
        case '/api/search':
            require_once 'api/search.php';
            break;
        case '/api/append-message':
            require_once 'api/append-message.php';
            break;
        default:
            http_response_code(404);
            require_once 'view/head.php';
            require_once 'view/404.php';
            break;
    }
    return;
} else {
    switch ($request) {
        case '':
        case '/':
        case '/login':
            require_once 'view/head.php';
            require_once 'view/login.php';
            break;
        case '/register':
            require_once 'view/head.php';
            require_once 'view/register.php';
            break;
        case '/log':
            require_once 'controller/login.php';
            break;
        case '/registration':
            require_once 'controller/register.php';
            break;
        default:
            http_response_code(404);
            require_once 'view/head.php';
            require_once 'view/404.php';
            break;
    }
    return;
}
