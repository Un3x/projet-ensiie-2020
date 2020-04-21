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

    public function login($userId, $userPwd)
    {
        return False;
    }

    public function delete ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "user" where id = :userId');

        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }

    public function create($userUsername, $userPwd)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "user" (username, email, created_at)  VALUES (:name, :mdp, NOW())');
        $stmt->bindParam('name', $userUsername);
        $stmt->bindParam('mdp', $userPwd);
        $stmt->execute();
    }

}