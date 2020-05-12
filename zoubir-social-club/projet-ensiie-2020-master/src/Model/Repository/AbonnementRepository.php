<?php

namespace Rediite\Model\Repository;

error_reporting(E_ALL);
ini_set('display_errors',1);

use \Rediite\Model\Entity\Abonnement;
use \Rediite\Model\Entity\Personne;

class AbonnementRepository {

      /**
      *
      * @var \PDO
      */
      private $dbAdapter;

      public function __construct(\PDO $dbAdapter)
      {
	$this->dbAdapter = $dbAdapter;
      }

      function insertAbonnement(int $pers1, int $pers2){
            $stmt=$this->dbAdapter->prepare(
            "INSERT INTO abonnement (n_pers1,n_pers2) VALUES (:pers1,:pers2)"
            );
            $stmt->bindValue(':pers1', $pers1, \PDO::PARAM_INT);
            $stmt->bindValue(':pers2', $pers2, \PDO::PARAM_INT);
            $stmt->execute();
      }
      function dejaAbonne(int $pers1,int $pers2){
            $stmt=$this->dbAdapter->prepare(
                  "SELECT * FROM abonnement WHERE n_pers1=:pers1 AND n_pers2=:pers2"
            );
            $stmt->bindValue(':pers1', $pers1, \PDO::PARAM_INT);
            $stmt->bindValue(':pers2', $pers2, \PDO::PARAM_INT);
            $stmt->execute();
            $nbrRow=$stmt->rowCount();
            if($nbrRow==1){
                  return 1;
            }
            else{
                  return 0;
            }
      }
      function desabonner(int $pers1, int $pers2){
            $stmt=$this->dbAdapter->prepare(
                  "DELETE FROM abonnement WHERE n_pers1=:pers1 AND n_pers2=:pers2"
            );
            $stmt->bindValue(':pers1', $pers1, \PDO::PARAM_INT);
            $stmt->bindValue(':pers2', $pers2, \PDO::PARAM_INT);
            $stmt->execute();
      }

      function getAbonnements(int $pers){
            $stmt=$this->dbAdapter->prepare("SELECT prenom,nom FROM personne JOIN abonnement ON personne.n_pers = abonnement.n_pers2  WHERE n_pers1=:pers");
            $stmt->bindValue(':pers', $pers, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt;
      }

      function getNbrAbonnements(int $pers){
            $stmt=$this->dbAdapter->prepare("SELECT n_pers2 FROM abonnement WHERE n_pers1=:pers");
            $stmt->bindValue(':pers', $pers, \PDO::PARAM_INT);
            $stmt->execute();
            $nbrAbonnements = $stmt -> rowCount();
            return $nbrAbonnements;
      }

      function getNbrAbonnes(int $pers){
            $stmt=$this->dbAdapter->prepare("SELECT n_pers1 FROM abonnement WHERE n_pers2=:pers");
            $stmt->bindValue(':pers', $pers, \PDO::PARAM_INT);
            $stmt->execute();
            $nbrAbonne = $stmt -> rowCount();
            return $nbrAbonne;
      }
}