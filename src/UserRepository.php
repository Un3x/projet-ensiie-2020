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
        $usersData = $this->dbAdapter->query('SELECT * FROM users');
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

    public function delete ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM users where id = :userId');

        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }

    public function addUser(String $username, String $email, String $password)
    {
        $password = crypt($password, 'stupefaction'); //encrypt the password before saving in the database
        $query = "INSERT INTO users (username, email, pwd) 
                VALUES(:username, :email, :password)";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':username', $username);
        $result->bindParam(':email', $email);
        $result->bindParam(':password', $password);
        $result->execute();
        return $result;
    }

    public function fetchUserConnection(String $username, String $password)
    {
        $password = crypt($password, 'stupefaction');
        $query = "SELECT * FROM users WHERE username=:username AND pwd=:password";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':username', $username);
        $result->bindParam(':password', $password);
        $result->execute();
        return $result;
    }

    public function alreadyUser(String $username, String $email)
    {
        $query = "SELECT * FROM users WHERE username=:username OR email=:email LIMIT 1";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':username', $username);
        $result->bindParam(':email', $email);
        $result->execute();
        $user = $result->fetch();
        return (! empty($user));
    }
}