<?php

namespace Recette;

class RecetteRepository
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
    *Renvoie la liste d'objet Recette contenant toute les recettes dans la bdd
    */
    public function fetchAll()
    {
        $usersData = $this->dbAdapter->query('SELECT * FROM "recette"');
	$users = [];
        foreach ($usersData as $usersDatum) {
            $user = new Recette();
            $user
                ->setId_recette($usersDatum['id_recette'])
                ->setTitre_recette($usersDatum['titre_recette'])
                ->setDifficulte($usersDatum['difficulte'])
		->setTps_prep($usersDatum['tps_prep'])
		->setNb_pers($usersDatum['nb_pers'])
		->setPreparation($usersDatum['preparation'])
		->setId_auteur($usersDatum['id_auteur']);
            $users[] = $user;
        }
        return $users;
    }

    /*param: $recetteId l'id de la recette à récupérer
    *Renvoie un objet Recette avec les attributs correspondants à la recette associé à l'id dans la bdd
    */
    public function fetchRecette($recetteId)
    {
	$stmt = $this->dbAdapter->prepare('SELECT * FROM "recette" WHERE id_recette = ?');
        $stmt->execute(array($recetteId));
	$recetteData = $stmt->fetch();
	
        $recette = new Recette(); //Création de l'objet Recette
        $recette
                ->setId_recette($recetteData['id_recette'])
                ->setTitre_recette($recetteData['titre_recette'])
                ->setDifficulte($recetteData['difficulte'])
		->setTps_prep($recetteData['tps_prep'])
		->setNb_pers($recetteData['nb_pers'])
		->setPreparation($recetteData['preparation'])
		->setId_auteur($recetteData['id_auteur']);
        return $recette;
    }

    /*param: $recetteInfos les informations de la recette à ajouté (titre_recette, difficulte, tps_prep, nb_pers, preparation, id_auteur)
    * Ajoute une recette dans la bdd en fonction des informations données en argument et renvoie l'id de la recette nouvellement crée
    */
    public function addRecette($recetteInfos)
    {
	$sql = 'INSERT INTO "recette" (titre_recette, difficulte, tps_prep, nb_pers, preparation, id_auteur) VALUES (?,?,?,?,?,?)';
	$stmt = $this->dbAdapter->prepare($sql);
	$stmt->execute(array($recetteInfos['titre_recette'], $recetteInfos['difficulte'], $recetteInfos['tps_prep'], $recetteInfos['nb_pers'], $recetteInfos['preparation'], $recetteInfos['id_auteur']));
	return $this->dbAdapter->lastInsertId();
	    
    }

    /*param: $id_leg l'id de l'aliment $qte: la quantité en gramme de l'aliment $id_recette l'id de la recette
    *Ajoute dans la table de relation aliment et Recette un lien entre l'aliment et les recettes fournis ansi que la quantité fournis
    */
    public function addLegumeToRecette($id_leg, $qte, $id_recette) {
    	   $sql = 'INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (?, ?, ?)';
	   $stmt = $this->dbAdapter->prepare($sql);
	   $stmt->execute(array($id_recette, $id_leg, $qte));
    }

    /*param: $auteurId l'id de l'auteur
    *Renvoie la liste des objets Recette qui ont pour l'auteur associé à $auteurId dans la bdd
    */
   public function fetchByAuteur($auteurId)
   {
	$sql = 'SELECT * FROM "user" JOIN "recette" ON id_auteur = id  WHERE id_auteur = ?';

	$stmt = $this
		->dbAdapter
		->prepare($sql);
	$stmt->execute(array ($auteurId));

	$results = $stmt->fetchAll();

	$recettes = []; //Construction de la liste d'objet
	foreach($results as $recetteData) { //Boucle sur les recettes de l'auteur
	$recette = new Recette();
        $recette
                ->setId_recette($recetteData['id_recette'])
                ->setTitre_recette($recetteData['titre_recette'])
                ->setDifficulte($recetteData['difficulte'])
		->setTps_prep($recetteData['tps_prep'])
		->setNb_pers($recetteData['nb_pers'])
		->setPreparation($recetteData['preparation'])
		->setId_auteur($recetteData['id_auteur']);
	$recettes[] = $recette;
	}

	return $recettes;
    }

    /*param: $recetteId l'id de la recette
    * Supprime de la base de donnée la recette associée à l'id donnée
    * attention cette fonction de ne marche probablement pas, il faudrait
    * d'abord supprimer de la relation "utilise" tout les liens entre
    * la recette et les aliments
    */
    public function delete ($recetteId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "recette" where id_recette = :recetteId');

        $stmt->bindParam('recetteId', $recetteId);
        $stmt->execute();
    }

    /*param: $id l'id de la recette
    *Renvoie les informations utilisateur de l'auteur de la recette associée à l'id donné
    */
    public function fetchInfosAuteur($id) {
    	   $sql = 'SELECT * FROM "user" JOIN "recette" ON id_auteur = id  WHERE id_recette = ?';
	   	$stmt = $this
		->dbAdapter
		->prepare($sql);
	$stmt->execute(array ($id));
	$result = $stmt->fetch();
	return $result;
    }

    
    /*param: $recetteId l'id de la recette 
    *Renvoie les détails des aliments de la recette donnée en argument
    */
    public function getDetailsRecette($recetteId)
    {
	$sql = 'SELECT id_aliment, quantite
	FROM "utiliser"
	WHERE id_recette = ?';
	$stmt = $this
		->dbAdapter
		->prepare($sql);
	$stmt->execute(array ($recetteId));
	$result = $stmt->fetchAll();
	return $result;
	
    }
}