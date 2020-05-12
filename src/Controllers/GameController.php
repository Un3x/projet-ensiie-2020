<?php

namespace Controller;
require_once 'Controller.php';

class GameController extends Controller
{
	public function get($params)
	{
		$viewPath = __VIEWROOT__.'/html';
		
		if (!$this->socket->preparePlayAlone()->sendData())
			$this->socket->printError();
		
		$title = 'Morpiien';
		include_once $viewPath.'/morpiien.php';
	}

	public function post($params)
	{
		$iaMove = $this->socket->prepareAloneMove($params['cell'])->sendData();
		if (!isset($params['cell']) && !$iaMove)
		{
			$this->socket->printError();
			echo "{\"failure\": true}";
		}
		else
		{
			if (!$iaMove['valid_move'])
				echo "\"valid_move\": false";
			else if ($iaMove['finished'] === false)
				echo "{\"finished\": false, \"opponent\": \"${iaMove['ia_move']}\"}";
			else
			{
				// Connection to the GameRepository
				$gameRepository = $this->getMainRepository()->getGameRepository();
				if ($iaMove['finished'] == "L'IA")
					$gameRepository->insertGame($_SESSION['username'], "non");
				else if ($iaMove['finished'] == "No one")
					$gameRepository->insertGame($_SESSION['username'], "nul");
				else
					$gameRepository->insertGame($_SESSION['username'], "oui");
				
				echo "{\"finished\": \"${iaMove['finished']}\", \"opponent\": \"${iaMove['ia_move']}\"}";
			}
		}
	}
}

?>
