<?php

namespace User;
require_once 'SimpleRepository.php';
use \Repository\SimpleRepository;

class UserRepository extends SimpleRepository
{
    private static $instance = null;
    
    public function __construct()
    {
        parent::__construct();
		if (UserRepository::$instance != null) return $instance;
		else $instance = $this;
	}

    public function fetchAll()
    {
        $sql = "SELECT * FROM Users";
        $stmt = $this->dbAdapter->prepare($sql);
        $stmt->execute();
        $usersData = $stmt->fetchAll();
        $users = [];
        foreach ($usersData as $row){
            $user = new User();
            $user
                ->setPseudo($row['pseudo'])
                ->setPassword($row['password'])
                ->setAdministrator($row['administrator'])
                ->setEmail($row['email'])
                ->setCreatedAt(new \DateTime($row['created_at']))
                ->setTeam($row['team']);
            $users[] = $user;
        }
        return $users;
    }

    public function delete ($username)
    {   
        $sql = "DELETE FROM Users where pseudo = :username";
        $stmt = $this->dbAdapter->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
    }
    
    public function getByKey($username){
            $users = $this->fetchAll();
            foreach ($users as $user): 
                if ($user->getPseudo() == $username){
                    return $user;
                }
            endforeach;
    }

    public function Check_Admin(string $username){
        // Prepare a select statement
		$sql = "SELECT pseudo,administrator FROM Users WHERE pseudo = :username";
		$stmt = $this->dbAdapter->prepare($sql);
        
        // Bind variables to the prepared statement as parameters
        // bindParam permet de faire en gros $param_username(PHP) = :username(SQL)
		$stmt->bindParam(":username", $username, \PDO::PARAM_STR);
				
		// Attempt to execute the prepared statement
		$stmt->execute();
		// Check if username exists, if yes then verify password
		if($stmt->rowCount() == 1){
			$row = $stmt->fetch();
            $admin = $row["administrator"];
            return $admin;
        }

        // Close statement
		unset($stmt);	
    }

    public function Validate_login(string $username,string $password){
         // Prepare a select statement
		$sql = "SELECT pseudo, password FROM Users WHERE pseudo = :username";
		$stmt = $this->dbAdapter->prepare($sql);
        
        // Bind variables to the prepared statement as parameters
        // bindParam permet de faire en gros $param_username(PHP) = :username(SQL)
		$stmt->bindParam(":username", $username, \PDO::PARAM_STR);
				
		// Attempt to execute the prepared statement
		$stmt->execute();
		// Check if username exists, if yes then verify password
		if($stmt->rowCount() == 1){
			$row = $stmt->fetch();
			$hashed_password = $row["password"];
			if(password_verify($password, $hashed_password)){
                return 1; //Password vérifié
            } else{
                return 2; //Password faux
            }
        }else{
            return 3;//pseudo inexistant
        }

		// Close statement
		unset($stmt);		
    }

    public function Verify_username(string $username)
    {
        $sql = "SELECT pseudo FROM Users WHERE pseudo = :username";
        $stmt = $this->dbAdapter->prepare($sql);
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":username", $username, \PDO::PARAM_STR);
                
        // Attempt to execute the prepared statement
        $stmt->execute();
        if($stmt->rowCount() == 1){
            return false; //Le pseudo existe déjà
        } else{
            return true;
        }
        // Close statement
        unset($stmt);
    }

    public function Register (string $username,string $password,string $email){
        //Inscription en tant qu'invité (non-administrateur)
        $sql = "INSERT INTO Users (pseudo, password, email, administrator,created_at) 
        VALUES (:username, :password, :email, FALSE, NOW())";
        
        $stmt = $this->dbAdapter->prepare($sql);

        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":username", $username, \PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, \PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, \PDO::PARAM_STR);

        // Attempt to execute the prepared statement
        $stmt->execute();
        
        // Close statement
        unset($stmt);
        
    }

    public function Modify_Pseudo (string $username, string $new_username){
        //Inscription en tant qu'invité (non-administrateur)
        $sql = "UPDATE Users SET pseudo=:new_username WHERE pseudo=:username";
        
        $stmt = $this->dbAdapter->prepare($sql);

        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":username", $username, \PDO::PARAM_STR);
        $stmt->bindParam(":new_username", $new_username, \PDO::PARAM_STR);

        // Attempt to execute the prepared statement
        $stmt->execute();
        var_dump($stmt->errorInfo());
        
        // Close statement
        unset($stmt);
        
    }

    public function Modify_Password (string $username, string $new_password){
        //Inscription en tant qu'invité (non-administrateur)
        $sql = "UPDATE Users SET password=:new_password WHERE pseudo=:username";
        
        $stmt = $this->dbAdapter->prepare($sql);

        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":username", $username, \PDO::PARAM_STR);
        $stmt->bindParam(":new_password", $new_password, \PDO::PARAM_STR);

        // Attempt to execute the prepared statement
        $stmt->execute();
        
        // Close statement
        unset($stmt);
        
    }

    public function Modify_Email (string $username, string $new_email){
        //Inscription en tant qu'invité (non-administrateur)
        $sql = "UPDATE Users SET email=:new_email WHERE pseudo=:username";
        
        $stmt = $this->dbAdapter->prepare($sql);

        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":username", $username, \PDO::PARAM_STR);
        $stmt->bindParam(":new_email", $new_email, \PDO::PARAM_STR);

        // Attempt to execute the prepared statement
        $stmt->execute();
        
        // Close statement
        unset($stmt);
        
    }

    public function Modify_Admin (string $username, bool $admin){
        //Inscription en tant qu'invité (non-administrateur)
        $sql = "UPDATE Users SET administrator=:admin WHERE pseudo=:username";
        
        $stmt = $this->dbAdapter->prepare($sql);

        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":username", $username, \PDO::PARAM_STR);
        $stmt->bindParam(":admin", $admin, \PDO::PARAM_STR);

        // Attempt to execute the prepared statement
        $stmt->execute();
        
        // Close statement
        unset($stmt);
        
    }

}
