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

    /**
     * @param void
     * @return int[] fracs contenant les pourcentages de mise au bon format de la réunion
     * ainsi que le prochain décalage
     */
    public function formatMeetingDate()
    {
        $date_debut = $this->date_debut_reu->format('H:i');
        $date_fin = $this->date_fin_reu->format('H:i');
        $liste_debut=explode(":",$date_debut);
        $liste_fin=explode(":",$date_fin);
        $hdebut= (int) $liste_debut[0];
        $mdebut= (int) $liste_debut[1];
        $hfin= (int) $liste_fin[0];
        $mfin= (int) $liste_fin[1];
        $start = (60*$hdebut+$mdebut-480);
        $durée = (60*$hfin+$mfin) - (60*$hdebut+$mdebut);
        
        return array(100*$start/780, 100*$durée/780);
    }
}