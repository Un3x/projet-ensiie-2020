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
        $usersData = $this->dbAdapter->query('SELECT * FROM "user"');
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            $user
                ->setId($usersDatum['id'])
                ->setUsername($usersDatum['username'])
                ->setEmail($usersDatum['email'])
                ->setInactive($usersDatum['inactive'])
                ->setSlogan($usersDatum['slogan'])
                ->setDescription($usersDatum['descript'])
                ->setCreatedAt(new \DateTime($usersDatum['created_at']));
            $users[] = $user;
        }
        return $users;
    }

    //Jointure dans la requête SQL : récupère tous les amis (validés) de l'utilisateur passé en argument
    public function fetchFriendsByUserId($userId)
    {
        $query = $this->dbAdapter->prepare(
            'SELECT "user".* FROM "user" INNER JOIN "friendship" ON id_user1 = id OR id_user2 = id WHERE status = 1 AND id <> :user_id AND (id_user1 = :user_id OR id_user2 = :user_id)');
        
        $query->bindValue(':user_id', $userId);
        $query->execute();
        $rows = $query->fetchAll();
        $friends = [];
        foreach ($rows as $row) {
            $friend = new User();
            $friend
                ->setId($row['id'])
                ->setUsername($row['username'])
                ->setEmail($row['email'])
                ->setInactive($row['inactive'])
                ->setSlogan($row['slogan'])
                ->setDescription($row['descript'])
                ->setCreatedAt(new \DateTime($row['created_at']));
            $friends[] = $friend;
        }
        return $friends;    
    }

    public function fetchIDByName($pseudo)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT id FROM "user" where username =:uss;');
        $string=addslashes($pseudo);
        $string_escaped = pg_escape_string($string);
        $stmt->bindValue('uss', $string_escaped);
        $result=$stmt->execute();
        return $result;
    }

    public function fetchByID($id)
    {
        $string='SELECT * FROM "user" where id ='.$id;
        $usersData = $this->dbAdapter->query($string);
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            $user
                ->setId($usersDatum['id'])
                ->setUsername($usersDatum['username'])
                ->setEmail($usersDatum['email'])
                ->setSlogan($usersDatum['slogan'])
                ->setDescription($usersDatum['descript'])
                ->setInactive($usersDatum['inactive']);
            $users[] = $user;
        }
        return $users;
    }

    public function fetchByName($pseudo)
    {
        $pseudo2="'".$pseudo."'";
        $str="SELECT * FROM \"user\" where username ='".$pseudo."'";
        $string = $this
            ->dbAdapter
            ->prepare($str);

        //$string->bindParam(':pseudo', $pseudo2);
        $usersData = $string->execute();
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            $user
                ->setId($usersDatum['id'])
                ->setUsername($usersDatum['username'])
                ->setEmail($usersDatum['email'])
                ->setSlogan($usersDatum['slogan'])
                ->setDescription($usersDatum['descript'])
                ->setInactive($usersDatum['inactive']);
            $users[] = $user;
        }
        return $users;
    }

    public function delete ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "user" where id = :userId');

        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }


    public function createUser ($pseudo,$pswrdc,$email)
    {
        $pass_hache = password_hash($pswrdc, PASSWORD_DEFAULT);

        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "user" (username, pass, email, created_at)  VALUES (:pseudo, :pass, :email,NOW());');
        $stmt->bindParam('pass', $pass_hache);
        $stmt->bindParam('email', $email);
        $stmt->bindParam('pseudo', $pseudo);
        $stmt->execute();
        
        
    }

    public function getOverview(){
        $usersData = $this->dbAdapter->query('SELECT id,username,email, id_user1, id_user2 FROM "user" natural join "friendship"');
        return $usersData;
    }

    public function userExists($pseudo)
    {
        $stmtverr = $this->dbAdapter->prepare('SELECT * FROM "user" WHERE username = :pseudo;');
        $stmtverr->bindParam('pseudo',$pseudo);
        $stmtverr->execute();
        $result=$stmtverr->fetch();
        return $result;
        
    }

    public function connectUser($user, $pass){
        #Verification de la conformite du mot de passe
        $stmt = $this->dbAdapter->prepare('SELECT id, pass, email, inactive, is_admin, descript, slogan FROM "user" WHERE username = :pseudo;');
        $stmt->bindParam('pseudo', $user);
        $stmt->execute();
        $result=$stmt->fetch();
        if (password_verify($pass, $result['pass'])){

            #initialisation de la session
            session_start();
            $_SESSION['id'] = $result['id'];
            $_SESSION['email']=$result['email'];
            $_SESSION['pseudo'] = $user;
            $_SESSION['inactive'] = $result['inactive'];
            $_SESSION['admin'] = $result['is_admin'];
            $_SESSION['descript'] = $result['descript'];
            $_SESSION['slogan'] = $result['slogan'];
            return true;
        }
        else{
            return false;
        }
    }

    public function changeUsername($userID,$newusername){
        $stmt = $this->dbAdapter->prepare('UPDATE "user" SET username = :pseudo WHERE id = :num;');
        $stmt->bindValue('num',$userID);
        $stmt->bindValue('pseudo', $newusername);
        $stmt->execute();
        $_SESSION['pseudo'] = $newusername;
    }


    public function changeEmail($userID, $newemail){
        $stmt = $this->dbAdapter->prepare('UPDATE "user" SET email = :emailu WHERE id = :num;');
        $stmt->bindValue('num', $userID);
        $stmt->bindValue('emailu', $newemail);
        $stmt->execute();
        $_SESSION['email'] = $newemail;

    }


    public function changePassword($userID, $newpass){
        $stmt = $this->dbAdapter->prepare('UPDATE "user" SET pass = :passw WHERE id = :num;');
        $stmt->bindValue('num', $userID);
        $newpass_hash = password_hash($newpass, PASSWORD_DEFAULT);
        $stmt->bindValue('passw', $newpass_hash);
        $stmt->execute();

    }

    public function changeSlogan($userID, $newslogan){
        $stmt = $this->dbAdapter->prepare('UPDATE "user" SET slogan = :sloganu WHERE id = :num;');
        $stmt->bindValue('num', $userID);
        $stmt->bindValue('sloganu', $newslogan);
        $stmt->execute();
        $_SESSION['slogan'] = $newslogan;
    }

    public function changeDescript($userID, $newdescript){
        $stmt = $this->dbAdapter->prepare('UPDATE "user" SET descript = :descriptu WHERE id = :num;');
        $stmt->bindValue('num', $userID);
        $stmt->bindValue('descriptu', $newdescript);
        $stmt->execute();
        $_SESSION['descript'] = $newdescript;
    }

    public function isInactiveUser($userID){
        $stmt = $this->dbAdapter->prepare('SELECT inactive FROM "user" WHERE id = :num;');
        $stmt->bindParam('num', $userID);
        $stmt->execute();
        $result=$stmt->fetch();
        return $result;
    }

    public function deactivateAccount($userID){
        $stmt = $this->dbAdapter->prepare('UPDATE "user" SET inactive = true WHERE id = :num;');
        $stmt->bindValue('num', $userID);
        $stmt->execute();
        $_SESSION['inactive'] = 1;
    }

    public function reactivateAccount($userID){
        $stmt = $this->dbAdapter->prepare('UPDATE "user" SET inactive = false WHERE id = :num;');
        $stmt->bindValue('num', $userID);
        $stmt->execute();
        $_SESSION['inactive'] = 0;
    }
}
