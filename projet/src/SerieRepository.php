<?php

namespace Serie;

class SerieRepository
{
    /**
     * @var \PDO
     */
    private $dbAdaper;

    public function __construct(\PDO $dbAdaper)
    {
        $this->dbAdaper = $dbAdaper;
    }

    public function add ($id,$nb_ep,$nb_saisons,$duree,$genre,$anime){
        
        $stmt = $this
            ->dbAdaper
            ->prepare('INSERT INTO Serie(M3_cle,nb_ep,nb_saisons,duree,genre,anime) VALUES (:id,:nb_ep,:nb_saisons,:duree,:genre,:anime)');

        $stmt->bindParam('M3_cle', $id);
        $stmt->bindParam('nb_ep', $nb_ep);
        $stmt->bindParam('genre', $genre);
        $stmt->bindParam('duree', $duree);
        $stmt->bindParam('nb_saisons', $nb_saisons);
        $stmt->bindParam('anime', $anime);
        $stmt->execute();
    }
}