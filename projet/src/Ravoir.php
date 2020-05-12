<?php

namespace Ravoir;

class Ravoir
{
    /**
     * @var string
     */
    private $pseudo;

    /**
     * @var int
     */
    private $id_liste;

    /**
     * @return string
     */
    public function getPseudo ()
    {
        return $this->id;
    }

    /**
     * @param string $string
     */
    public function setPseudo ($pseudo)
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdListe ()
    {
        return $this->id_liste;
    }

    /**
     * @param int $id_liste
     */
    public function setIdListe ($id_liste)
    {
        $this->id_liste = $id_liste;
        return $this;
    }
}