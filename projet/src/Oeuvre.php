<?php

namespace Oeuvre;

class Oeuvre
{
    /**
     * @var int
     */
    private $numero;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var string
     */
    private $lien_photo;

    /**
     * @var \DateTime
     */
    private $date_sortie;

    /**
     * @return int
     */
    public function getNumero ()
    {
        return $this->numero;
    }

    /**
     * @param int $id
     */
    public function setNumero ($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitre ()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre ($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return string
     */
    public function getLienPhoto ()
    {
        return $this->lien_photo;
    }

    /**
     * @param string $lien_photo
     */
    public function setLienPhoto ($lien_photo)
    {
        $this->lien_photo = $lien_photo;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateSortie ()
    {
        return $this->date_sortie;
    }

    /**
     * @param \DateTime $date_sortie
     */
    public function setDateSortie ($date_sortie)
    {
        $this->date_sortie = $date_sortie;
        return $this;
    }
}

