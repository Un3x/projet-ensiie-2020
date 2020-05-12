<?php

/*
 * Classe qui apporte des fonctionnalités évoluées pour la gestion des
 * problématiques de sécurité.
 */
class Security
{

    /*
     * @var dbAdapter
     *
     * Un objet dbAdapter est associée a Security
     */
    private $dbAdapter;
    
    /*
     * Constructeur
     */
    function __construct($dbAdapter)
    {
        session_start();
        $this->dbAdapter = $dbAdapter;
        $this->hydrate();
    }

    /*
     * Hydrate l'objet Security avec les données stockées dans le système
     * de session de PHP.
     */
    private function hydrate()
    {
        if ($this->isLoggedIn()) {
            foreach($_SESSION as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }
    
    /**
     * Permet à un utilisateur de se connecter en vérifiant son $pseudo et $mdp
     *
     * @param $pseudo le pseudo entré par l'utilisateur
     * @param $mdp  le mdp  entré par l'utilisateur
     */
    public function signIn($pseudo, $mdp)
    {
        if ( ! $this->isLoggedIn()) {
            $req = $this->dbAdapter->prepare('SELECT * FROM "Users" WHERE pseudo = :pseudo AND password = :password');
            $req->bindValue(':pseudo', $pseudo);
            $req->bindValue(':password', $mdp);
            $req->execute();
            $donnees = $req->fetch();
            if ($donnees && ! $donnees['suspendedaccount']) {
                foreach ($donnees as $key => $value) {
                    $_SESSION[$key] = $value;
                }
                return true;
            }
        }
        return false;
    }
    
    /*
     * Permet de mettre à jour les données du système de sécurité après
     * une modification de l'utilisateur connecté.
     */
    public function refresh()
    {
        if($this->isLoggedIn()){
          $identifiant=$_SESSION['id'];
          $req = $this->dbAdapter->prepare("SELECT * FROM \"Users\" WHERE id = :id");
          $req->bindValue(':id', $identifiant);
          $req->execute();
          foreach ($req->fetch() as $key => $value) {
              $_SESSION[$key] = $value;
          }
          $this->hydrate();
          return true;
        }
        return false;
    }
    
    /**
     * Permet à un utilisateur de se déconnecter
     *
     */
    public function signOut()
    {
        session_unset();
        session_destroy();
    }
    
    /**
     * Permet de savoir si un utilisateur est bien connecté
     *
     */
    public function isLoggedIn()
    {
        return isset($_SESSION) && isset($_SESSION['id']);
    }
    
    /**
     * Permet de savoir si un utilisateur est un admin
     *
     */
    public function isAdmin()
    {
      return isset($_SESSION) && isset($_SESSION['isadmin']) && $_SESSION('isadmin');
    }
    
    public function isGuest()
    {
        return !$this->isLoggedIn();
    }
}
