<?php

namespace Controller;
require_once 'Controller.php';

class GameHistoryController extends Controller
{
	public function get($params)
	{
		$viewPath = __VIEWROOT__.'/html';
		
		// Connection to the GameRepository
		$gameRepository = $this->getMainRepository()->getGameRepository();
		$games = $gameRepository->fetchAllByUser($_SESSION['username']);
		
		$title = 'Historique';
		include $viewPath.'/history.php';
	}

	public function post($params){}
}

?>
