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
    private $email;
    
    /**
     * @var string
     */
    private $password;
    
    /**
     * @var string
     */
    private $adresse;
    
    /**
     * @var string
     */
    private $telephone;
    
    /**
     * @var string
     */
    private $role;
    
    /**
     * @var string
     */
    private $etat;
    
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
    public function getNom ()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom ($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrenom ()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom ($prenom)
    {
        $this->prenom = $prenom;
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
     * @param string $pseudo
     */
    public function setPseudo ($pseudo)
    {
        $this->pseudo = $pseudo;
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
     * @return string
     */
    public function getAdresse ()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse ($adresse)
    {
        $this->adresse= $adresse;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephone ()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone ($telephone)
    {
        $this->telephone= $telephone;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole ()
    {
        return $this->role;
    }

    /**
     * @param string $Role
     */
    public function setRole ($role)
    {
        $this->role= $role;
        return $this;
    }

    /**
     * @return string
     */
    public function getEtat ()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat ($etat)
    {
        $this->etat= $etat;
        return $this;
    }

}
