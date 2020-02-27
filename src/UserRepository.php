<?php

namespace User;

class UserRepository
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO('pgsql:host=localhost;dbname=ensiie', 'ensiie', 'ensiie');
    }

    public function fetchAll()
    {
        $usersData = $this->pdo->query('SELECT * FROM "user"');
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new \User\User();
            $user
                ->setId($usersDatum['id'])
                ->setUsername($usersDatum['username'])
                ->setEmail($usersDatum['email'])
                ->setCreatedAt(new \DateTime($usersDatum['created_at']));
            $users[] = $user;
        }
        return $users;
    }
}