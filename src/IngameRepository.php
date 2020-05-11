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

    public function fetchAll()
    {
        $pplonlineData = $this->dbAdapter->query('SELECT * FROM "Ingame"');
        $pplonlines = [];
        foreach ($pplonlineData as $pplOnlineDatum) {
            $pplonline = new PplOnline();
            $pplonline
                ->setIp($pplOnlineDatum['ip'])
                ->setTime($pplOnlineDatum['ti']);
            $pplonlines[] = $pplonline;
        }
        return $pplonlines;
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
        foreach($games as $game){
            if($game['id_game'] == $id){
                $vote = $game['voteautre'];
            break;
            }
        }
        return $vote;
    }   

}