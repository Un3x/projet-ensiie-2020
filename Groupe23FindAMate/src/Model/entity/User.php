<?php

namespace Entity;
class User
{
    /**
     * @var int
     */
    private $utilisateurId;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $username;

    /**
     * @var \DateTime
     */
    private $createdAt;

     /**
     * @var int
     */

     private $promo;

     /**
     * @var bool
     */

    private $isAdmin;

     /**
     * @var string
     */

    private $pseudoDiscord;

     /**
     * @var string
     */

    private $passwd;

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->utilisateurId;
    }

    /**
     * @param int $id
     */
    public function setId ($utilisateurId)
    {
        $this->utilisateurId = $utilisateurId;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail ()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail ($email)
    {
        $this->email = $email;
        return $this;
    }

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
     * @return \DateTime
     */
    public function getCreatedAt ()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt ($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int
     */

     public function getPromo() {
         return $this->promo;
     }

    /**
     * @param int $promo
     */

     public function setPromo($promo){
         $this->promo=$promo;
         return $this;
     }

    /**
     * @return string
     */
     public function getIsAdmin() {
        return $this->isAdmin;
    }
    /**
     * @param bool $isAdmin
     */

    public function setIsAdmin($isAdmin){
        $this->isAdmin=$isAdmin;
        return $this;
    }


     /**
     * @return string
     */

    public function getPseudoDiscord() {
        return $this->pseudoDiscord;
    }

    /**
     * @param string $pseudoDiscord
     */

    public function setPseudoDiscord($pseudoDiscord){
        $this->pseudoDiscord=$pseudoDiscord;
        return $this;
    }

      /**
     * @return string
     */

    public function getPasswd() {
        return $this->passwd;
    }

    /**
     * @param string $passwd
     */

    public function setPasswd($passwd){
        $this->passwd=$passwd;
        return $this;
    }

    
}

