<?php

namespace Commande;

class CommandeRepository
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
    *Retourne une liste d'objets Commande correspondant à l'ensemble des commandes dans la base de donnée
    */
    public function fetchAll()
    {
        $commandesData = $this->dbAdapter->query('SELECT * FROM "commande"');
	$commandes = [];
        foreach ($commandesData as $commandesDatum) {
            $commande = new Commande();
            $commande
                ->setId($commandesDatum['id_commande'])
                ->setDateLivraison($commandesDatum['date_livraison'])
		->setPrixTotal($commandesDatum['prix_total'])
		->setuserID($commandesDatum['userid']);
            $commandes[] = $commande;
        }
        return $commandes;
    }

    /*param: $userId l'id de l'utilisateur dont on cherche les commandes
    *Renvoie une liste d'objet Commande contenant les commandes de l'utilisateur associé à $userId dans la bdd
    */
    public function fetchByUser($userId) {
    	   $sql = 'SELECT * FROM "user" JOIN "commande" ON userid = id WHERE id = ?';
	   $stmt = $this->dbAdapter->prepare($sql);
	   $stmt->execute(array($userId));
	   $commandesData = $stmt->fetchAll();
	   $commandes = [];
	   foreach($commandesData as $commandeData) {
	   			  $commande = new Commande();
				  $commande
            			      ->setId($commandeData['id_commande'])
        		              ->setDateLivraison($commandeData['date_livraison'])
				      ->setPrixTotal($commandeData['prix_total'])
				      ->setuserID($commandeData['userid']);
				  $commandes[] = $commande;
	   }

	   return $commandes; 
    }

    /*param: $commandId
    *Renvoie un objet commande corrsepondant à la commande associée à $commandId dans la bdd
    */
    public function fetchCommande($commandId)
    {
	$stmt = $this->dbAdapter->prepare('SELECT * FROM "commande" WHERE id_commande = ?');
        $stmt->execute(array($commandId));
	$commandeData = $stmt->fetch();
        $commande = new Commande();
        $commande
                ->setId($commandeData['id_commande'])
                ->setDateLivraison($commandeData['date_livraison'])
		->setPrixTotal($commandeData['prix_total'])
		->setuserID($commandeData['userid']);
        return $commande;
    }

    /*$commandInfos: les informations de la commande à ajouté (date_livraison, prix_total, userID)
    *Ajoute dans la base de donnée une commande contenant les infos de $commandeInfos et renvoie l'id de la commande nouvellement inséré
    */
    public function addCommande ($commandeInfos)
    {
	  $sql = 'INSERT INTO "commande" (date_livraison, prix_total, userID)  VALUES (?, ?, ?)';
    	  $stmt = $this
        	      ->dbAdapter
   		      ->prepare($sql);
	    
          $stmt->execute(array ($commandeInfos['date_livraison'], $commandeInfos['prix_total'], $commandeInfos['userID']));
	  return $this->dbAdapter->lastInsertId();
    }

    /*pram: $id_commande: l'id de la commande, $id_aliment l'id de l'aliment, $qte la quantité (en kg) de l'aliment dans la commande
    *Ajout dans la table de relation entre les aliments et commandes avec la quantité passé en paramètre
    */
    public function addAlimentToCommande ($id_commande, $id_aliment, $qte)
    {
	  $sql = 'INSERT INTO "commande_contient" (id_commande, id_aliment, quantite) VALUES (?, ?, ?);';
    	  $stmt = $this
        	      ->dbAdapter
   		      ->prepare($sql);
	    
          $stmt->execute(array ($id_commande, $id_aliment, $qte));
    }

    /*param: $commandeId: L'identifiant de la commande
    *Supprime la commande associé à l'identifiant dans la base de donnée
    */
    public function delete ($commandeId)
    {
    //suppression dans la table de relation des aliments et commandes
     $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "commande_contient" where id_commande = :commandeId');

	//suppression dans la tabe des commandes
        $stmt->bindParam('commandeId', $commandeId);
        $stmt->execute();
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "commande" where id_commande = :commandeId');

        $stmt->bindParam('commandeId', $commandeId);
        $stmt->execute();
    }

    /*param: $commandeId l'id de la commande
    * Renvoie le nom d'utilisateur du commanditaire de la commande associé à $commandeId dans la bdd
    */
    public function associatedClient($commandeId)
    {
	$sql = 'SELECT username
	        FROM "user"
		JOIN "commande" ON id = userID
		WHERE id_commande = ?';
		
	$stmt = $this
		->dbAdapter
		->prepare($sql);
	$stmt->execute(array ($commandeId));
	$result = $stmt->fetch();
	
	return $result['username'];
    }

    /*param: $commandeId l'id de la commande dont on souhaite récupérer les détails
    *Renvoie un array contenant une liste d'array contenant les aliments et la quantité de la commande
    */
    public function getDetailsCommande($commandeId)
    {
	$sql = 'SELECT id_aliment, quantite
	FROM "commande_contient"
	WHERE id_commande = ?';
	$stmt = $this
		->dbAdapter
		->prepare($sql);
	$stmt->execute(array ($commandeId));
	$result = $stmt->fetchAll();
	return $result;
	
    }
}