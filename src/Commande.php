<?php

namespace Commande;

class Commande
{

	/**
	* @var int
	*/
	private $id;

	/**
	* @var \DateTime
	*/
	private $date_livraison;

	/**
	* @var int
	*/
	private $prix_total;

	/**
	* @var int
	*/
	private $userID;
	

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return \DateTime
     */
    public function getDateLivraison()
    {
        return $this->date_livraison;
    }

    /**
     * @param \DateTime $date_livraison
     */
    public function setDateLivraison($date_livraison)
    {
        $this->date_livraison = $date_livraison;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrixTotal()
    {
        return $this->prix_total;
    }

    /**
     * @param int $prix_total
     */
    public function setPrixTotal($prix_total)
    {
        $this->prix_total = $prix_total;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @param int $userID
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;
        return $this;
    }

}