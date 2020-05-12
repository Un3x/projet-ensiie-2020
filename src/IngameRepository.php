<?php

namespace Ingame;

class IngameRepository
{
     /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchpplgame($game)
    {
        $pplingame = $this->dbAdapter->query(' SELECT * FROM "in_game" ORDER BY team ');
        $ppltoreturn = [];
        foreach ($pplingame as $pplgame){
            if ($pplgame['id_game'] == $game){
                $ppl = new Ingame();
                $ppl
                    ->setId($pplgame['id_game'])
                    ->setTeam($pplgame['team'])
                    ->setPseudo($pplgame['pseudo'])
                    ->setMdj($pplgame['mdj']);
                $ppltoreturn[]=$ppl;
            }
        }
        return $ppltoreturn;
    }

    public function votemap($id)
    {
        $maps = $this->dbAdapter->query('SELECT * FROM "map" ORDER BY id_map');
        foreach($maps as $map){
            if($map['id_map'] == $id){
                $vote = $map['vote'];
                $newvote = $vote+1;
                $stmt = $this
                ->dbAdapter
                ->prepare('UPDATE "map" SET vote=:newvote where id_map=:id');
                $stmt->bindParam('newvote', $newvote);
                $stmt->bindParam('id', $id);
                $stmt->execute();
            }
        }
    }

    public function voteautre($id){
        $games = $this->dbAdapter->query('SELECT * FROM "in_game" ');
        foreach($games as $game){
            if($game['id_game'] == $id){
                $vote = $game['voteautre'];
                $newvote = $vote + 1;
                $stmt = $this
                ->dbAdapter
                ->prepare('UPDATE "in_game" SET voteautre=:newvote where id_game=:id');
                $stmt->bindParam('newvote', $newvote);
                $stmt->bindParam('id', $id);
                $stmt->execute();
            }
        }
    }

    public function getVote($id){
        $games = $this->dbAdapter->query('SELECT * FROM "in_game" ');
        $vote = -1;
        foreach($games as $game){
            if($game['id_game'] == $id){
                $vote = $game['voteautre'];
            break;
            }
        }
        return $vote;
    }

    public function countmap()
    {
        $count = 0;
        $stmt = $this->dbAdapter->query(' SELECT * FROM "map" ');
        foreach ($stmt as $totmap){
            $count++;
        }
        return $count;
    }

    public function countTeam($mdj, $team)
    {
        $sql = $this->dbAdapter->query('SELECT * FROM in_game');
        $players = [];
        foreach($sql as $s){
            $player = new InGame();
            $player->setPseudo($s['pseudo']);
            if(isset($s['team'])) $player->setTeam($s['team']);
            if(isset($s['id_game'])) $player->setId($s['id_game']);
            $player->setMdj($s['mdj']);
            $players[] = $player;
        }
        $count = 0;
        foreach($players as $player){
            if($player->getTeam() == $team && $player->getMdj() == $mdj && $player->getId() == null){
                $count++;
            }
        }
        return $count;
    }

    public function matchmaking($game_type)
    {
        $mdj = strval($game_type) . "v" . strval($game_type);
        session_start();
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "in_game" (pseudo, mdj) VALUES (:pseudo, :mdj)');
        $stmt->bindParam('pseudo', $_SESSION['username']);
        $stmt->bindParam('mdj', $mdj);
        $stmt->execute();
        $players = $this->dbAdapter->query('SELECT * FROM "in_game"');
        $players_tab = [];
        foreach($players as $player){
            $joueur = new Ingame();
            $joueur->setPseudo($player['pseudo']);
            $players_tab[] = $joueur;
        }
        $players_copy = $players_tab;
        $games = $this->dbAdapter-> query('SELECT id_partie FROM partie');
        $last_id = 0;
        foreach($games as $game){
            $last_id = $game['id_partie'];
        }
        $last_id += 1;
        $found_match = False;
        foreach($players_tab as $player){
            if(empty($player->getId())){
                //FILL TEAM
                $pseudo = $player->getPseudo();
                if($this->countTeam($mdj, 1) < (int)$game_type){
                    $team_number = 1;
                } else {
                    $team_number = 2;
                }
                $update = $this
                    ->dbAdapter
                    ->prepare('UPDATE "in_game" SET team=:team where pseudo=:pseudo');
                $update->bindParam('team', $team_number);
                $update->bindParam('pseudo', $pseudo);
                $update->execute();
            }
            if($this->countTeam($mdj, 1) == (int)$game_type && $this->countTeam($mdj, 2) == (int)$game_type){
                $find_team = $this
                    ->dbAdapter
                    ->prepare('UPDATE "in_game" SET id_game=:id_game where mdj=:mdj');
                $find_team->bindParam('id_game', $last_id);
                $find_team->bindParam('mdj', $mdj);
                $find_team->execute();

                //MAPS

                $totalmap = $this->countmap();

                $firstnumber =  random_int(1,$totalmap);
                $secondnumber =  random_int(1,$totalmap);
                while($firstnumber == $secondnumber){
                    $secondnumber =  random_int(1,$totalmap);
                }
                $stmt = $this
                    ->dbAdapter
                    ->prepare('UPDATE "in_game" SET map1=:id_map1, map2=:id_map2 where id_game=:id_game');
                $stmt->bindParam('id_map1', $firstnumber);
                $stmt->bindParam('id_map2', $secondnumber);
                $stmt->bindParam('id_game', $last_id);
                $stmt->execute();
            }
        }
    }

    public function getGame(){
        $stmt = $this->dbAdapter->query('SELECT * FROM in_game');
        foreach($stmt as $game){
            if($game['pseudo'] == $_SESSION['username']){
                $joueur = new Ingame();
                $joueur->setPseudo($game['pseudo'])
                        ->setId($game['id_game'])
                        ->setMdj($game['mdj'])
                        ->setMap1($game['map1'])
                        ->setMap2($game['map2'])
                        ->setTeam($game['team']);
            }
        }
        return $joueur;
    }

    public function reset_game(){
        session_start();
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "in_game" where pseudo=:pseudo');
        $stmt->bindParam('pseudo', $_SESSION['username']);
        $stmt->execute();
        $stmt2 = $this
            ->dbAdapter
            ->prepare('UPDATE "map" SET vote=0');
        $stmt2->execute();
    }
}