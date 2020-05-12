<?php

namespace Oeuvre;

class Livre extends Oeuvre
{
    /**
     * @var int
     */
    private $nb_pages;

    /**
     * @var string
     */
    private $langue;

    /**
     * @var string
     */
    private $genre;

    /**
     * @return int
     */
    public function getNbPages ()
    {
        return $this->nb_pages;
    }

    /**
     * @param int $nb_pages
     */
    public function setNbPages ($nb_pages)
    {
        $this->nb_pages = $nb_pages;
        return $this;
    }

    /**
     * @return string
     */
    public function getLangue ()
    {
        return $this->langue;
    }

    /**
     * @param string $langue
     */
    public function setLangue ($langue)
    {
        $this->langue = $langue;
        return $this;
    }

    /**
     * @return string
     */
    public function getGenreLivre ()
    {
        return $this->genre;
    }

    /**
     * @param string $genre
     */
    public function setGenreLivre ($genre)
    {
        $this->genre = $genre;
        return $this;
    }
}