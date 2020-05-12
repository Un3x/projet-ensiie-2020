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
        $usersData = $this->dbAdapter->query('SELECT * FROM Membre');
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            $user
                ->setId($usersDatum['id_membre'])
                ->setNom($usersDatum['nom'])
                ->setPrenom($usersDatum['prenom'])
                ->setPseudo($usersDatum['pseudo'])
                ->setEmail($usersDatum['email'])
                ->setPassword($usersDatum['password'])
                ->setAdresse($usersDatum['adresse'])
                ->setTelephone($usersDatum['telephone'])
                ->setRole($usersDatum['role'])
                ->setEtat($usersDatum['etat']);
            $users[] = $user;
        }
        return $users;
    }

    public function delete ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM Membre where id_membre = :userId');

        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }
    
    //test
    public function insert(string $pseudo, string $password)
    {
      $stmt = $this->dbAdapter->prepare(
        'insert into Membre (pseudo, password, role, etat) values (:pseudo, :password, :role, :etat)'
      );
      $stmt->bindValue(':pseudo', $pseudo, \PDO::PARAM_STR);
      $stmt->bindValue(':password', $password, \PDO::PARAM_STR);
      $stmt->bindValue(':role', "Membre", \PDO::PARAM_STR);
      $stmt->bindValue(':etat', "rien", \PDO::PARAM_STR);
      $stmt->execute();
      //return $id = $stmt->lastInsertId();
    }
    
    public function select ($userId)
    {
        $usersData = $this
            ->dbAdapter
            ->prepare('SELECT * FROM Membre where id_membre = :userId');
        $usersData->bindParam('userId', $userId);
        $usersData->execute();
        //$users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            $user
                ->setId($usersDatum['id_membre'])
                ->setNom($usersDatum['nom'])
                ->setPrenom($usersDatum['prenom'])
                ->setPseudo($usersDatum['pseudo'])
                ->setEmail($usersDatum['email'])
                ->setPassword($usersDatum['password'])
                ->setAdresse($usersDatum['adresse'])
                ->setTelephone($usersDatum['telephone'])
                ->setRole($usersDatum['role'])
                ->setEtat($usersDatum['etat']);
            //$users[] = $user;
        }
        //return $users;
        return $user;
    }
    
    public function select_ps ($pseudo)
    {
        $usersData = $this
            ->dbAdapter
            ->prepare('SELECT * FROM Membre where pseudo = :pseudo');
        $usersData->bindParam('pseudo', $pseudo);
        $usersData->execute();
        foreach ($usersData as $usersDatum) {
            $user = new User();
            $user
                ->setId($usersDatum['id_membre'])
                ->setNom($usersDatum['nom'])
                ->setPrenom($usersDatum['prenom'])
                ->setPseudo($usersDatum['pseudo'])
                ->setEmail($usersDatum['email'])
                ->setPassword($usersDatum['password'])
                ->setAdresse($usersDatum['adresse'])
                ->setTelephone($usersDatum['telephone'])
                ->setRole($usersDatum['role'])
                ->setEtat($usersDatum['etat']);
        }
        return $user;
    }
    
    public function modif ($id, string $nom, string $prenom, string $pseudo, string $email, string $password, string $adresse, string $telephone)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE Membre 
            SET nom= :nom, prenom= :prenom, pseudo= :pseudo, email= :email, password= :password, adresse= :adresse, telephone= :telephone
            where id_membre = :userId');
        $stmt->bindParam('userId', $id);
        $stmt->bindValue(':nom', $nom, \PDO::PARAM_STR);
        $stmt->bindValue(':prenom', $prenom, \PDO::PARAM_STR);
        $stmt->bindValue(':pseudo', $pseudo, \PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, \PDO::PARAM_STR);
        $stmt->bindValue(':adresse', $adresse, \PDO::PARAM_STR);
        $stmt->bindValue(':telephone', $telephone, \PDO::PARAM_STR);
        $stmt->execute();  
    }
    
    public function modif_etat ($id, string $etat)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE Membre 
            SET etat= :etat
            where id_membre = :userId');
        $stmt->bindParam('userId', $id);
        $stmt->bindValue(':etat', $etat, \PDO::PARAM_STR);
        $stmt->execute();          
    }
    
    public function modif_role ($id, string $role)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE Membre 
            SET role= :role
            where id_membre = :userId');
        $stmt->bindParam('userId', $id);
        $stmt->bindValue(':role', $role, \PDO::PARAM_STR);
        $stmt->execute();          
    }
}
