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

    public function getNomMembre ()
    {
        return $this->IdMembre;
    }

    public function getNomAssoc ()
    {
        return $this->NomAssoc;
    }

    public function setNomMembre ($IdMembre)
    {
        $this->IdMembre = $IdMembre;
        return $this;
    }
    public function setNomAssoc ($NomAssoc)
    {
        $this->NomAssoc = $NomAssoc;
        return $this;
    }

}

