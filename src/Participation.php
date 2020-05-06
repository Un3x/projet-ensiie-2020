<?php

namespace Participation;

class Participation
{
    /**
     * @var string
     */
    private $id_reu;

    /**
     * @var int
     */
    private $id_membre;

    /**
     * @var int
     */
    private $statut;

    /**
     * @var timestamp
     */
    private $retard;

    /**
     * @return string
     */
    public function getIdReu ()
    {
        return $this->id_reu;
    }

    /**
     * @param string
     */
    public function setIdReu ($id_reu)
    {
        $this->id_reu = $id_reu;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdMembre ()
    {
        return $this->id_membre;
    }

    /**
     * @param int
     */
    public function setIdMembre ($id_membre)
    {
        $this->id_membre = $id_membre;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatut ()
    {
        return $this->statut;
    }

    /**
     * @param int
     */
    public function setStatut ($statut)
    {
        $this->statut = $statut;
        return $this;
    }

    /**
     * @return timestamp
     */
    public function getRetard ()
    {
        return $this->retard;
    }

    /**
     * @param timestamp
     */
    public function setRetard ($retard)
    {
        $this->retard = $retard;
        return $this;
    }
}
?>