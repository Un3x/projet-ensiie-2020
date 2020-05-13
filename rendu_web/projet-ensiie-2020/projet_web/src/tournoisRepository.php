<?php

namespace tournois;

class tournoisRepository
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
        $tournoisData = $this->dbAdapter->query('SELECT * FROM "smash"');
        $tournois = [];
        foreach ($tournoisData as $tournoisDatum) {
            $tournoi = new Tournoi();
            $tournoi
                ->setNombreParticipant($tournoisDatum['nombreParticipant'])
                ->setEdition_smash($tournoisDatum['edition_smash']);
            $tournois[] = $tournoi;
        }
        return $tournois;
    }
}