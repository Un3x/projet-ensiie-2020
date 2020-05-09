<?php

namespace Asso;

class Asso
{
    /**
     * @var int
     */
    private $NomMembre;

    /**
     * @var string
     */
    private $NomAssoc;

    /**
     * @var string
     */
    private $Id_Assoc;

    public function getNomMembre ()
    {
        return $this->IdMembre;
    }

    public function getNomAssoc ()
    {
        return $this->NomAssoc;
    }

    public function getIdAssoc ()
    {
        return $this->Id_Assoc;
    }

    public function setIdMembre ($IdMembre)
    {
        $this->IdMembre = $IdMembre;
        return $this;
    }

    public function setNomAssoc ($NomAssoc)
    {
        $this->NomAssoc = $NomAssoc;
        return $this;
    }

    public function setIdAssoc ($Id_Assoc)
    {
        $this->Id_Assoc = $Id_Assoc;
        return $this;
    }

}

