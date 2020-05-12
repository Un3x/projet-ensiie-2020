<?php

namespace User;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
    *@var int
    */
    private $mobile;

    /**
    *@var string
    */
    private $nom;

    /**
    *@var string
    */
    private $prenom;

    /**
    *@var int
    */
    private $role;


    /**
    *@return int
    */
    public function getRole()
    {
	return $this->role;
    }

    /**
    *@param int $role
    */
    public function setRole($role)
    {
	$this->role = $role;
	return $this;
    }


    /**
    *@return string
    */
    public function getPrenom()
    {
	return $this->prenom;
    }

    /**
    *@param string $prenom
    */
    public function setPrenom($prenom)
    {
	$this->prenom = $prenom;
	return $this;
    }



    /**
    *@return string
    */
    public function getNom()
    {
	return $this->nom;
    }

    /**
    *@param string $nom
    */
    public function setNom($nom)
    {
	$this->nom = $nom;
	return $this;
    }

    /**
    *@return int
    */
    public function getMobile()
    {
	return $this->mobile;
    }

    /**
    *@param int $mobile
    */
    public function setMobile($mobile)
    {
	$this->mobile = $mobile;
	return $this;
    }

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId ($id)
    {
        $this->id = $id;
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
     * @return string
     */
    public function getPassword ()
    {
        return $this->password;
    }
    
    /**
     * @param string $password
     */
    public function setPassword ($password)
    {
	$this->password = $password;
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
}
