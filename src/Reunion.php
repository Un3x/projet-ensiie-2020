<?php   

namespace Reunion;

class Reunion
{
    /**
     * @var string
     */
    private $id_assoc;

    /**
     * @var string
     */
    private $id_reu;

    /**
     * @var int
     */
    private $id_membreA;

    /**
     * @var \DateTime
     */
    private $date_debut_reu;

    /**
     * @var \DateTime
     */
    private $date_fin_reu;

    /**
     * @return string
     */
    public function getIdAssoc ()
    {
        return $this->id_assoc;
    }

    /**
     * @param string $id_assoc
     */
    public function setIdAssoc ($id_assoc)
    {
        $this->id_assoc = $id_assoc;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdReu ()
    {
        return $this->id_reu;
    }

    /**
     * @param string $id_reu
     */
    public function setIdReu ($id_reu)
    {
        $this->id_reu = $id_reu;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdMembreA ()
    {
        return $this->id_membreA;
    }

    /**
     * @param int $id_membreA
     */
    public function setIdMembreA ($id_membreA)
    {
        $this->id_membreA = $id_membreA;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebutReu ()
    {
        return $this->date_debut_reu;
    }

    /**
     * @param \DateTime $date_debut_reu
     */
    public function setDateDebutReu ($date__debut_reu)
    {
        $this->date_debut_reu = $date__debut_reu;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateFinReu ()
    {
        return $this->date_fin_reu;
    }

    /**
     * @param \DateTime $date_fin_reu
     */
    public function setDateFinReu ($date_fin_reu)
    {
        $this->date_fin_reu = $date_fin_reu;
        return $this;
    }
}