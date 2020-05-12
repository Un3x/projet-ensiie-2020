<?php

namespace Rediite\Model\Repository;

error_reporting(E_ALL);
ini_set('display_errors',1);

use \Rediite\Model\Entity\Personne;
use \Reddite\Model\Factory\DbAdapterFactory;

class PersonneRepository {

      /**
      *
      * @var \PDO
      */
      private $dbAdapter;

      /**
      *
      * @var Hydrator
      */
      private $personneHydrator;

      public function __construct(\PDO $dbAdapter, \Rediite\Model\Hydrator\PersonneHydrator $personneHydrator)
      {
	$this->dbAdapter = $dbAdapter;
	$this->personneHydrator = $personneHydrator;
      }

      function insert(string $mail,
      	              string $nom,
		      string $prenom,
		      string $pseudo,
		      string $d_inscri,
		      string $birth,
		      string $password,
		      string $pays,
		      int $isadmin)
    {
    
      $stmt = $this->dbAdapter->prepare(
        "INSERT INTO personne 
		     	     (mail,nom,prenom,pseudo,d_inscri,birth,password,pays,is_admin) 
			     VALUES 
			     (:mail,:nom, :prenom, :pseudo, :d_inscri, :birth, :password, :pays, :isadmin)"
      );
      $stmt->bindParam(':mail', $mail, \PDO::PARAM_STR);
      $stmt->bindParam(':prenom', $prenom, \PDO::PARAM_STR);
      $stmt->bindParam(':nom', $nom, \PDO::PARAM_STR);
      $stmt->bindParam(':pseudo', $pseudo, \PDO::PARAM_STR);
      $stmt->bindParam(':d_inscri', $d_inscri, \PDO::PARAM_STR);
      $stmt->bindParam(':birth', $birth, \PDO::PARAM_STR);
      $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
      $stmt->bindParam(':pays', $pays, \PDO::PARAM_STR);
      $stmt->bindParam(':isadmin', $isadmin, \PDO::PARAM_INT);
      $stmt->execute();
    }

    function checkConnexion(string $mail, string $password)
    {
        $req ="SELECT * FROM personne WHERE mail=:mail AND password=:password" ;
	$stmt = $this->dbAdapter->prepare("SELECT * FROM personne WHERE mail=:mail AND password=:password");
	$stmt->bindParam(':mail',$mail, \PDO::PARAM_STR);
	$stmt->bindParam(':password',$password, \PDO::PARAM_STR);
	$stmt->execute();
	$userexist = $stmt->rowCount();
	if ($userexist==1)
	{
	  $userinfo = $stmt->fetch();
	  $_SESSION['n_pers'] = $userinfo["n_pers"];
	  $_SESSION['nom']    = $userinfo["nom"];
	  $_SESSION['prenom'] = $userinfo['prenom'];
	  $_SESSION['pseudo'] = $userinfo['pseudo'];
    $_SESSION['mail']   = $userinfo['mail'];
    $_SESSION['pays'] = $userinfo['pays'];
    $_SESSION['birth'] = $userinfo['birth'];
    $_SESSION['is_admin'] = $userinfo['is_admin'];
	  return "good";
	}
	else
	{
	 return "mauvais identifiant";
	}
    }

    function update(string $nom,string $prenom,string $pseudo,string $birth,string $password,string $pays, int $id)
    {
      $this->dbAdapter->query("UPDATE personne
                                   SET prenom ='$prenom',
                                       nom='$nom',
                                       pseudo='$pseudo',
                                       birth='$birth',
                                       pays='$pays',
                                       password='$password'
                                       WHERE n_pers=$id");
    }
    function findNumberWithName(string $name){
      $stmt=$this->dbAdapter->query("SELECT n_pers FROM personne WHERE nom=$name");
      return $stmt;
    }

    function findNameSurnameById($n_pers)
    {
      $stmt = $this->dbAdapter->query("SELECT prenom,nom FROM personne
                                       WHERE n_pers = $n_pers");
      $row = $stmt->fetch();
      return $row;
    }
  }