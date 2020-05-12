<?php

namespace Controller;
require_once 'Controller.php';

class ScoreBoardController extends Controller
{
	public function get($params)
	{
		$viewPath = __VIEWROOT__.'/html';
		
		// Connection to the GameRepository
		$gameRepository = $this->getMainRepository()->getGameRepository();
		$games = $gameRepository->fetchAll();
		
		// On parcourt la liste des parties et on calcule le nombre de victoires, défaites, etc
		$players = [];
		$player = "";
		$wins = 0;
		$loses = 0;
		$draws = 0;
		foreach ($games as $game)
		{
			$newPlayer = $game->getPlayer();
			if ($player !== $newPlayer)
			{
				if ($player !== "") $players[$player] = [
					$wins, $loses, $draws,
					ScoreBoardController::ratio($wins, $loses, $draws)
				];
				$player = $newPlayer;
				$wins = 0;
				$loses = 0;
				$draws = 0;
			}
			
			$won = $game->getWinner();
			if ($won === 'oui') $wins++;
			else if ($won === 'non') $loses++;
			else if ($won === 'nul') $draws++;
		}
		$players[$player] = [
			$wins, $loses, $draws,
			ScoreBoardController::ratio($wins, $loses, $draws)
		];
		
		// Tri par ordre décroissant de ratio
		array_multisort(array_column($players, 3), SORT_DESC, $players);
		
		$title = 'Tableau des scores';
		include $viewPath.'/scoreboard.php';
	}

	public function post($params){}
	
	private static function ratio($wins, $loses, $draws)
	{
		return round(($wins + $draws/2) / ($loses !== 0 ? $loses : 1), 2);
	}
}

?>
