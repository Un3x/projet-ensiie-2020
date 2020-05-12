<?php

namespace src\Model\repository;
use Entity\Game as Game;

class GameRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll()
    {
        $gamesData = $this->dbAdapter->query('SELECT * FROM "game"');
        $games = [];
        foreach ($gamesData as $gamesDatum) {
            $game = new Game();
            $game
                ->setId($gamesDatum['gameid']) /* id ou gameId ? */
                ->setName($gamesDatum['gamename'])
                ->setIsFree($gamesDatum['isfree'])
                ->setDescription($gamesDatum['gamedescription'])
                ->setIsAccepted($gamesDatum['isaccepted']);
            $games[] = $game;
        }
        return $games;
    }

function insert(string $name, int $isFree, string $description){
        $sql = "insert into game(gameName,isFree,GameDescription) values (?,?,?)";
        $stmt = $this->dbAdapter->prepare($sql);
        $stmt->bindParam(1,$name);
        $stmt->bindParam(2,$isFree);
        $stmt->bindParam(3, $description);
        $stmt->execute();
    }

    public function delete ($gameId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "game" where gameId = :gameId');
        
        $stmt->bindParam('gameId', $gameId);
        $stmt->execute();
    }

    public function validate ($gameId){
        $stmt=$this->dbAdapter->prepare('UPDATE game SET isAccepted=1 WHERE gameId=:gameId');
        $stmt -> bindParam('gameId',$gameId);
        $stmt->execute();
    }

    public function decline ($gameId){
        $stmt=$this->dbAdapter->prepare('UPDATE game SET isAccepted=-1 WHERE gameId=:gameId');
        $stmt -> bindParam('gameId',$gameId);
        $stmt->execute();
    }

    public function addAcquired ($gameId,$gamename,$pseudo){
        $stmt=$this->dbAdapter->prepare('INSERT INTO acquired (pseudo,gameName,gameId) VALUES (?,?,?)');
        $stmt -> bindParam(1,$pseudo);
        $stmt -> bindParam(2,$gamename);
        $stmt -> bindParam(3,$gameId);
        $stmt->execute();
    }

    public function showAcquired($pseudo)
    {
        $gamesData=$this->dbAdapter->prepare('SELECT gamename,gameid FROM acquired WHERE pseudo=:pseudo');
       
        $gamesData->bindParam(':pseudo',$pseudo);
        $gamesData->execute();
        $games = [];
        foreach ($gamesData as $gamesDatum) {
            $game = new Game();
            $game
                ->setName($gamesDatum['gamename'])
                ->setId($gamesDatum['gameid']);
            $games[] = $game;
        }
        return $games;
    
        
    }

    public function isInAcquired($gameId,$pseudo){
        $gamesData=$this->dbAdapter->prepare('SELECT pseudo,gameid FROM acquired WHERE pseudo=:pseudo AND gameid = :game_id');
        $gamesData->bindParam(':pseudo',$pseudo);
        $gamesData->bindParam(':game_id',$gameId);
        $gamesData->execute();
        return ($gamesData->rowCount() == 0);
    }
}