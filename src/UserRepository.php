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
        $usersData = $this->dbAdapter->query('SELECT * FROM "user"');
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            $user
                ->setId($usersDatum['id'])
                ->setUsername($usersDatum['username'])
                ->setEmail($usersDatum['email'])
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
	$newUser=$this->dbAdapter->prepare('INSERT INTO "user" (username, email, password, rights, created_at) VALUES (:userName, :Email, :passWord, 0, NOW())');
        $newUser->bindParam('userName', $username);
        $newUser->bindParam('Email', $email);
	$newUser->bindParam('passWord', $password);
	$newUser->execute();

	//add a row to usersCosmetics
	$sql='SELECT id FROM "user" WHERE username= :userName';
	$newUserID=$this->dbAdapter->prepare($sql);
	$id=$newUserID->execute(['userName'=>$username])->fetch(PDO::FETCH_BOTH)['id'];

	$newCosmetics='INSERT INTO "userCosmetics" (id, IDimage, IDtitle) VALUES (:ID, 1, 1)';
	$stmt=$this->dbAdapter->prepare($newCosmetics);
	$stmt->bindParam('ID', $id);
	$stmt->execute();
    }


    public function delete ($userId)
    {
        $stmt = $this
            ->dbAdapter
	    ->prepare('DELETE FROM "user" where id = :userId');

        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }
}
