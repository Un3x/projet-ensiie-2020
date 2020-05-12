<?php

namespace Controller;
require_once 'Controller.php';

class TournamentController extends Controller
{
	public function get($params)
	{
		$viewPath = __VIEWROOT__.'/html';
		
		$title = 'Tournoi';
		include $viewPath.'/tournament.php';
	}

	public function post($params){}
}

?>
