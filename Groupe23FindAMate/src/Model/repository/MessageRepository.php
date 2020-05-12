<?php

namespace src\Model\repository;
use Entity\Message as Message;
class MessageRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll()
    {
        $MessagesData = $this->dbAdapter->query('SELECT * FROM "message"');
        $Messages = [];
        foreach ($MessagesData as $MessagesDatum) {
            $Message = new Message();
            $Message
                ->setMessageId($MessagesDatum['messageid'])
                ->setContent($MessagesDatum['content'])
                ->setSearchId($MessagesDatum['searchid'])
                ->setEmittor($MessagesDatum['emittor'])
                ->setCreatedAt($MessagesDatum['createdAt']);
            $Messages[] = $Message;
        }
        return $Messages;
    }

    //function insert(string $userName,string $createdAt,string $playersToFind,string $gameName,string $title)
    function insert(string $content,int $searchId,string $emittor)
    {
       
        $sql="insert into message (content,searchid,emittor,sent_at) values (?,?,?,NOW())";
        $stmt=$this->dbAdapter->prepare($sql);
        
        // $stmt->bindParam(2,$createdAt);
        $stmt->bindParam(1,$content);
        $stmt->bindParam(2,$searchId);
        $stmt->bindParam(3,$emittor);
        $stmt->execute();  
        
     
    }

    public function delete ($MessageId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "message" where MessageId = :MessageId');

        $stmt->bindParam('MessageId', $MessageId);
        $stmt->execute();

    }

    public function viewMessage(int $searchId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT content,emittor FROM "message" where searchid = :searchid');

        $stmt->bindParam('searchid', $searchId);
        $stmt->execute();
        foreach ($stmt as $MessagesDatum) {
            $Message = new Message();
                $Message
                    ->setEmittor($MessagesDatum['emittor'])
                    ->setContent($MessagesDatum['content']);
                $Messages[] = $Message;
            }
        if(empty($Messages))
        {
            return "";
        }
        return $Messages;
    }

}