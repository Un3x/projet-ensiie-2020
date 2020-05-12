<?php

namespace Oeuvre;

class Serie extends Oeuvre
{
        /**
     * @var int
     */
    private $nb_ep;

    /**
     * @var int
     */
    private $nb_saisons;

    /**
     * @var string
     */
    private $genre;

    /**
     * @var int
     */
    private $duree;

    /**
     * @var int(0 ou 1)
     */
    private $anime;

    /**
     * @return int
     */
    public function getNbEp ()
    {
        return $this->nb_ep;
    }

    /**
     * @param int $nb_ep
     */
    public function setNbEp ($nb_ep)
    {
        $this->nb_ep = $nb_ep;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbSaisons ()
    {
        return $this->nb_saisons;
    }

    /**
     * @param int $nb_saisons
     */
    public function setNbSaisons ($nb_saisons)
    {
        $this->nb_saisons = $nb_saisons;
        return $this;
    }

    /**
     * @return string
     */
    public function getGenreSerie ()
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenreSerie ($genre)
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * @return int
     */
    public function getDureeSerie ()
    {
        return $this->duree;
    }

    /**
     * @param int $duree
     */
    public function setDureeSerie ($duree)
    {
        $this->duree = $duree;
        return $this;
    }

    /**
     * @return int
     */
    public function getAnime ()
    {
        return $this->anime;
    }

    /**
     * @param int $anime
     */
    public function setAnime ($anime)
    {
        $this->anime = $anime;
        return $this;
    }
}