<?php

namespace Admin;

class Admin
{
    /**
     * @var int
     */
    private $id_MembreA;

    /**
     * @var int
     */
    private $droit;

    /**
     * @var int
     */
    private $id_assoc;

 
    /**
     * @var string
     */
    private $Nom_assoc;

        /**
     * @var string
     */
    private $username;

    /**
     * @return int
     */
    public function getId_MembreA ()
    {
        return $this->id_MembreA;
    }

    /**
     * @param int $id
     */
    public function setId_MembreA ($id_MembreA)
    {
        $this->id_MembreA = $id_MembreA;
        return $this;
    }

    /**
     * @return string
     */
    public function getDroit ()
    {
        return $this->droit;
    }

    /**
     * @param string $droit
     */
    public function setDroit ($droit)
    {
        $this->droit = $droit;
        return $this;
    }

    /**
     * @return int
     */
    public function getId_assoc ()
    {
        return $this->id_assoc;
    }

    /**
     * @param string $id_assoc
     */
    public function setId_assoc ($id_assoc)
    {
        $this->id_assoc = $id_assoc;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom_assoc()
    {
        return $this->Nom_assoc;
    }

    /**
     * @param string $Nom_assoc
     */
    public function setNom_assoc ($Nom_assoc)
    {
        $this->Nom_assoc = $Nom_assoc;
        return $this;
    }

        /**
     * @return string
     */
    public function getUsername ()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername ($username)
    {
        $this->username = $username;
        return $this;
    }
}