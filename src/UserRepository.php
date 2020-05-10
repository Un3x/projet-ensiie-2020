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

    public function deleteUser($userId)
    {
        $stmt = $this->dbAdapter->prepare('DELETE FROM Membre where id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
        if (!$stmt) {
            echo "\nPDO::errorInfo():\n";
            print_r($dbh->errorInfo());
            } 
        echo "on passe dans la fonction delete";
        echo "on supprime l'identifiant : ".$userId;
    }
        
    public function nb_users(){
        $usersData = $this->dbAdapter->query("SELECT membre.id FROM membre");
        foreach ($usersData as $users) {
            $nb_id = max($users);
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


    public function accept_admin($username){

        //a partir du username, on cherche à récupérer l'id qui vient de la table Membre
        $sql="SELECT Membre.id FROM Membre where Membre.username = '$username'";
        $result = $this->dbAdapter->query($sql);
        $donnees = $result->fetch();
        $id = $donnees['id'];        
        
        //AJOUT table ADMINISTRATEUR grâce à son id
        $droit = 1;
        $req = $this->dbAdapter->prepare("INSERT INTO  Administrateur(Id_MembreA, Droit) VALUES (:id, :droit)");
        $req->bindParam('id',$id); //, PDO::PARAM_INT
        $req->bindParam('droit', $droit); //, PDO::PARAM_INT
        $req->execute();

        //RECUPERER le nom de l'asso
        $sql6="SELECT Demandes_user_Superadmin.Nom_assoc from Demandes_user_Superadmin 
                                where Demandes_user_Superadmin.username = '$username'";
        $result6 = $this->dbAdapter->query($sql6);
        $donnees6 = $result6->fetch();
        $Nom_assoc = $donnees6['nom_assoc'];

        //RECUPERER l'id assoc grace au nom de l'asso
        $sql2="SELECT Id_Assoc FROM Association where Nom_assoc = '$Nom_assoc'";
        $result2 = $this->dbAdapter->query($sql2);
        $donnees2 = $result2->fetch();
        $id_assoc = $donnees2['id_assoc'];

        //AJOUT table Administrer
        $req3 = $this->dbAdapter->prepare("INSERT INTO Administrer(Id_Assoc, Id_Membre) VALUES (:id_assoc, :id)");
        $req3->bindParam('id_assoc', $id_assoc);
        $req3->bindParam('id', $id);
        $req3->execute();

        //retirer de la table Demandes_user_Superadmin
        //maintenant que le user est un admin
        $req2 = $this ->dbAdapter->prepare("DELETE FROM Demandes_user_Superadmin where username = :username");
        $req2->bindParam(':username', $username);
        $req2->execute();
    }

    public function refuse_admin($username){
        //on peut le retirer de la table Demandes_user_Superadmin
        $req = $this ->dbAdapter->prepare("DELETE FROM Demandes_user_Superadmin where username = :username");
        $req->bindParam(':username', $username);
        $req->execute();
        if (!$req) {
            echo "\nPDO::errorInfo():\n";
            print_r($dbh->errorInfo());
        } 
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

    public function IsAdmin($userid){
        $sql="SELECT * FROM Administrateur where Id_MembreA='$userid' and Administrateur.droit = 1";
        $exec_requete = $this->dbAdapter->query($sql);
        $count = 0;
        foreach($exec_requete as $entry){
            $count = $count + 1;
        }
        if($count != 0){ //si notre user est un admin
            return true;
        }
        else{ //s'il n'est pas admin
            return false;
        }
    }

    public function IsSuperAdmin($userid){
        $sql="SELECT * FROM Administrateur where Id_MembreA='$userid' and Administrateur.droit = 0";
        $exec_requete = $this->dbAdapter->query($sql);
        $count = 0;
        foreach($exec_requete as $entry){
            $count = $count + 1;
        }
        if($count != 0){ //si notre user est un admin
            return true;
        }
        else{ //s'il n'est pas admin
            return false;
        }
    }

}
