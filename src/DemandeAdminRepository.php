<?php

namespace Demande;

class DemandeRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetch_Demandes_Admin()
    {
        $usersData = $this->dbAdapter->query("SELECT username,nom_assoc FROM demandes_user_Superadmin");
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new Demande();
            $user
            ->setUsername($usersDatum['username'])
            ->setNom_assoc($usersDatum['nom_assoc']); 
            $users[] = $user;
        }
        return $users;
    }

    public function newDemande($username, $Nom_assoc)
    {
        $req = $this->dbAdapter->prepare('INSERT INTO Demandes_user_Superadmin(username, Nom_assoc) VALUES(:username, :Nom_assoc)');
        echo "on va bien dans la fonction newDemande";
        $req->bindParam('username', $username);
        $req->bindParam('Nom_assoc', $Nom_assoc);

        if (!$req) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
        } 
        $req->execute();
    }

    public function accept_admin($username){ //fonction a corriger !!! 

        echo "on passe dans la fonction accept_admin";
       /*  $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new Demande();
            $user
            ->setUsername($usersDatum['username'])
            ->setNom_assoc($usersDatum['Nom_assoc']); //pb ici?
            $users[] = $user;
        }
        return $users; */

        //a partir du username, on cherche à récupérer l'id qui vient de la table Membre
        $id = $this->dbAdapter->query("SELECT Membre.id FROM Membre join Administrateur where Membre.username = Administrateur.username");

        $req = $this->dbAdapter->prepare('INSERT INTO  Administrateur(Id_MembreA, Droit) VALUES (:id, 1)');
        $req->bindParam('id', $id);
        $req->bindParam('Droit', 1);

        if (!$req) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
        } 
        $req->execute();
    }
}