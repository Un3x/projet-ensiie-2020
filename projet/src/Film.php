<?php

namespace Oeuvre;

class Film extends Oeuvre
{
    /**
     * @var string
     */
    private $realisateur;

    /**
     * @var string
     */
    private $genre;

    /**
     * @var int
     */
    private $duree;

    /**
     * @var string
     */
    private $producteur;

    /**
     * @return string
     */
    public function getRealisateur ()
    {
        return $this->realisateur;
    }

    /**
     * @param string $realisateur
     */
    public function setRealisateur ($realisateur)
    {
        $this->realisateur = $realisateur;
        return $this;
    }

    /**
     * @return string
     */
    public function getGenreFilm ()
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenreFilm ($genre)
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     * @return string
     */
    public function getDureeFilm ()
    {
        return $this->duree;
    }

    /**
     * @param int $duree
     */
    public function setDureeFilm ($duree)
    {
        $this->duree = $duree;
        return $this;
    }

    /**
     * @return string
     */
    public function getProducteur ()
    {
        return $this->producteur;
    }

    /**
     * @param string $producteur
     */
    public function setProducteur ($producteur)
    {
        $this->producteur = $producteur;
        return $this;
    }
}