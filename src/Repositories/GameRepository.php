<?php

namespace Game;
require_once 'SimpleRepository.php';
use \Repository\SimpleRepository;

class GameRepository extends SimpleRepository
{
    private static $instance = null;
    
    public function __construct()
    {
        parent::__construct();
		if (GameRepository::$instance != null) return $instance;
		else $instance = $this;
	}

    public function fetchAll()
    {
		$stmt = $this->dbAdapter->prepare("SELECT * FROM Game ORDER BY player");
        $stmt->execute();
        
        $gamesData = $stmt->fetchAll();
        $games = [];
        foreach ($gamesData as $row)
        {
            $game = new Game();
            $game->setId($row['id'])
				->setPlayer($row['player'])
				->setWinner($row['winner'])
                ->setPlayedAt(new \DateTime($row['played_at']));
            $games[] = $game;
        }
        return $games;
    }

    public function delete ($gameId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "Game" where id = :gameId');

        $stmt->bindParam('gameId', $gameId);
        $stmt->execute();
    }
    
    public function getByKey($gameId){}
    
    public function insertGame($player, $winner)
    {
		$stmt = $this->dbAdapter->prepare("INSERT INTO Game (id, winner, played_at, player) VALUES (DEFAULT, :winner, NOW(), :player)");
		
		$stmt->bindParam('winner', $winner, \PDO::PARAM_STR);
        $stmt->bindParam('player', $player, \PDO::PARAM_STR);
        $stmt->execute();
	}
    
    public function fetchAllByUser($user)
    {
		$stmt = $this->dbAdapter->prepare("SELECT winner, played_at FROM Game WHERE player = :user ORDER BY played_at DESC");
		
        $stmt->bindParam('user', $user, \PDO::PARAM_STR);
        $stmt->execute();
        
        $gamesData = $stmt->fetchAll();
        $games = [];
        foreach ($gamesData as $row)
        {
            $game = new Game();
            $game->setWinner($row['winner'])
                ->setPlayedAt(new \DateTime($row['played_at']));
            $games[] = $game;
        }
        return $games;
	}
}
