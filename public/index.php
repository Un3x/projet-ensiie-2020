<?php

define('__VIEWROOT__', __DIR__);

include '../src/Factory/DbAdapterFactory.php';
include '../src/Controllers/Controllers.php';
include '../src/Server/SimpleSocket.php';

use \Controller\{GameController, NotFoundController,
	GameHistoryController, HomeController,
	ProfileController, ProfilesController,
	ScoreBoardController, TournamentController,LoginController,
	RegisterController,ModifyController,AdminController
};
use \Socket\SimpleSocket;

try {
	$env = trim(file_get_contents('../.env'));

	if( $env === 'dev' || $env === 'test' ){
		ini_set('display_errors', 'On');
		error_reporting(E_ALL);
	} elseif ( $env !== 'prod' ){
		throw new Exception();
	}
} catch (Exception $e) {
	exit;
}

$route = preg_split( '/\?/', trim($_SERVER['REQUEST_URI'], '/') )[0];
$method = $_SERVER['REQUEST_METHOD'];
$params = $_REQUEST;
$socket = new SimpleSocket($env);

// Initialize the session
//session_start();

$controller;
switch ($route)
{
	case '':
	case 'home':
	case 'accueil':
		$controller = new HomeController;
		break;
	case 'login':
		$controller = new LoginController;
		break;
	case 'register':
		$controller = new RegisterController;
		break;
	case 'profil':
	case 'profile':
		$controller = new ProfileController;
		break;
	case 'morpion':
	case 'morpiien':
	case 'jeu':
	case 'game':
		$controller = new GameController;
		break;
	case 'scores':
	case 'scoreboard':
		$controller = new ScoreBoardController;
		break;
	case 'tournoi':
	case 'tournament':
		$controller = new TournamentController;
		break;
	case 'historique':
	case 'history':
		$controller = new GameHistoryController;
		break;
	case 'profils':
	case 'profiles':
		//Les Users non-admin ne doivent avoir accès à cette page
		if ($_SESSION["admin"] == true){
			$controller = new ProfilesController;
		}
		else{
			$controller = new NotFoundController;
		}
		break;
	case 'modify':
		$controller = new ModifyController;
		break;
	case 'logout':
		$viewPath = __VIEWROOT__.'/html';
		include_once $viewPath.'/logout.php';
		break;
	case 'adminmodify':
		//Les Users non-admin ne doivent avoir accès à cette page
		if ($_SESSION["admin"] == true){
			$controller = new AdminController;
		}
		else{
			$controller = new NotFoundController;
		}
	break;
	default:
		$controller = new NotFoundController;
		break;
}

if (!$socket && $socket->hasErrorOccured())
	$socket->printError();
else
	$controller->setSocket($socket);

$controller->handle($params, $method);

?>
