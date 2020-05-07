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
        $req->bindParam('username', $username);
        $req->bindParam('Nom_assoc', $Nom_assoc);

        if (!$req) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
        } 
        $req->execute();
    }

}