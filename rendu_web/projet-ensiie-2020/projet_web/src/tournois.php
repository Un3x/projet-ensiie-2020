<?php

namespace tournois;

class Tournoi
{
    /**
     * @var int
     */
    private $nombreParticipant;

    /**
     * @var int
     */
    private $edition_smash;

    /**
     * @return int
     */
    public function getNombreParticipant ()
    {
        return $this->nombreParticipant;
    }

    /**
     * @param int $nombreParticipant
     */
    public function setNombreParticipant ($nombreParticipant)
    {
        $this->nombreParticipant = $nombreParticipant;
        return $this;
    }

    /**
     * @return int $edition_smash
     */
    public function getEdition_smash ()
    {
        return $this->edition_smash;
    }

    /**
     * @param int $edition_smash
     */
    public function setEdition_smash ($edition_smash)
    {
        $this->edition_smash = $edition_smash;
        return $this;
    }
}