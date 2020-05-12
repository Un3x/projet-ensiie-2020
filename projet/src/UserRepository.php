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
        $usersData = $this->dbAdapter->query('SELECT * FROM Utilisateur');
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            $user
                ->setUsername($usersDatum['pseudo'])
                ->setLastname($usersDatum['nom'])
                ->setFirstname($usersDatum['prenom'])
                ->setPassword($usersDatum['mot_de_passe'])
                ->setEmail($usersDatum['mail'])
                ->setStatus((int)$usersDatum['statut'])
                ->setBanned((int)$usersDatum['banni']);
            $users[] = $user;
        }
        return $users;
    }

    public function delete ($username)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM Utilisateur where pseudo = :username');

        $stmt->bindParam('username', $username);
        $stmt->execute();
    }
    
    public function insert ($username,$lastname,$firstname,$password,$mail,$statut,$banni)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO Utilisateur(pseudo, nom, prenom, mot_de_passe, date_creation, mail, statut, banni) VALUES (:username, :lastname, :firstname, :password, NOW(), :mail, :statut, :banni)');
        $stmt->bindParam('username', $username);
        $stmt->bindParam('lastname',$lastname);
        $stmt->bindParam('firstname',$firstname);
        $stmt->bindParam('password',$password);
        $stmt->bindParam('mail',$mail);
        $stmt->bindParam('statut',$statut);
        $stmt->bindParam('banni',$banni);
        $stmt->execute();
    }
    
    public function fetchSuivis($suiveur)
    {
        /* La table Suivre n'est pas reconnue et doit être "importée" dans ce namespace ... */
        $suivisData = $this->dbAdapter->prepare('SELECT pseudo,nom,prenom FROM Utilisateur JOIN Suivre ON Suivre.suivi = Utilisateur.pseudo WHERE suiveur = ?');
        $suivisData->execute(array($suiveur));
        $suivis = [];
        foreach ($suivisData as $suivisDatum) {
            $suivi = new User();
            $suivi
                 ->setUsername($suivisDatum['pseudo'])
                ->setLastname($suivisDatum['nom'])
                ->setFirstname($suivisDatum['prenom']);
            $suivis[] = $suivi;
        }
        return $suivis;
    }
    
     public function fetchSuiveurs($suivi)
    {
        /* La table Suivre n'est pas reconnue et doit être "importée" dans ce namespace ... */
        $suiveursData = $this->dbAdapter->prepare('SELECT pseudo,nom,prenom FROM Utilisateur JOIN Suivre ON Suivre.suiveur = Utilisateur.pseudo WHERE suivi = ?');
        $suiveursData->execute(array($suivi));
        $suiveurs = [];
        foreach ($suiveursData as $suiveursDatum) {
            $suiveur = new User();
            $suiveur
                 ->setUsername($suiveursDatum['pseudo'])
                ->setLastname($suiveursDatum['nom'])
                ->setFirstname($suiveursDatum['prenom']);
            $suiveurs[] = $suiveur;
        }
        return $suiveurs;
    }
}
