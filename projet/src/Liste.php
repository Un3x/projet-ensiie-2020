<?php

namespace Liste;

class Liste
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nom_liste;

    /**
     * @var int
     */
    private $likes;

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId ($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomListe ()
    {
        return $this->nom_liste;
    }

    /**
     * @param string $nom_liste
     */
    public function setNomListe ($nom_liste)
    {
        $this->nom_liste = $nom_liste;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getLikes ()
    {
        return $this->likes;
    }

}
