<?php require "header.php" ?>

	<section>
		<h1> Rechercher un objet </h1>
		<form action="rechercheObj.php"  method="get">
			<p>
				Rechercher un objet en fonction de :
			</p>

			<p>
				Son nom :
				<input type="text" name="nom">

				Sa catégorie :
				<input type="text" name="categorie">
				<br>

			Ses dates de disponibilité : </br>
			Date d'emprunt : <input type="date" id="debut" name="dateD" >
			Date de retour : <input type="date" id="fin" name="dateF" >
		</p>

		<p>
			<input type="submit" value="Chercher" />
		</p>
	</form>

	<?php
// Récupération des données du formulaire
	$nom = isset($_GET['nom']) ? $_GET['nom'] : '';
	$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : '';
	$dateD = isset($_GET['dateD']) ? $_GET['dateD'] : '';
	$dateF = isset($_GET['dateF']) ? $_GET['dateF'] : '';

	setlocale(LC_TIME, "fr_FR", "French");
	$todayy = new DateTime();
	$today = $todayy->format('Y-m-d');

	$flag = true;
	if ($dateD != '' and $dateF != ''){
		$dateD = date('Y-m-d', strtotime($dateD));
		$dateF = date('Y-m-d', strtotime($dateF));
		
			// Tests sur les dates entrées
		if($dateD < $today){
			echo "<script>alert(\"La date de début doit être plus grande ou égale à la date d'aujourd'hui\");</script>";
			echo "<script>window.location.replace(\"rechercheObj.php\");</script>";
			$flag = false;
		}
		if($dateF < $dateD){
			echo "<script>alert(\"La date de retour doit être plus grande à la date d'emprunt\");</script>";
			echo "<script>window.location.replace(\"rechercheObj.php\");</script>";
			$flag = false;
		}
	}

	else if (($dateD != '' and $dateF == '') or ($dateD == '' and $dateF != '')){
		echo "<script>alert(\"Vous devez saisir les deux dates, de début et de fin d'emprunt\");</script>";
		echo "<script>window.location.replace(\"rechercheObj.php\");</script>";
		$flag = false;
	}

		// Recherche des objets s'il n'y a pas de conflits dans les dates entrées
	if($flag == true){
			// Requête avec les filtres demandés
		$req = $dbAdapter->prepare("
			SELECT res.id as idObjet, o.id_Proprietaire AS idP, o.nom AS nomObjet,
			c.categorie AS nomCategorie, m.pseudo AS pseudoProprietaire
			FROM (
			SELECT o.id_obj AS id,
			SUM(IF(idEmprunt IS NULL, 0, '$dateD' <= date_fin AND '$dateF' >= date_debut)) AS ConflictingReservations
			FROM Objet o LEFT JOIN Emprunt e USING (id_obj)
			GROUP BY id_obj
			HAVING ConflictingReservations = 0) res
			, Objet o, Membre m 
			WHERE o.id_obj = res.id
			AND o.id_Proprietaire = m.id_Membre
				AND (UPPER(o.nom) LIKE CONCAT('%',UPPER(:nom),'%')) -- recherche contenue dans le nom de l'objet
				AND (UPPER(o.categorie) LIKE CONCAT('%',UPPER(:categorie),'%'))");

		$req->execute(array('nom' => $nom,
			'categorie' => $categorie));

			// S'il y a des résultats :
		if($req->rowCount() > 0){
			echo"
			<table>
			<tbody>";

				// On affiche chaque objet et ses caractéristiques
			while ($donnees = $req->fetch()){
				echo"
				<tr>
				<td width='25%'>
				";

				$query = $dbAdapter->query("SELECT image FROM Objet WHERE id_obj = " . $donnees['id_obj']);
				if($query->rowCount() > 0){
					while($row = $query->fetch(PDO::FETCH_ASSOC)){
						$imageURL = 'images/objects/'.$row["image"];
				?>
    <div id="profil"><img src="<?php echo $imageURL; ?>" id="profil_image" /><div>
				<?php 	}
					}else{ ?>
    <div id="profil"><image src="images/objects/default.jpg" id="profil_image"><div>
			<?php 	}
				echo"
				</td>
				<td><ul><li><a href='voirObjet.php?id=" .$donnees['idObjet'] . "'>" . $donnees['nomObjet'] . "</a></li>
				</td>
				</tr>";
			}
			echo
			"</tbody>
			</table>";
		}

		// S'il n'y a aucun objet
		else{
			echo "Aucun objet trouvé";
		}

		$req->closeCursor();
	}
	?>
</section>

<?php require "footer.php" ?>
