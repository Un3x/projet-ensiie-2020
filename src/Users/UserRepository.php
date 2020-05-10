<?php

namespace User;

class UserRepository
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
        $usersData = $this->dbAdapter->query(
            'SELECT * FROM "user"
            ORDER BY rights DESC, id ASC');
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            $user
                ->setId($usersDatum['id'])
                ->setXp($usersDatum['xp'])
                ->setUsername($usersDatum['username'])
                ->setEmail($usersDatum['email'])
                ->setRights($usersDatum['rights'])
                ->setCreatedAt(new \DateTime($usersDatum['created_at']));
            $users[] = $user;
        }
        return $users;
    }


    //check if username is already used , returns 0 if the userName is free   
    public function checkUser ($userName)
    {
    $users= $this->dbAdapter->prepare('SELECT COUNT(*) FROM "user" WHERE username= :userName');     
    $users->execute(['userName'=>$userName]);
    return $users->fetchColumn();
    }


    //check if username is already used , returns 0 if the email is free
    public function checkEmail($email)
    {
    $emails= $this->dbAdapter->prepare('SELECT COUNT(*) FROM "user" WHERE email= :Email');      
    $emails->execute(['Email'=>$email]);
    return $emails->fetchColumn();
    }
    
    //add a new row to the table "user" and "userCosmetics"
    public function add ($username, $email, $password)
    {
    $newUser=$this->dbAdapter->prepare('INSERT INTO "user" (username, email, password, xp, rights, created_at) VALUES (:userName, :Email, :passWord, 0, 0, NOW())');
        $newUser->bindParam('userName', $username);
        $newUser->bindParam('Email', $email);
	$newUser->bindParam('passWord', $password);
	$newUser->execute();

	//add a row to userCosmetics
	$sql='SELECT id FROM "user" WHERE username= :userName';
	$newUserID=$this->dbAdapter->prepare($sql);
	$UserRow=$newUserID->execute(['userName'=>$username]);
	$UserRow=$newUserID->fetch();
	$id=$UserRow['id'];

	$newCosmetics='INSERT INTO userCosmetics (id, IDimage, IDtitle) VALUES (:ID, 0, 0)';
	$stmt=$this->dbAdapter->prepare($newCosmetics);
    error_log("ADDING GGGGG $id");
	$stmt->bindParam('ID', $id);
	$stmt->execute();
    }

    public function delete ($userId)
    {
        $stmt = $this
            ->dbAdapter
	          ->prepare('DELETE FROM userCosmetics where id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();

        $stmt2 = $this
            ->dbAdapter
	          ->prepare('DELETE FROM queue where id = :userId');
        $stmt2->bindParam('userId', $userId);
        $stmt2->execute();

        $stmt3 = $this
            ->dbAdapter
	          ->prepare('DELETE FROM lector where id = :userId');
        $stmt3->bindParam('userId', $userId);
        $stmt3->execute();

        $stmt4 = $this
            ->dbAdapter
	          ->prepare('DELETE FROM playlist where id = :userId');
        $stmt4->bindParam('userId', $userId);
        $stmt4->execute();

        $stmt5 = $this
            ->dbAdapter
            ->prepare('DELETE FROM "user" where id = :userId');
        $stmt5->bindParam('userId', $userId);
        $stmt5->execute();
    }


    public function setRights ($userId, $rights)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare(
                'UPDATE "user" SET rights=:rights
                WHERE id=:id');
        $stmt->bindParam('rights', $rights);
        $stmt->bindParam('id', $userId);
        $stmt->execute();
    }


    public function getRights($id)
    {
        $rights = $this
            ->dbAdapter
            ->prepare(
                'SELECT rights FROM "user"
                WHERE id=:id');      
    $rights->execute(['id'=>$id]);
    return $rights->fetchColumn();
    }
}

