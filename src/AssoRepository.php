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
            $userA->setNomAssoc($TteAsso['nom_assoc']);
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

}