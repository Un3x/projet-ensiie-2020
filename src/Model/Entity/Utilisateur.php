<?php

class Utilisateur {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $pseudo;

    /**
     * @var string
     */
    private $prenom;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $role;

    /**
     * @var bool
     */
    private $loggedIn;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /*Les setters renvoient l'instance actuelle afin d'enchaîner les traitements :
    on peut faire user->setId($id)->setPseudo($pseudo)->etc.
    */

    /**
     * @return Utilisateur
     * @param int $id
     */
    public function setId($id) {
        $this->$id = $id; 
        return $this;
    }

        /**
     * @return string
     */
    public function getPseudo() {
        return $this->pseudo;
    }

    /**
     * @return Utilisateur
     * @param string $pseudo
     */
    public function setPseudo($pseudo) {
        $this->$pseudo = $pseudo; 
        return $this;
    }    
    
    /**
    * @return string
    */
   public function getPrenom() {
       return $this->prenom;
   }

   /**
    * @return Utilisateur
    * @param string $prenom
    */
   public function setPrenom($prenom) {
       $this->$prenom = $prenom; 
       return $this;
   }    
   
   /**
   * @return string
   */
  public function getNom() {
      return $this->nom;
  }

  /**
   * @return Utilisateur
   * @param string $nom
   */
  public function setNom($nom) {
      $this->$nom = $nom; 
      return $this;
  }

/**
  * @return string
  */
 public function getRole() {
     return $tihs->role;
 }

 /**
  * @return Utilisateur
  * @param string $role
  */
 public function setRole($role) {
     $this->$role = $role; 
     return $this;
 }

     /**
     * @return bool
     */
    public function isLoggedIn() {
        return $this->loggedIn;
    }

    /**
     * @return Utilisateur
     * @param bool $loggedIn
     */
    public function setLoggedIn($loggedIn) {
        $this->$loggedIn = $loggedIn; 
        return $this;
    }
}
