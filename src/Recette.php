<?php

namespace Recette;

class Recette
{
    /**
     * @var int
     */
    private $id_recette;

    /**
     * @var string
     */
    private $titre_recette;

    /**
     * @var string
     */
    private $difficulte;

    /**
     * @var int
     */
    private $tps_prep;

    /**
     * @var int
     */
     private $nb_pers;

     /**
      * @var string
      */
      private $preparation;

     /**
      * @var int
      */
      private $id_auteur;

    /**
     * @return int
     */
    public function getId_auteur ()
    {
        return $this->id_auteur;
    }

    /**
     * @param int $id
     */
    public function setId_auteur ($id)
    {
        $this->id_auteur = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId_recette ()
    {
        return $this->id_recette;
    }

    /**
     * @param int $id
     */
    public function setId_recette ($id)
    {
        $this->id_recette = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitre_recette ()
    {
        return $this->titre_recette;
    }

    /**
     * @param string $nom
     */
    public function setTitre_recette ($nom)
    {
        $this->titre_recette = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getDifficulte ()
    {
        return $this->difficulte;
    }

    /**
     * @param int $diff
     */
    public function setDifficulte ($diff)
    {
        $this->difficulte = $diff;
        return $this;
    }

    /**
     *@return int
     */
     public function getTps_prep()
     {
	return $this->tps_prep;
     }

     /**
      *@param int tps
      */
      public function setTps_prep ($tps)
      {
	$this->tps_prep = $tps;
      	return $this;
      }

    /**
     * @return int
     */
    public function getNb_pers ()
    {
        return $this->nb_pers;
    }

    /**
     * @param int $nb
     */
    public function setNb_pers ($nb)
    {
        $this->nb_pers = $nb;
        return $this;
    }

    /**
     * @return string
     */
     public function getPreparation()
     {
	return $this->preparation;
     }


     /**
      * @param string prep
      */
      public function setPreparation ($prep)
      {
           $this->preparation=$prep;
	   return $this;
       }
}