<?php

namespace src\Model\repository;
use Entity\User as User;
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
        $usersData = $this->dbAdapter->query('SELECT * FROM "utilisateur"');
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            $user
                ->setId($usersDatum['utilisateurid']) /* id ou userId ? */
                ->setUsername($usersDatum['pseudo'])
                ->setEmail($usersDatum['email'])
                ->setCreatedAt(new \DateTime($usersDatum['created_at']))
                ->setPromo($usersDatum['promo'])
                ->setIsAdmin($usersDatum['isadmin'])
                ->setPseudoDiscord($usersDatum['pseudodiscord'])
                ->setPasswd($usersDatum['passwd']);
            $users[] = $user;
        }
        return $users;
    }

    function insert(string $email,string $pseudo,string $mdp,string $promo,string $pseudo_discord)
    {
       
        $sql="insert into utilisateur (pseudo, email,passwd,promo,pseudoDiscord,created_at) values (?,?,?,?,?,NOW())";
        $stmt=$this->dbAdapter->prepare($sql);
        $stmt->bindParam(2,$email);
        $stmt->bindParam(1,$pseudo);
        $stmt->bindParam(4,$promo);
        $stmt->bindParam(5,$pseudo_discord);
        $stmt->bindParam(3,$mdp);
        $stmt->execute();  
        
     
    }

    public function delete (int $userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "utilisateur" where utilisateurId = :userid');

        $stmt->bindParam(':userid', $userId);
        $stmt->execute();
    }

    public function profil(string $pseudo)
    {
        $sql="SELECT utilisateurid,pseudo,created_at,promo,pseudoDiscord,email,passwd FROM utilisateur WHERE pseudo = :pseudo";
        $userdata=$this->dbAdapter->prepare($sql);
        $userdata->bindParam('pseudo', $pseudo);
        $userdata->execute();
        $users = [];
        foreach($userdata as $userdatum)
        {
            $user=new User();
            $user
                ->setId($userdatum['utilisateurid'])
                ->setUsername($userdatum['pseudo'])
                ->setEmail($userdatum['email'])
                ->setCreatedAt($userdatum['created_at'])
                ->setPromo($userdatum['promo'])
                ->setPseudoDiscord($userdatum['pseudodiscord'])
                ->setPasswd($userdatum['passwd']);
            $users [] =$user;
        }
        return $users;
    }
    public function update($userid,$pseudo,$mdp,$promo,$discord)
    {
        $sql="UPDATE utilisateur SET pseudo=?, promo=?, pseudoDiscord=?, passwd=? WHERE utilisateurId = ?";
        $userdata=$this->dbAdapter->prepare($sql);
        $userdata->bindParam(1, $pseudo);
        $userdata->bindParam(5, $userid);
        $userdata->bindParam(4, $mdp);
        $userdata->bindParam(2, $promo);
        $userdata->bindParam(3, $discord);
        $userdata->execute();

    }
    public function update2($userid,$pseudo,$promo,$discord)
    {
        $sql="UPDATE utilisateur set  pseudo=?, promo=?, pseudoDiscord=?  WHERE utilisateurId = ?";
        $userdata=$this->dbAdapter->prepare($sql);
        $userdata->bindParam(1, $pseudo);
        $userdata->bindParam(4, $userid);
        
        $userdata->bindParam(2, $promo);
        $userdata->bindParam(3, $discord);
        $userdata->execute();
    }

    public function update3($userid,$promo,$discord)
    {
        $sql="UPDATE utilisateur set promo=?, pseudoDiscord=?  WHERE utilisateurId = ?";
        $userdata=$this->dbAdapter->prepare($sql);
        $userdata->bindParam(3, $userid);
        $userdata->bindParam(1, $promo);
        $userdata->bindParam(2, $discord);
        $userdata->execute();
    }
}