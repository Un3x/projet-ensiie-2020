<?php

namespace Message;

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
        $messagesData = $this->dbAdapter->query('SELECT * FROM Text');
        $messages = [];
        foreach ($messagesData as $messagesDatum) {
            $message = new Message();
            $message
                ->setId($messagesDatum['id_text'])
                ->setContent($messagesDatum['message'])
                ->setDate($messagesDatum['date_msg'])
                ->setEmetteur($messagesDatum['emetteur'])
                ->setRecepteur($messagesDatum['recepteur']);
            $messages[] = $message;
        }
        return $messages;
    }

    public function delete ($msgId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM Text where id_text = :msgId');

        $stmt->bindParam('msgId', $msgId);
        $stmt->execute();
    }
    
    public function insert(string $content, int $emetteur, int $recepteur)
    {
      $stmt = $this->dbAdapter->prepare(
        'insert into Text (message, emetteur, recepteur) values (:message, :emetteur, :recepteur)'
      );
      $stmt->bindValue(':message', $content, \PDO::PARAM_STR);
      $stmt->bindValue(':emetteur', $emetteur, \PDO::PARAM_STR);
      $stmt->bindValue(':recepteur', $recepteur, \PDO::PARAM_STR);
      return $stmt->execute();
    }
    
    public function select_recep ($userId)
    {
        $messagesData = $this
            ->dbAdapter
            ->prepare('SELECT eme.pseudo AS psd_e, rec.pseudo AS psd_r,message,date_msg,id_text 
            FROM ((Text 
            JOIN Membre AS eme ON eme.id_membre=emetteur)
            JOIN Membre AS rec ON rec.id_membre=recepteur)
            WHERE eme.id_membre!= :userId AND rec.id_membre= :userId');
        $messagesData->bindParam('userId', $userId);
        $messagesData->execute(); 
        $messagesFromA = $this
            ->dbAdapter
            ->prepare('SELECT eme.pseudo AS psd_e, message,date_msg,id_text 
            FROM Text 
            JOIN Membre AS eme ON eme.id_membre=emetteur
            WHERE recepteur= emetteur');
        $messagesFromA->execute(); 
        $messages=[];
        foreach ($messagesData as $messagesDatum) {
            $message = new Message();
            $message
                ->setId($messagesDatum['id_text'])
                ->setContent($messagesDatum['message'])
                ->setDate($messagesDatum['date_msg'])
                //->setEmetteur($messagesDatum['emetteur'])
                //->setRecepteur($messagesDatum['recepteur']);
                ->setEmetteur($messagesDatum['psd_e'])
                ->setRecepteur($messagesDatum['psd_r']);
            $messages[] = $message;
        }
        foreach ($messagesFromA as $messagesDatum) {
            $message = new Message();
            $message
                ->setId($messagesDatum['id_text'])
                ->setContent($messagesDatum['message'])
                ->setDate($messagesDatum['date_msg'])
                //->setEmetteur($messagesDatum['emetteur'])
                //->setRecepteur($messagesDatum['recepteur']);
                ->setEmetteur($messagesDatum['psd_e'])
                ->setRecepteur('envoyé à tous');
            $messages[] = $message;
        }
        return $messages;
    }
    
    public function select_emet ($userId)
    {
        $messagesData = $this
            ->dbAdapter
            ->prepare('SELECT eme.pseudo AS psd_e, rec.pseudo AS psd_r,message,date_msg,id_text 
            FROM ((Text 
            JOIN Membre AS eme ON eme.id_membre=emetteur)
            JOIN Membre AS rec ON rec.id_membre=recepteur)
            WHERE eme.id_membre= :userId AND rec.id_membre!= :userId');
        $messagesData->bindParam('userId', $userId);
        $messagesData->execute(); 
        $messagesFromA = $this
            ->dbAdapter
            ->prepare('SELECT eme.pseudo AS psd_e, message,date_msg,id_text 
            FROM Text 
            JOIN Membre AS eme ON eme.id_membre=emetteur
            WHERE recepteur= emetteur AND emetteur= :userId');
        $messagesFromA->bindParam('userId', $userId);
        $messagesFromA->execute(); 
        $messages=[];
        foreach ($messagesData as $messagesDatum) {
            $message = new Message();
            $message
                ->setId($messagesDatum['id_text'])
                ->setContent($messagesDatum['message'])
                ->setDate($messagesDatum['date_msg'])
                //->setEmetteur($messagesDatum['emetteur'])
                //->setRecepteur($messagesDatum['recepteur']);
                ->setEmetteur($messagesDatum['psd_e'])
                ->setRecepteur($messagesDatum['psd_r']);
            $messages[] = $message;
        }
        foreach ($messagesFromA as $messagesDatum) {
            $message = new Message();
            $message
                ->setId($messagesDatum['id_text'])
                ->setContent($messagesDatum['message'])
                ->setDate($messagesDatum['date_msg'])
                //->setEmetteur($messagesDatum['emetteur'])
                //->setRecepteur($messagesDatum['recepteur']);
                ->setEmetteur($messagesDatum['psd_e'])
                ->setRecepteur('envoyé à tous');
            $messages[] = $message;
        }
        return $messages;
    }
}
