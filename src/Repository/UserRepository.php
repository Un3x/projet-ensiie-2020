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
        $usersData = $this->dbAdapter->query('SELECT userId, username, email, isAdmin FROM users');
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            $user
                ->setId($usersDatum['userid'])
                ->setUsername($usersDatum['username'])
                ->setEmail($usersDatum['email'])
                #->setCreatedAt(new \DateTime($usersDatum['created_at']))
                ->setAdmin($usersDatum['isadmin']);
            $users[] = $user;
        }
        return $users;
    }

    public function delete_user (int $userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM users WHERE userId = :userId');

        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }

    public function addUser(String $username, String $email, String $password)
    {
        $password = crypt($password, 'stupefaction'); //encrypt the password before saving in the database
        $query = "INSERT INTO users (username, email, pwd, isAdmin) 
                VALUES(:username, :email, :password, false)";
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

    public function get_UserID(String $username)
    {
        $query = "SELECT userID FROM users WHERE username=:username";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':username', $username);
        $result->execute();
        $userID = $result->fetch();
        return $userID[0]; //le résultat d'une requête est toujours un array !!!
    }

    public function isAdmin(String $username)
    {
        $query = "SELECT isAdmin FROM users WHERE username=:username";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':username', $username);
        $result->execute();
        $is = $result->fetch();
        return $is[0];
    }

    public function changeUsername(String $username, String $newName){
        $query = "UPDATE users SET username=:newName WHERE username=:username";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':newName', $newName);
        $result->bindParam(':username', $username);
        $result->execute();
    }

    public function changePassword(String $username, String $newpwd){
        $newpwd = crypt($newpwd, 'stupefaction');
        $query = "UPDATE users SET pwd=:newpwd WHERE username=:username";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':newpwd', $newpwd);
        $result->bindParam(':username', $username);
        $result->execute();
    }

    public function nameAlreadyUsed(String $username){
        $query = "SELECT * FROM users WHERE username=:username";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':username', $username);
        $result->execute();
        return $result->rowCount() == 1;
    }

}