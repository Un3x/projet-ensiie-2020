<?php

namespace Rediite\Model\Repository;

error_reporting(E_ALL);
ini_set('display_errors',1);

use \Rediite\Model\Entity\Message;

class MessageRepository {

      /**
      *
      * @var \PDO
      */
      private $dbAdapter;

      /**
      *
      * @var Hydrator
      */
      private $messageHydrator;

      public function __construct(\PDO $dbAdapter, \Rediite\Model\Hydrator\MessageHydrator $messageHydrator)
      {
	$this->dbAdapter = $dbAdapter;
	$this->messageHydrator = $messageHydrator;
      }


      function insertMessage(string $content,int $nblikes,int $iscomment,int $writer)
    {
      $stmt = $this->dbAdapter->prepare(
        "insert into message (content,parution,nb_like,is_comment,n_pers) values
		     	       (:content,NOW(),:nblikes,:iscomment,:writer)"
      );
      $stmt->bindValue(':content', $content, \PDO::PARAM_STR);
      /*$stmt->bindValue(':parution', $parution, \PDO::PARAM_STR);*/
      $stmt->bindValue(':nblikes', $nblikes, \PDO::PARAM_INT);
      $stmt->bindValue(':iscomment', $iscomment, \PDO::PARAM_INT);
      $stmt->bindValue(':writer', $writer, \PDO::PARAM_INT);
      $stmt->execute();
    }

    function selectMessageByAbo(int $pers){
      $stmt=$this->dbAdapter->query("SELECT * FROM message 
                                     JOIN abonnement ON message.n_pers=abonnement.n_pers2 
                                     WHERE abonnement.n_pers1=$pers 
                                     ORDER BY message.parution DESC");
      return $stmt;
    } 

    function selectMessagesByWriter($id_writer)
    {
      $messages = array();
      $stmt = $this->dbAdapter->prepare(
        "SELECT * FROM message 
         WHERE n_pers = :id_writer 
         ORDER BY parution DESC");
      $stmt->bindValue(':id_writer',$id_writer, \PDO::PARAM_INT);
      $stmt->execute();
      $i = 0;
      $message_exist = $stmt->rowCount();
      if ($message_exist>=1)
      {
        return $stmt->fetchAll();
        /*
        while($roww = $stmt->fetch() )
        {
          $messages[$i] = $this->messageHydrator->hydrate($roww);
          $i = $i+1;
          return $messages;
        }*/
      }
      else 
      {
        return $messages;
      }
    }
    function deleteMessageById($id_mess)
    {
      $req = "DELETE FROM message WHERE n_mess=:id_mess";
      $stmt = $this->dbAdapter->prepare($req);
      $stmt->bindValue('id_mess',$id_mess,\PDO::PARAM_INT);
      $stmt->execute();
    }
    
    function getAuteur($id_mess)
    {
        $req4 = "SELECT * FROM message WHERE n_mess = :id_mess";
        $stmt4 = $this->dbAdapter->prepare($req4);
        $stmt4->bindValue(':id_mess',$id_mess,\PDO::PARAM_INT);
        $stmt4->execute();
        $row4 =$stmt4->fetch();
        return $row4['n_pers'];
    }   
}