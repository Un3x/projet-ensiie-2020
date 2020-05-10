<?php
namespace Asso;

class AssoRepository
{
    private $dbAdapter;
    
    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }


    
public function fetchAll()
{
    $requete = "SELECT * FROM association";
    $exec_requete = $this->dbAdapter->query($requete);  
    $assoces = [];
    foreach ($exec_requete as $a) {
        $assoc = new Asso();
        $assoc
            ->setNomAssoc($a['nom_assoc'])
            ->setIdAssoc($a['id_assoc']);
        $assoces[]= $assoc;
    }
    return $assoces;
}



    

public function fetch_Assos($userid)
{
    $usersAsso = $this->dbAdapter->query("SELECT Nom_Assoc FROM Appartenir where Id_Membre='$userid'");
    $Asso = [];
    foreach ($usersAsso as $TteAsso) {
        $userA = new Asso();
        $userA->setNomAssoc($TteAsso['Nom_Assoc']);
        $Asso[] = $userA;
       }
    return $Asso;
}

public function fetch_all_Assos()
{
        $usersAsso = $this->dbAdapter->query("SELECT Nom_Assoc FROM Association");
        $Asso = [];
        foreach ($usersAsso as $TteAsso) {
            $userA = new Asso();
            $userA->setNomAssoc($TteAsso['nom_assoc']);
            $Asso[] = $userA;
       }
       return $Asso;
}

/*
public function fetch_all_Assos_Excep($username)
{
        $preexistante= $this->dbAdapter->query("SELECT Nom_Assoc FROM Association where username='$username'");
        $ar= array();
        foreach($preexistante as $row){
            $ar[] = $row->getNomAssoc();
        }
         return $Asso;
        }
        $preexistante2=implode(",",$ar);
        $preexistante3=explode(",",$preexistante2);

        $usersAsso = $this->dbAdapter->query("SELECT Nom_Assoc FROM Association WHERE Nom_Assoc NOT IN '$preexistante2'");

            //  (SELECT Nom_Assoc FROM Association where username='$username')");

        //$usersAsso = $this->dbAdapter->query("SELECT Nom_Assoc FROM Association WHERE NOT EXISTS
          //  (SELECT Nom_Assoc FROM Association where username='$username')");
        $Asso = [];
        if(is_null($usersAsso)){
            echo "null";
        }
        foreach ($usersAsso as $TteAsso) {
            $userA = new Asso();
            $userA->setNomAssoc($TteAsso['nom_assoc']);
            $Asso[] = $userA;
       }
       return $Asso;
}*/

public function newMembre($Id_Membre,$Nom_Assoc,$username)
{       
        $sql2="SELECT Id_Assoc FROM Association where Nom_assoc = '$Nom_assoc'";
        $result2 = $this->dbAdapter->query($sql2);
        $donnees2 = $result2->fetch();
        $Id_Assoc = $donnees2['id_assoc'];

        $req = $this->dbAdapter->prepare('INSERT INTO Appartenir(Id_Assoc,Id_Membre,Nom_Assoc,username) VALUES( :Id_Assoc,:Id_Membre,:Nom_Assoc,:username)');

        $req->bindParam('Id_Assoc', $Id_Assoc);    
        $req->bindParam('Id_Membre', $Id_Membre);
        $req->bindParam('Nom_Assoc', $Nom_Assoc);
        $req->bindParam('username', $username);

        if (!$req) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
        } 
        $req->execute();
}

public function appartient($asso,$id){
        $sql="SELECT * FROM Appartenir where Id_Membre='$id' AND Nom_Assoc='$asso'";
        $exec_requete = $this->dbAdapter->query($sql);
        $count = 0;
        foreach($exec_requete as $entry){
            $count = $count + 1;
        }
        if($count != 0){ //si notre user appartient a l'asso
            return true;
        }
        else{
            return false;
        }
    }

public function fetch_all_Assos_for_Admin($userid)
{
    $usersAsso = $this->dbAdapter->query("SELECT Association.Nom_assoc FROM Association
        join Administrer on Association.Id_Assoc = Administrer.Id_Assoc
        join Membre on Membre.id = Administrer.Id_Membre
        where Membre.id = '$userid'");
    $Asso = [];
    foreach ($usersAsso as $TteAsso) {
        $userA = new Asso();
        $userA->setNomAssoc($TteAsso['nom_assoc']);
        $Asso[] = $userA;
    }
    return $Asso;
    }

}