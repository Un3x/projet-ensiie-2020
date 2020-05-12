<?php

namespace Map;

class MapRepository
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
        $mapData = $this->dbAdapter->query('SELECT * FROM "map"');
        $maps = [];
        foreach ($mapData as $mapDatum) {
            $map = new Map();
            $map
                ->setId($mapDatum['id_map'])
                ->setMeteo($mapDatum['meteo'])
                ->setTerrain($mapDatum['terrain']);
            $maps[] = $map;
        }
        return $maps;
    }

    public function delete ($mapId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "map" where id_map = :mapId');

        $stmt->bindParam('mapId', $mapId);
        $stmt->execute();
    }

    public function create($mapMeteo, $mapTerrain, $mapMdj)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "map" (meteo, terrain)  VALUES (:mapMeteo, :mapTerrain)');
        $stmt->bindParam('mapMeteo', $mapMeteo);
        $stmt->bindParam('mapTerrain', $mapTerrain);
        $stmt->execute();
    }

    public function selectmaps($firstnumber, $secondnumber)
    {
        $maptot = $this->dbAdapter->query('SELECT * FROM "map" ORDER BY id_map');
        $maps= [];
        foreach($maptot as $map){
            if ($map['id_map'] == $firstnumber){
                $maptoadd = new Map();
                $maptoadd
                    ->setId($map['id_map'])
                    ->setMeteo($map['meteo'])
                    ->setTerrain($map['terrain'])
                    ->setVote($map['vote']);
                $maps[] = $maptoadd;
            }
            if ($map['id_map'] == $secondnumber){
                $maptoadd = new Map();
                $maptoadd
                    ->setId($map['id_map'])
                    ->setMeteo($map['meteo'])
                    ->setTerrain($map['terrain'])
                    ->setVote($map['vote']);
                $maps[] = $maptoadd;
            }
        }
        $_SESSION['idmap1'] = $firstnumber;
        $_SESSION['idmap2'] = $secondnumber;
        return $maps;

    }

    public function getmapbyid(){
        session_start();
        $maps= [];
        $maptot = $this->dbAdapter->query('SELECT * FROM "map" ORDER BY id_map');
        foreach($maptot as $map){
            if($map['id_map'] == $_SESSION['idmap1'] || $map['id_map'] == $_SESSION['idmap2']){
                $maptoadd = new Map();
                $maptoadd
                    ->setId($map['id_map'])
                    ->setMeteo($map['meteo'])
                    ->setTerrain($map['terrain'])
                    ->setVote($map['vote']);
                $maps[] = $maptoadd;
            }
        }
        return $maps;
    }

    public function getChoosedMap(){
        $sql = $this->dbAdapter->query('SELECT * FROM "map"');
        $id_map = 0;
        $max_vote = 0;
        foreach($sql as $map){
            if(isset($map['vote'])){
                if($map['vote'] > $max_vote){
                    $id_map = $map['id_map'];
                    $max_vote = $map['vote'];
                }
            }
        }
        return $id_map;
    }

    public function getVoteMap($id_map){
        $sql = $this->dbAdapter->query('SELECT * FROM "map"');
        foreach($sql as $map){
            if($map['id_map'] == $id_map){
                return $map['vote'];
            }
        }
        return -1;
    }
}