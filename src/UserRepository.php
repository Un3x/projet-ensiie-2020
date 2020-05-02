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
        $usersData = $this->dbAdapter->query("SELECT * FROM membre");
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
	$requete = "SELECT * FROM membre where username = '$username' and passwd = '$password'";
	$exec_requete = $this->dbAdapter->query($requete);
	$count   =  0;
	foreach ($exec_requete as $entry) {
		$count=$count+1;
	}
	return $count;
    }

    public function delete ($userName)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM Membre where username = :userName');

        $stmt->bindParam('userName', $userName);
        $stmt->execute();
    }

    public function newUser($id, $username, $email, $password)
    {
        $req = $this->dbAdapter->prepare('INSERT INTO Membre(id, username, email,  passwd) VALUES(:id, :username, :email, :password)');

        $req->bindParam('id', $id);    
        $req->bindParam('username', $username);
        $req->bindParam('email', $email);
        $req->bindParam('password', $password);

        if (!$req) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
        } 
        $req->execute();
    }

    public function modifyPSWD($username,$newPswd)
    {
        $req=$this->dbAdapter->prepare('UPDATE Membre SET passwd = :newPswd WHERE username = :username');
        $req->bindParam('newPswd',$newPswd);
        $req->bindParam('username',$username);

        if (!$req) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
        } 
        $req->execute();
    }
}