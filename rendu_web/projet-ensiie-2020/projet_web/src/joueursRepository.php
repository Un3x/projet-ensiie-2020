<?php

namespace Joueur;

class JoueursRepository
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
        $joueurData = $this->dbAdapter->query('SELECT * FROM "participation_smash" ');
        $joueurs = [];
        foreach ($joueurData as $joueurDatum) {
            $joueur = new Joueur();
            $joueur
                ->setPseudo($eventDatum['pseudo'])
                ->setClassement($eventDatum['classement']);
            $joueurs[] = $joueur;
        }
        return $joueurs;
    }
}