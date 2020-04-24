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

    public function add ($username, $email, $password)
    {
	//add rights in the future
	$newUser=$this->dbAdapter->prepare('INSERT INTO "user" (username, email, password, rights, created_at) VALUES (:userName, :Email, :passWord, 0, NOW())');
        $newUser->bindParam('userName', $username);
        $newUser->bindParam('Email', $email);
        $newUser->bindParam('passWord', $password);
	$newUser->execute();
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
