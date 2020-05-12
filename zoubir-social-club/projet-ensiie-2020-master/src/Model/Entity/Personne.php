<?php

namespace Rediite\Model\Entity;

class Personne {

    /**
     * @var int
     */
  private $n_pers;

    /**
     * @var string
     */
  private $mail;

    /**
     * @var string
     */
  private $nom;

   /**
     * @var string
     */
  private $prenom;
  
   /**
     * @var string
     */
  private $pseudo;

    /**
     * @var string
     */
  private $password;

   /**
     * @var DateTime
     */
  private $d_inscri;

   /**
     * @var Date
     */
  private $birth;

   /**
     * @var string
     */
  private $pays;
  
 /**
     * @var int 
     */

  private $isAdmin;
  
    /**
     * @return mixed
     */
    public function getId ()
    {
        return $this->n_pers;
    }

    /**
     * @param mixed $id
     * @return User
     */
    public function setId ($id)
    {
        $this->n_pers = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail ()
    {
        return $this->mail;
    }

    /**
     * @param mixed $email
     * @return Personne
     */
    public function setEmail ($email)
    {
        $this->mail = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword ()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return Personne
     */
    public function setPassword ($password)
    {
        $this->password = $password;
        return $this;
    }


     /**
     * @return mixed
     */
    public function getName ()
    {
        return $this->nom;
    }

   /**
     * @param mixed $name
     * @return Personne
     */
    public function setName ($name)
    {
        $this->nom = $name;
        return $this;
    }

     /**
     * @return mixed
     */
    public function getSurname ()
    {
        return $this->prenom;
    }

   /**
     * @param mixed $surname
     * @return Personne
     */
    public function setSurname ($surname)
    {
        $this->prenom = $surname;
        return $this;
    }

     /**
     * @return mixed
     */
    public function getNickname ()
    {
        return $this->pseudo;
    }

   /**
     * @param mixed $nickname
     * @return Personne
     */
    public function setNickname ($nickname)
    {
        $this->pseudo = $nickname;
        return $this;
    }
     /**
     * @return mixed
     */
    public function getCreationDate ()
    {
        return $this->d_inscription;
    }

   /**
     * @param mixed $d_inscription
     * @return Personne
     */
    public function setCreationDate ($d_inscription)
    {
        $this->d_inscri = $d_inscription;
        return $this;
    }
     /**
     * @return mixed
     */
    public function getBirth ()
    {
        return $this->birth;
    }

   /**
     * @param mixed $birth
     * @return Personne
     */
    public function setBirth ($birth)
    {
        $this->birth = $birth;
        return $this;
    }

     /**
     * @return mixed
     */
    public function getCountry ()
    {
        return $this->pays;
    }

   /**
     * @param mixed $country
     * @return Personne
     */
    public function setCountry ($country)
    {
        $this->pays = $country;
        return $this;
    }

    public function getAdmin()
    {
	 return $this->isAdmin;
    }

    public function setAdmin(int $num)
    {
      if ($num==1)
      {
        $this->isAdmin = 1;
      }
      else
      {	
	$this->isAdmin = 0;
      }
    }
}