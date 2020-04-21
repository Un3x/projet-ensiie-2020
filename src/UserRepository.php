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
        $usersData = $this->dbAdapter->query('SELECT * FROM "membre"');
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

    public function checkUserAuthentification($username,$password)
    {
	$requete = "SELECT count(*) FROM membre where username = '.$username.' and passwd = '.$password.'";
	$exec_requete = $this->dbAdapter->query($requete);
	$count   =  0;
	foreach ($exec_requete as $entry) {
		$count=$count+1;
	}
	return $count;
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