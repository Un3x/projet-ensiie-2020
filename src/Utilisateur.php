<?php

namespace Utilisateur;

class Utilisateur
{
    /**
     * @var int
     */
    private $num_id;

    /**
     * @var string
     */
    private $pseudo;

    /**
     * @var string
     */
    private $mdp;

    /**
     * @var \DateTime
     */
    private $mail;

    /**
     * @var \DateTime
     */
    private $date_creation;

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->num_id;
    }

    /**
     * @param int $id
     */
    public function setId ($id)
    {
        $this->num_id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPseudo ()
    {
        return $this->pseudo;
    }

    /**
     * @param string $meteo
     */
    public function setPseudo ($pseudo)
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    /**
     * @return string
     */
    public function getMdp ()
    {
        return $this->mdp;
    }

    /**
     * @param string $meteo
     */
    public function setMdp ($mdp)
    {
        $this->mdp = $mdp;
        return $this;
    }

    /**
     * @return string
     */
    public function getMail ()
    {
        return $this->mail;
    }

    /**
     * @param string $terrain
     */
    public function setMail ($mail)
    {
        $this->mail = $mail;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateCrea ()
    {
        return $this->date_crea;
    }

    /**
     * @param \DateTime $mdj
     */
    public function setDateCrea ($date_crea)
    {
        $this->date_crea = $date_crea;
        return $this;
    }
}