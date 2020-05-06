<?php
namespace Asso;

class AssoRepository
{
private $dbAdapter;
    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
public function fetch_Assos($userid)
{
        $usersAsso = $this->dbAdapter->query("SELECT Nom_Assoc FROM Appartenir where id=:userid");
        $Asso = [];
        foreach ($usersAsso as $TteAsso) {
            $userA = new Asso();
            $userA->setNomAssoc($TteAsso['Nom_Assoc']);
            $Asso[] = $userA;
       }
       return $Asso;
}

}