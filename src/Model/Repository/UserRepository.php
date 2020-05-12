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

    public function fetchAll()  // on récupère la liste de tous les utilisateurs dans la table user
    {
        $usersData = $this->dbAdapter->query('SELECT * FROM "user"');
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            $user
                ->setUsername($usersDatum['username'])
                ->setEmail($usersDatum['email'])
                ->setCreatedAt(new \DateTime($usersDatum['created_at']));
            $users[] = $user;
        }
        return $users;
    }

    public function delete ($userName)    // suppresion d'un utilisateur
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "user" where username = :userName');

        $stmt->bindParam('userName', $userName);
        $stmt->execute();
    }

    public function insert ($userName, $userEmail, $userPassword)   // ajout d'un nouvel utilisateur dans la BD
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "user" (username,password,email,created_at) VALUES (:username,:password, :email,NOW())');

        $stmt->bindValue(':username', $userName);
        $stmt->bindValue(':email', $userEmail);
        $stmt->bindValue(':password', $userPassword);

        $stmt->execute();
        $stmt = null;

        return $this->dbAdapter->lastInsertId();
    }

    public function checkInfos ($userName,$userPassword)       // vérification lors de la connexion que les informations sont valides
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT COUNT(*) AS usercount FROM "user" WHERE username = :userName
                AND password = :userPassword');

        $stmt->bindParam('userName', $userName);
        $stmt->bindParam('userPassword', $userPassword);

        $stmt->execute();
        $row = $stmt->fetch();
        $stmt = null;   // on termine la requête préparée

        return $row['usercount'];
    }

    public function checkIfUserExists ($userName)   // vérification dans la BD si le login $userName est déjà utilisé 
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT COUNT(*) AS usercount FROM "user" WHERE username = :userName');

        $stmt->bindParam('userName', $userName);

        $stmt->execute();
        $row = $stmt->fetch();
        $stmt = null;

        return $row['usercount'];
    }

    public function getCurrentUser ($userName) {    // création d'un objet User à partir de son login
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT * FROM "user" WHERE username = :userName');

        $stmt->bindParam('userName', $userName);

        $stmt->execute();
        $row = $stmt->fetch();
        $user = new User();
        $user
            ->setUsername($row['username'])
            ->setEmail($row['email'])
            ->setCreatedAt(new \DateTime($row['created_at']));

        $stmt = null;

        return $user;
    }


    public function setGlobalVars ($userName)   // définition des variables globales, utiles pour manipuler les fonctions
    {
        $_SESSION['user_name'] = $this->getCurrentUser($userName)->getUsername();
        $_SESSION['user_email'] = $this->getCurrentUser($userName)->getEmail();
    }


    public function follow ($followed,$follower)    // $follower s'abonne au feed de $followed
    {
        $stmt = $this->dbAdapter->prepare('INSERT INTO "follow" (follower,followed) VALUES (:follower,:followed)');
        $stmt->bindParam('follower',$follower);
        $stmt->bindParam('followed',$followed);
        $stmt->execute();
        $stmt=null;

    }

    public function getMyFollowers ($userName)  /* on récupère la liste des followers de $userName 
                                                        sous forme d'objets User*/
    {

        $stmt = $this->dbAdapter->prepare('SELECT follower FROM "follow" WHERE followed=:userName');
        $stmt->bindParam('userName',$userName);
        $stmt->execute();
        $userFollowers = $stmt->fetchAll();
        $stmt=null;

        $followers = [];
        foreach ($userFollowers as $follower) {
            $user = new User();
            $user
                ->setUsername($follower['follower']);
            $followers[] = $user;
        }

        return $followers;
    }


    public function getMyFollowings ($userName)     /* on récupère la liste des abonnements de $userName 
                                                        sous la forme d'une Array d'objets User*/
    {

        $stmt = $this->dbAdapter->prepare('SELECT followed FROM "follow" WHERE follower=:userName');
        $stmt->bindParam('userName',$userName);
        $stmt->execute();
        $userFollowers = $stmt->fetchAll();
        $stmt=null;

        $followers = [];
        foreach ($userFollowers as $follower) {
            $user = new User();
            $user
                ->setUsername($follower['followed']);
            $followers[] = $user;
        }

        return $followers;
    }


    public function showFollows($follows)   // affichage de la liste des utilisateurs de $follows (qui est une Array d'objets User)
    {

        if(!empty($follows)) { ?>

            <table class="tableFollows">
                    <?php 
                    foreach($follows as $follow) { 

                        $currentUser = $follow->getUsername(); ?>
                        <tr>
                            <td> 
                                <a href= <?php echo "home.php?action=viewOtherUsers&pseudo=". $currentUser; ?> >
                                    <?php echo $currentUser;  ?> 
                                </a> 
                            </td>
                        </tr>

                    <?php } ?>
            </table>
            
        <?php
        }
    }


    public function isFollowing ($followed,$follower) {     // on vérifie si $follower suit déjà $followed

        $stmt = $this->dbAdapter->prepare('SELECT COUNT(*) AS myfollower FROM "follow" WHERE followed=:followed AND follower = :follower AND followed != follower');
 
        $stmt->bindParam('followed',$followed);
        $stmt->bindParam('follower',$follower);
        $stmt->execute();

        $stmt->execute();
        $row = $stmt->fetch();
        $stmt = null;   // on termine la requête préparée

        return $row['myfollower'];

    }
}