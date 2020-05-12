<?php

namespace Friendship;

class FriendshipRepository
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
        $rows = $this->dbAdapter->query('SELECT * FROM "friendship"');
        $friendships = [];
        foreach ($rows as $row) {
            $friendship = new Friendship();
            $friendship
                ->setIdUser1($row['id_user1'])
                ->setIdUser2($row['id_user2'])
                ->setStatus($row['status'])
                ->setStatusDate(new \DateTime($row['status_date']));
            $friendships[] = $friendship;
        }
        return $friendships;
    }

    //TODO fetch by userId, indice (comme le fetch all avec une clause WHERE)

    public function fetchPendingFriendshipByUserId($userId)
    {
        $query = $this->dbAdapter->prepare(
            'SELECT * FROM "friendship" WHERE id_user2 = :userid AND status = 0');
        
        $query->bindValue(':userid', $userId);
        $query->execute();
        $rows = $query->fetchAll();
        $friendships = [];
        foreach ($rows as $row) {
            $friendship = new Friendship();
            $friendship
                ->setIdUser1($row['id_user1'])
                ->setIdUser2($row['id_user2'])
                ->setStatus($row['status'])
                ->setStatusDate(new \DateTime($row['status_date']));
            $friendships[] = $friendship;
        }
        return $friendships;
    }
    public function fetchPendingFriendshipByUserIdJoin($userId)
    {
        $query = $this->dbAdapter->prepare('SELECT * FROM "friendship" join "user" on id_user1="user".id WHERE id_user2 = :userid AND status = 0');
        $string_escaped = pg_escape_string($userId);
        $query->bindParam(':userid', $string_escaped);
        $usersDa = $query->execute();
        $userData= $usersDa->fetchAll();
        $usersreturn=array('user1','status');
        foreach ($userData as $userDatum){
            $usersreturntmp['user1']= $userDatum['username'];
            $usersreturntmp['status'] = $userDatum['status'];
            $usersreturn[]= $usersreturntmp;
        }
        return $usersreturn;
    }




    public function fetchAcceptedFriendshipByUserId($userId)
    {
        $query = $this->dbAdapter->prepare(
            'SELECT * FROM "friendship" WHERE (id_user1 = :user_id OR id_user2 = :user_id) AND status = 1');
        
        $query->bindValue(':user_id', $userId);
        $query->execute();
        $rows = $query->fetchAll();
        $friendships = [];
        foreach ($rows as $row) {
            $friendship = new Friendship();
            $friendship
                ->setIdUser1($row['id_user1'])
                ->setIdUser2($row['id_user2'])
                ->setStatus($row['status'])
                ->setStatusDate(new \DateTime($row['status_date']));
            $friendships[] = $friendship;
        }
        return $friendships;
    }

    public function create(Friendship $newFriendship)
    {
        $query = $this->dbAdapter->prepare(
            'INSERT INTO "friendship"(id_user1, id_user2, status, status_date) 
            VALUES (:id_user1, :id_user2, :status, :status_date)');
        
        $query->bindValue(':id_user1', $newFriendship->getIdUser1());
        $query->bindValue(':id_user2', $newFriendship->getIdUser2());
        $query->bindValue(':status', $newFriendship->getStatus());
        $query->bindValue(':status_date', $newFriendship->getStatusDate());

        $result = $query->execute();
        if ($result == false)
        {
            $query->errorInfo();
        }
        return $newFriendship;
    }

    public function update(Friendship $friendship)
    {
        $query = $this->dbAdapter->prepare(
            'UPDATE "friendship"
            SET status = :status, status_date = :status_date
            WHERE id_user1 = :id_user1 AND id_user2 = :id_user2');
        
        $query->bindValue(':id_user1', $friendship->getIdUser1());
        $query->bindValue(':id_user2', $friendship->getIdUser2());
        $query->bindValue(':status', $friendship->getStatus());
        $query->bindValue(':status_date', $friendship->getStatusDate());

        $result = $query->execute();
        if ($result == false)
        {
            $query->errorInfo();
        }
        return $friendship;
    }

    public function delete(Friendship $friendshipToDelete)
    {
        $query = $this->dbAdapter
        ->prepare('DELETE FROM "friendship" WHERE id_user1 = :id_user1 AND id_user2 = :id_user2');

        $query->bindValue(':id_user1', $friendshipToDelete->getIdUser1());
        $query->bindValue(':id_user2', $friendshipToDelete->getIdUser2());
        
        $result = $query->execute();
        if ($result == false)
        {
            $query->errorInfo();
        }
        return $result;
    }

    public function areFriends ($user1,$user2){
        $stmt = $this->dbAdapter->prepare('SELECT * FROM "friendship" WHERE (status=1) and ( (id_user1 = :user1 and id_user2 =:user2) or (id_user1 = :user2 and id_user2 =:user1));');
        $stmt->bindParam('user1', $user1);
        $stmt->bindParam('user2', $user2);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public function isPendingDemand($username1,$user2){
        $stmt = $this->dbAdapter->prepare('SELECT * FROM "friendship" join "user" on id_user1="user".id  WHERE status=0 and  (username = :user1 and id_user2 =:user2);');
        $stmt->bindParam('user1', $username1);
        $stmt->bindParam('user2', $user2);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public function acceptDemand ($user1, $user2){#l'utilisateur user2 accepte la demande de user1
        $stmt = $this->dbAdapter->prepare('UPDATE "friendship" SET status=1 where id_user1 = :id1 and id_user2 = :id2;');
        $stmt->bindValue('id1', $user1);
        $stmt->bindValue('id2', $user2);
        $stmt->execute();
    }

    public function askFriend ($user1, $user2){
        $stmt = $this->dbAdapter->prepare('INSERT INTO "friendship" (id_user1, id_user2, status, status_date) VALUES (:us1, :us2, 0, NOW());');
        $stmt->bindValue('us1', $user1);
        $stmt->bindValue('us2', $user2);
        $stmt->execute();
    }
}