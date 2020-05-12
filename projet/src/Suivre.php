<?php

namespace Suivre;

class Suivre
{
    /**
     * @var string
     */
    private $suiveur;

    /**
     * @var string
     */
    private $suivi;

    /**
     * @return string
     */
    public function getSuiveur ()
    {
        return $this->suiveur;
    }

    /**
     * @param string $suiveur
     */
    public function setId ($suiveur)
    {
        $this->suiveur = $suiveur;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomListe ()
    {
        return $this->suivi;
    }

    /**
     * @param string $suivi
     */
    public function setSuivi ($suivi)
    {
        $this->suivi = $suivi;
        return $this;
    }

}