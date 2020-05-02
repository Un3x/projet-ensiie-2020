<?php

namespace Demande;

class Demande
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $Nom_assoc;

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
    public function getNom_assoc ()
    {
        return $this->Nom_assoc;
    }

}

?>