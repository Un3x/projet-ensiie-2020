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

    /*
    *Renvoie une liste d'objet User correspondant aux utilisateurs de la bdd 
    */
    public function fetchAll()
    {
        $usersData = $this->dbAdapter->query('SELECT * FROM "user"');
	$users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            $user
                ->setId($usersDatum['id'])
                ->setUsername($usersDatum['username'])
                ->setEmail($usersDatum['email'])
		->setPassword($usersDatum['password'])
		->setMobile($usersDatum['mobile'])
		->setNom($usersDatum['nom'])
		->setPrenom($usersDatum['prenom'])
		->setRole($usersDatum['rle'])
                ->setCreatedAt(new \DateTime($usersDatum['created_at']));
            $users[] = $user;
        }
        return $users;
    }

    /*param: $id l'id de l'utilisateur à récupérer
    *Renvoie un objet User correspondant à l'utilisateur qui possède l'id en argument dans
    *la base de données
    */
    public function fetchUser($id)
    {
        $stmt = $this->dbAdapter->prepare('SELECT * FROM "user" WHERE id = ?');
        $stmt->execute(array($id));
	$userData = $stmt->fetch(); //Infomrations de l'utilisateur dans la bdd
	
        $user = new User();
        $user
		->setId($userData['id'])
                ->setUsername($userData['username'])
                ->setEmail($userData['email'])
		->setPassword($userData['password'])
		->setMobile($userData['mobile'])
		->setNom($userData['nom'])
		->setPrenom($userData['prenom'])
		->setRole($userData['rle'])
                ->setCreatedAt(new \DateTime($userData['created_at'])); //Création de l'objet User
		
        return $user;
    }

    /*param: $username le pseudonyme
    * Renvoie true si $username est déjà utilisé comme pseudo dans la BDD
    */
    public function isUsernameTaken($username)
    {
	$sql = 'SELECT COUNT(*)
	FROM "user"
	WHERE username = ?';
	
	$stmt = $this->dbAdapter->prepare($sql);
	$stmt->execute(array($username));
	$result = $stmt->fetch();
	
	if($result['count'] == 0) //Si aucun utilisateur n'est trouvé
	{
		return false;
	}
	else
	{
		return true;
	}
    }

    /*param: $userInfos un array contenant username: le pseudo, email: l'email, password: le mot de passe
    *Rajoute un nouvel utilisateur dans la base de donnée avec comme attributs ceux de $userInfos. Lève l'exception
    *Pseudo déjà utiliser si le nom d'utilisateur est déjà dans la base de donnée.
    */
    public function addUser ($userInfos)
    {
	//Vérification que le nom d'utilisateur n'est pas déjà pris
	if(!$this->isUsernameTaken($userInfos['username'])) {
		$sql = 'INSERT INTO "user" (username, email, password, rle, created_at)  VALUES (?, ?,  ?, 0, NOW())';
      			  $stmt = $this
        		      ->dbAdapter
           		       ->prepare($sql);
	    
            $stmt->execute(array ($userInfos['username'], $userInfos['email'],$userInfos['password']));
	}
	else
	{
		throw new \Exception("Pseudo déjà utilisé");
	}

	    
    }

    /*$user un objet type User
    *Modifie les informations de l'utilisateur dans la base de données en focntion de l'objet User
    */
    public function updateUser($user) {
    	   $sql = 'UPDATE "user" SET prenom = ? WHERE id = ?';
	   $stmt = $this->dbAdapter->prepare($sql);
	   $stmt->execute(array($user->getPrenom(), $user->getId()));

	   $sql = 'UPDATE "user" SET nom = ? WHERE id = ?';
	   $stmt = $this->dbAdapter->prepare($sql);
	   $stmt->execute(array($user->getNom(), $user->getId()));

	   $sql = 'UPDATE "user" SET email = ? WHERE id = ?';
	   $stmt = $this->dbAdapter->prepare($sql);
	   $stmt->execute(array($user->getEmail(), $user->getId()));

	   $sql = 'UPDATE "user" SET password = ? WHERE id = ?';
	   $stmt = $this->dbAdapter->prepare($sql);
	   $stmt->execute(array($user->getPassword(), $user->getId()));

	   $sql = 'UPDATE "user" SET username = ? WHERE id = ?';
	   $stmt = $this->dbAdapter->prepare($sql);
	   $stmt->execute(array($user->getUsername(), $user->getId()));
    }

    /*param: $userId l'identifiant de l'utilisateur
    *Supprime de la bdd l'utilisateur associé à l'identifiant
    */
    public function delete ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "user" where id = :userId');

        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }
}