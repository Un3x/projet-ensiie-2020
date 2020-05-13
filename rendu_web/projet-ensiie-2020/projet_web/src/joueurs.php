<?php

namespace Joueur;

class Joueur
{
    /**
     * @var string
     */
    private $pseudo;

    /**
     * @var string
     */
    private $elo_smash;

    /**
     * @return int
     */
    public function getPseudo ()
    {
        return $this->pseudo;
    }

    /**
     * @param int $id
     */
    public function setPseudo ($pseudo)
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    /**
     * @return int
     */
    public function getElo_smash ()
    {
        return $this->elo_smash;
    }

    /**
     * @param int $elo
     */
    public function setElo_smash ($elo_smash)
    {
        $this->elo_smash = $elo_smash;
        return $this;
    }

     /**
     * @return int
     */
    public function getClassement ()
    {
        return $this->classement;
    }

    /**
     * @param int $elo
     */
    public function setClassement ($classement)
    {
        $this->classement = $classement;
        return $this;
    }
}