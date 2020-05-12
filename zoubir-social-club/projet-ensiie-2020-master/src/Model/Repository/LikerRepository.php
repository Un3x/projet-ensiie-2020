<?php

namespace Rediite\Model\Repository;

error_reporting(E_ALL);
ini_set('display_errors',1);

use \Rediite\Model\Entity\Liker;
use \Rediite\Model\Entity\Personne;

class LikerRepository 
{

    /**
    *
    * @var \PDO
    */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    function insertLike($n_pers,$n_mess)
    {
        $req = "INSERT INTO liker (n_pers,n_mess) 
                            VALUES (:n_pers,:n_mess)";
        $stmt = $this->dbAdapter->prepare($req);
        $stmt->bindValue(':n_pers',$n_pers,\PDO::PARAM_INT);
        $stmt->bindValue(':n_mess',$n_mess,\PDO::PARAM_INT);
        $stmt->execute();
    }
    function isAlreadyLiked($n_pers,$n_mess)
    {
        $stmt = $this->dbAdapter->query("SELECT * FROM liker 
                                           WHERE n_pers = $n_pers
                                              AND n_mess=$n_mess");
        $is_liked = $stmt->rowCount();
        if($is_liked==0)
        {
            return "no";
        }
        else
        {
            return "yes";
        }
    }
    function selectLikeById($id_mess)
    {
      $req = "SELECT * FROM message WHERE n_mess = :id_mess";
      $stmt = $this->dbAdapter->prepare($req);
      $stmt->bindValue(':id_mess',$id_mess,\PDO::PARAM_INT);
      $stmt->execute();
      $row =$stmt->fetch();
      return $row['nb_like'];
    }

    function addOneLike($id_mess)
    {
      $req = "SELECT nb_like FROM message WHERE n_mess = :id_mess";
      $stmt = $this->dbAdapter->prepare($req);
      $stmt->bindValue(':id_mess',$id_mess,\PDO::PARAM_INT);
      $stmt->execute();
      $row =$stmt->fetch();
      $current_nb = $row['nb_like'];

      $current_nb++;
      $stmt2 = $this->dbAdapter->query("UPDATE message 
                                        SET nb_like = '$current_nb' 
                                        WHERE n_mess=$id_mess ");
      
    }

    function unlike($id_mess,$id_pers)
    {
 
      $stmt = $this->dbAdapter->query("SELECT nb_like 
                                         FROM message WHERE n_mess = $id_mess");
      $row =$stmt->fetch();
      $current_nb = $row['nb_like'];
      if ($current_nb>0)
      {
        $current_nb--;

      $stmt2 = $this->dbAdapter->query("UPDATE message 
                                          SET nb_like = '$current_nb'
                                          WHERE n_mess=$id_mess ");
      
      $stmt3 = $this->dbAdapter->query("DELETE FROM liker 
                                        WHERE n_mess=$id_mess 
                                        AND n_pers=$id_pers");
      
      }
    }

      

}
?>