<?php

namespace Tournament;

class Tournament
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $organisateur;

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
    public function getName ()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName ($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrganisateur ()
    {
        return $this->organisateur;
    }

    /**
     * @param string $organisateur
     */
    public function setOrganisateur ($organisateur)
    {
        $this->organisateur = $organisateur;
        return $this;
    }

}