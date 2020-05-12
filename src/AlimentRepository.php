<?php

namespace Aliment;

class AlimentRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function requete($sql){
        $req=$this->dbAdapter->prepare($sql);
        $req->execute();
    }

    public function add($alimentId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT * FROM "aliment" where id_aliment = :alimentId');

        $stmt->bindParam('alimentId', $alimentId);
        $stmt->execute();
        $users = [];
        foreach ($stmt as $usersDatum) {
            $user = new Aliment();
            $user
                ->setId_aliment($usersDatum['id_aliment'])
                ->setNom_aliment($usersDatum['nom_aliment']);
              
            $users[] = $user;
        }
        return $users;


    }

    /*param: $nom_legume le nom de l'ingredient
    *Renvoie l'id associé au nom de l'aliment donné en argument
    */
    public function fetchLegId($nom_legume) {
    	   $sql = 'SELECT id_aliment FROM "aliment" WHERE UPPER(nom_aliment) LIKE UPPER(?)';
	   $stmt = $this->dbAdapter->prepare($sql);
	   $stmt->execute(array($nom_legume));
	   $id = $stmt->fetch();
	   return $id;
    }

    public function fetchAll_panier($ids){
        $usersData = $this->dbAdapter->prepare('SELECT * FROM "aliment" WHERE id_aliment IN ('.implode(',',$ids).')');
        $usersData->execute();
	    $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new Aliment();
            $user
                ->setId_aliment($usersDatum['id_aliment'])
                ->setNom_aliment($usersDatum['nom_aliment'])
                ->setPrix_aliment($usersDatum['prix_aliment'])
		        ->setStock_aliment($usersDatum['stock_aliment'])
		        ->setSaison_aliment($usersDatum['saison_aliment'])
		        ->setType_aliment($usersDatum['type_aliment']);
            $users[] = $user;
        }
        return $users;

    }

    /*
    *Renvoie une liste d'objet Aliment contenant les aliments de la base de données
    */
    public function fetchAll()
    {
        $usersData = $this->dbAdapter->query('SELECT * FROM "aliment"');
	$users = [];
        foreach ($usersData as $usersDatum) {
            $user = new Aliment();
            $user
                ->setId_aliment($usersDatum['id_aliment'])
                ->setNom_aliment($usersDatum['nom_aliment'])
                ->setPrix_aliment($usersDatum['prix_aliment'])
		->setStock_aliment($usersDatum['stock_aliment'])
		->setSaison_aliment($usersDatum['saison_aliment'])
		->setType_aliment($usersDatum['type_aliment']);
            $users[] = $user;
        }
        return $users;
    }

    /*param: $alimentId
    *Renvoie un objet Aliment correspondant à l'aliment asscoié à l'id dans la bdd
    */
    public function fetchAliment($alimentId)
    {
	$stmt = $this->dbAdapter->prepare('SELECT * FROM "aliment" WHERE id_aliment = ?');
        $stmt->execute(array($alimentId));
	$alimentData = $stmt->fetch();
        $aliment = new Aliment();
        $aliment
                ->setId_aliment($alimentData['id_aliment'])
                ->setNom_aliment($alimentData['nom_aliment'])
                ->setPrix_aliment($alimentData['prix_aliment'])
		->setStock_aliment($alimentData['stock_aliment'])
		->setSaison_aliment($alimentData['saison_aliment'])
		->setType_aliment($alimentData['type_aliment']);
        return $aliment;
    }

    /*param: $userId l'id de la commande
    *SUpprime de la bdd la commande associé à l'id
    */
    public function delete ($userId)
    {
	$stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "commande_contient" where id_aliment = :userId');

        $stmt->bindParam('userId', $userId);
        $stmt->execute();
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "aliment" where id_aliment = :userId');

        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }
}
