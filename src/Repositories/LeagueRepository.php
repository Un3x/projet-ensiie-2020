<?php

namespace League;
require_once 'SimpleRepository.php';
use \Repository\SimpleRepository;

class LeagueRepository extends SimpleRepository
{
    private static $instance = null;
    
    public function __construct()
    {
        parent::__construct();
		if (LeagueRepository::$instance != null) return $instance;
		else $instance = $this;
	}

    public function fetchAll()
    {
        $leaguesData = $this->dbAdapter->query('SELECT * FROM "League"');
        $leagues = [];
        foreach ($leaguesData as $leaguesDatum) {
            $league = new League();
            $league
                ->setName($leaguesDatum['name']);
            $leagues[] = $league;
        }
        return $leagues;
    }

    public function delete ($leagueName)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "League" where name = :leagueName');

        $stmt->bindParam('leagueName', $leagueName);
        $stmt->execute();
    }
    
    public function getByKey($leagueName){}
}
