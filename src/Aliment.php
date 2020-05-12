<?php

namespace Aliment;

class Aliment
{
    /**
     * @var int
     */
    private $id_aliment;

    /**
     * @var string
     */
    private $nom_aliment;

    /**
     * @var int
     */
    private $prix_aliment;

    /**
     * @var int
     */
    private $stock_aliment;

    /**
     * @var string
     */
     private $saison_aliment;

     /**
      * @var string
      */
      private $type_aliment;

    /**
     * @return int
     */
    public function getId_aliment ()
    {
        return $this->id_aliment;
    }

    /**
     * @param int $id
     */
    public function setId_aliment ($id)
    {
        $this->id_aliment = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom_aliment ()
    {
        return $this->nom_aliment;
    }

    /**
     * @param string $nom
     */
    public function setNom_aliment ($nom)
    {
        $this->nom_aliment = $nom;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrix_aliment ()
    {
        return $this->prix_aliment;
    }

    /**
     * @param int $prix
     */
    public function setPrix_aliment ($prix)
    {
        $this->prix_aliment = $prix;
        return $this;
    }

    /**
     *@return int
     */
     public function getStock_aliment()
     {
	return $this->stock_aliment;
     }

     /**
      *@param int stock
      */
      public function setStock_aliment ($stock)
      {
	$this->stock_aliment = $stock;
      	return $this;
      }

    /**
     * @return string
     */
    public function getSaison_aliment ()
    {
        return $this->saison_aliment;
    }

    /**
     * @param string $saison
     */
    public function setSaison_aliment ($saison)
    {
        $this->saison_aliment = $saison;
        return $this;
    }

    /**
     * @return string
     */
     public function getType_aliment()
     {
	return $this->type_aliment;
     }


     /**
      * @param string type_al
      */
      public function setType_aliment ($type_al)
      {
           $this->type_aliment=$type_al;
	   return $this;
       }
}
