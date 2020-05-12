<?php

namespace Tournament;
require_once 'SimpleRepository.php';
use \Repository\SimpleRepository;

class TournamentRepository extends SimpleRepository
{
    private static $instance = null;
    
    public function __construct()
    {
        parent::__construct();
		if (TournamentRepository::$instance != null) return $instance;
		else $instance = $this;
	}

    public function fetchAll()
    {
        $tournamentsData = $this->dbAdapter->query('SELECT * FROM "Tournament"');
        $tournaments = [];
        foreach ($tournamentsData as $tournamentsDatum) {
            $tournament = new Tournament();
            $tournament
                ->setId($tournamentsDatum['id'])
                ->setName($tournamentsDatum['name'])
                ->setOrganisateur($tournamentsDatum['organisateur']);
            $tournaments[] = $tournament;
        }
        return $tournaments;
    }

    public function delete ($tournamentId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "Tournament" where id = :tournamentId');

        $stmt->bindParam('tournamentId', $tournamentId);
        $stmt->execute();
    }
    
    public function getByKey($tournamentId){}
}
