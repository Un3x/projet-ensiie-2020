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

   //fonction qui verifie si la personne qui se connecte est un admin
    public function checkAdminAuthentification($username,$password)
    {
	$requete = "SELECT * FROM Administrateur JOIN Membre on Administrateur.Id_MembreA = Membre.id
                             where username = '$username' and passwd = '$password' and Administrateur.Droit = 1";
	$exec_requete = $this->dbAdapter->query($requete);
	$count   =  0;
	foreach ($exec_requete as $entry) {
		$count=$count+1;
	}
	return $count;
    }

    //fonction qui verifie si la personne qui se connecte est un super admin
    public function checkSuperAdminAuthentification($username,$password)
    {
    $requete = "SELECT * FROM Administrateur JOIN Membre on Administrateur.Id_MembreA = Membre.id
                                where username = '$username' and passwd = '$password' and Administrateur.Droit = 0";
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

    public function nb_users(){
        $usersData = $this->dbAdapter->query("SELECT * FROM membre");
        $nb_id = 0;
        foreach ($usersData as $users) {
            $nb_id = $nb_id +1;
        }
        return $nb_id;
    }

}