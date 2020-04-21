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
                ->setId($mapDatum['id_carte'])
                ->setMeteo($mapDatum['meteo'])
                ->setTerrain($mapDatum['terrain'])
                ->setMdj($mapDatum['mdj']);
            $maps[] = $map;
        }
        return $maps;
    }

    public function delete ($mapId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "map" where id_carte = :mapId');

        $stmt->bindParam('mapId', $mapId);
        $stmt->execute();
    }

    public function create($mapMeteo, $mapTerrain, $mapMdj)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "map" (meteo, terrain, mdj)  VALUES (:mapMeteo, :mapTerrain, :mapMdj)');
        $stmt->bindParam('mapMeteo', $mapMeteo);
        $stmt->bindParam('mapTerrain', $mapTerrain);
        $stmt->bindParam('mapMdj', $mapMdj);
        $stmt->execute();
    }
}