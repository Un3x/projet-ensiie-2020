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
                ->setCreatedAt(new \DateTime($usersDatum['created_at']))
                ->setPoints($usersDatum['points']);
            $users[] = $user;
        }
        return $users;
    }

    /**
     * @param str $username une chaîne de caractère
     * @return User $user l'utilisateur de username $username
     */
    public function getUser($username)
    {
        $users =  $this->fetchAll();
        foreach ($users as $u) {
            $name=$u->getUsername();
            if ($name == $username) {
                return $u;
            }
        }
        return NULL;
    }

    /**
     * @param $id l'id d'un utilisateur
     * @return User $user l'utilisateur d'id $id'
     */
    public function getUserById($id)
    {
        $users =  $this->fetchAll();
        foreach ($users as $u) {
            $uid=$u->getId();
            if ($uid == $id) {
                return $u;
            }
        }
        return NULL;
    }


    public function getParticipants($meetingId)
    {
        $requete = "SELECT * 
                    FROM reunion 
                    NATURAL JOIN appartenir 
                    JOIN membre 
                    ON membre.id = appartenir.id_membre
                    WHERE id_reu = '$meetingId'";
        $exec_requete = $this->dbAdapter->query($requete);
        $users = [];
        foreach ($exec_requete as $row) {
            $users[] = $row['username'];
        }
        return $users;
    }

    /**
     * @param $username et $password des chaînes de caractères valides 
     * @return $count le nombre d'entrées de la table Membre dont le nom d'utilisateur
     * et le mot de passe correspondent à $username et $password
     */
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

    public function deleteUser ($userName)
    {
        $stmt = $this->dbAdapter->prepare('DELETE FROM Membre where username = :userName');
        $stmt->bindParam('userName', $userName);
        if (!$stmt) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
        }
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

    public function newUser($id, $username, $email, $password)
    {
        $req = $this->dbAdapter->prepare('INSERT INTO Membre(id, username, email,  passwd, points) VALUES(:id, :username, :email, :password, :pointss)');

        $req->bindParam('id', $id);    
        $req->bindParam('username', $username);
        $req->bindParam('email', $email);
        $req->bindParam('password', $password);
        $req->bindParam('pointss', 0);

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
    public function modifyUsName($username,$newU)
    {
        $req=$this->dbAdapter->prepare('UPDATE Membre SET username = :newU WHERE username = :username');
        $req->bindParam('newU',$newU);
        $req->bindParam('username',$username);

        if (!$req) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
        } 
        $req->execute();
    }
    public function IsAdmin($userid){
        $sql="SELECT * FROM administrateur where id_membrea='$userid'";
        $SuperUserOf=$this->dbAdapter->query($sql);
        if(is_null($SuperUserOf)){ 
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * @param $mise la mise du joueur d'id $id_joueur
     * 
     * Met à jour les points du joueur (retranche la mise à ses points)
     */
    public function updateUserPoints($mise,$id_joueur) {
        $req=$this->dbAdapter->prepare('UPDATE Membre 
                                        SET points = :newpoints 
                                        WHERE id = :id_joueur ');
        $player = $this->getUserById($id_joueur);
        $newpoints = $player->getPoints() - $mise;
        $req->bindParam('newpoints',$newpoints);
        $req->bindParam('id_joueur',$id_joueur);

        if (!$req) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
        } 
        $req->execute();
    }

}