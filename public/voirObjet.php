<?php require "header.php" ?>

<section>

	<?php
	if (isset($_GET['id']))
	{
		setlocale(LC_TIME, "fr_FR", "French");
		// Récupération de l'objet et de ses informations
		$dbAdapter = (new DbAdaperFactory())->createService();
		$query = $dbAdapter->prepare
		("SELECT O.nom AS nom, categorie, M.pseudo AS prop, M.id_membre AS idP
			FROM Objet O, Membre M
			WHERE O.id_obj = :id_obj
			AND O.id_Proprietaire = M.id_membre");

		$query->execute(array('id_obj' => $_GET['id']));

		// L'objet existe
		if ($query->rowCount() > 0)
		{
			$row = $query->fetch();
			$proprietaire = (isset($_SESSION['id']) && $row['idP'] == $_SESSION['id']);

			// Récupération des favoris de l'utilisateur
			if (isset($_SESSION['id'])){
				$favoris = $dbAdapter->prepare
				("SELECT * FROM Favoris
					WHERE id_obj = :id_obj AND id_membre = :id_membre");
				$favoris->execute(array('id_obj' => $_GET['id'],
									'id_membre' => $_SESSION['id']));
				$mesFavoris=$favoris->fetch();

				$todayy = new DateTime();
				$today = $todayy->format('d / m / Y');

				// Récupération des emprunts de l'utilisateur concernant cet objet seulement
				$emprunts = $dbAdapter->prepare('SELECT id_obj, id_emprunt, Emprunteur,
											DATE_FORMAT(date_debut, \'%d / %m / %Y\') AS date_debut
										FROM Emprunt
										WHERE Emprunteur=:Emprunteur AND id_obj = :id_obj AND date_debut>=:date_debut
										ORDER BY date_debut DESC');
				$emprunts->execute(array('Emprunteur' => $_SESSION['id'], 'id_obj' => $_GET['id'],'date_debut' => $today));
				$mesEmprunts=$emprunts->fetch();
			}

			// Affichage des informations sur l'objet
			echo '<h1>' . $row['nom'] . '</h1>'; 
			$queryImg = $dbAdapter->prepare("SELECT image FROM Objet WHERE id_obj =:id_obj ");
			$queryImg->execute(array('id_obj' => $_GET['id']));
			if($queryImg->rowCount() > 0){
				while($rowImg = $queryImg->fetch(PDO::FETCH_ASSOC)){
					$imageURL = 'images/objects/'.$rowImg["image"];
			?>
    <div id="profil"><img src="<?php echo $imageURL; ?>" id="profil_image" /></div>
			<?php 	}
				}else{ ?>
    <div id="profil"><image src="images/objects/default.jpg" id="profil_image"></div>
			<?php 	}

				// Bouton Favoris
			if (isset($_SESSION['id'])){
				$idObjet = $_GET['id'];
				if ($favoris->rowCount() == 0) // Objet pas dans la liste
				{
					echo '<a href="ajoutFavoris.php?idObjetFav='.$idObjet.'"> <i class="a-heart"></i></a>';
				}
			}	
				
			echo "<p>Catégorie : " . $row['categorie'] . "</p>";
		

			// Disponibilités et demande d'emprunt
			if(!$proprietaire){
				afficherDisponibilite($dbAdapter);
				echo "<h2>Demande d'emprunt </h2>";
				if(isset($_SESSION['id'])){
					// Formulaire de demande d'emprunt
					$idObjet = $_GET['id'];
					echo "<form action=\"demandeEmprunt.php?id=$idObjet\" method=\"post\" onsubmit=\" return TDate();\">";
					echo "Date d'emprunt : <input id =\"debut\" name=\"date_Debut\" type=\"date\"required ><br><br>";
					echo "Date de retour : <input id =\"fin\" name=\"date_Fin\" type=\"date\"  required ><br>";
					echo "<input  name=\"objetId\" type=\"hidden\" value=\"$idObjet\">";
					echo "<input type=\"submit\" value=\"Effectuer la demande\" >";
					echo "</form>";
				}
			}

			

			// Affichage des emprunts futurs et de l'historique des emprunts
			// adapté en fonction de l'utilisateur
			if(isset($_SESSION['id'])){
				if(!$proprietaire){
					echo '<hr>';
					echo "<h2> Mes emprunts</h2>";
				}
				else{
					echo "<h2>Emprunts</h2>";
				}
				afficherEmpruntsFuturs($dbAdapter, $proprietaire);
				afficherHistoriqueEmprunts($dbAdapter, $proprietaire);
			}

		}

		else {
			echo "L'objet n'existe pas";
		}

		$query->closeCursor();
	}
	else {
		echo "Lien invalide";
	}
	?>

	<?php

	function afficherHistoriqueEmprunts($dbAdapter, $proprietaire){
		echo "<h3> Historique des emprunts</h3>";

		if($proprietaire){
			$query = $dbAdapter->prepare
			("SELECT E.id_emprunt, E.Emprunteur, date_debut, date_fin, M.pseudo AS emprunteur
				FROM Emprunt E, Membre M
				WHERE E.Emprunteur = M.id_membre
				AND E.id_obj = :id_obj
				AND date_fin < CURDATE()
				ORDER BY date_debut DESC");

			$query->execute(array('id_obj' => $_GET['id']));

			// Liste des emprunts
			if($query->rowCount() > 0) {
				echo "<ul>";
				while($row = $query->fetch()){
					$dateDeb = new DateTime($row['date_debut']);
					$dateFin = new DateTime($row['date_fin']);

					echo "<li> du " . strftime('%A %d %B ', $dateDeb->getTimeStamp()) .
					" au " . strftime('%A %d %B %G', $dateFin->getTimeStamp()) . "</a></li>";
				}
				echo "</ul>";
			}
			else{
				echo "L'objet n'a jamais été emprunté.";
			}
			$query->closeCursor();
		}
		else {
			$query = $dbAdapter->prepare
			("SELECT id_emprunt, date_debut, date_fin
				FROM Emprunt
				WHERE Emprunteur = :emprunteur
				AND id_obj = :objet
				AND date_fin < CURDATE()
				ORDER BY date_debut DESC");

			$query->execute(array('emprunteur' => $_SESSION['id'],
				'objet'=> $_GET['id']));

			if($query->rowCount() > 0) {
				echo "<ul>";
				while($row = $query->fetch()){
					$dateDeb = new DateTime($row['date_debut']);
					$dateFin = new DateTime($row['date_fin']);

					echo "<li> du " . strftime('%A %d %B ', $dateDeb->getTimeStamp()) .
					" au " . strftime('%A %d %B %G', $dateFin->getTimeStamp()) . "</li>";
				}
				echo "</ul>";
			}
			else{
				echo "Vous n'avez jamais emprunté cet objet.";
			}
			$query->closeCursor();
		}
	}

	function afficherEmpruntsFuturs($dbAdapter, $proprietaire){
		echo "<h3> Emprunts prévus </h3>";

		if($proprietaire){
			$query = $dbAdapter->prepare
			("SELECT E.id_emprunt, E.Emprunteur, date_debut, date_fin, M.pseudo AS emprunteur
				FROM Emprunt E, Membre M
				WHERE E.Emprunteur = M.id_membre
				AND E.id_obj = :objet
				AND date_fin >= CURDATE()
				ORDER BY date_debut");

			$query->execute(array('objet' => $_GET['id']));

			if($query->rowCount() > 0) {
				echo "<ul>";
				while($row = $query->fetch()){
					$dateDeb = new DateTime($row['date_debut']);
					$dateFin = new DateTime($row['date_fin']);

					echo "<li> du " . strftime('%A %d %B ', $dateDeb->getTimeStamp()) .
					" au " . strftime('%A %d %B %G', $dateFin->getTimeStamp()) ."</li>";
				}
				echo "</ul>";
			}
			else{
				echo "Pas d'emprunts prévus.";
			}
			$query->closeCursor();
		}
		else {
			$query = $dbAdapter->prepare
			("SELECT id_emprunt, date_debut, date_fin
				FROM Emprunt
				WHERE Emprunteur = :emprunteur
				AND id_obj = :objet
				AND date_fin >= CURDATE()
				ORDER BY date_debut");

			$query->execute(array('emprunteur' => $_SESSION['id'],
				'objet' => $_GET['id']));

			if($query->rowCount() > 0) {
				echo "<ul>";
				while($row = $query->fetch()){
					$dateDeb = new DateTime($row['date_debut']);
					$dateFin = new DateTime($row['date_fin']);

					echo "<li> du " . strftime('%A %d %B ', $dateDeb->getTimeStamp()) .
					" au " . strftime('%A %d %B %G', $dateFin->getTimeStamp()) ."</li>";
				}
				echo "</ul>";
			}
			else{
				echo "Pas d'emprunts prévus.";
			}
			$query->closeCursor();
		}
	}
	?>
</section>

<?php
function afficherDisponibilite($dbAdapter){
		// Récupération des emprunts présents/futurs
	$query2 = $dbAdapter->prepare
	("SELECT E.id_emprunt, E.Emprunteur, date_debut, date_fin, M.pseudo AS emprunteur
		FROM Emprunt E, Membre M
		WHERE E.Emprunteur = M.id_membre
		AND E.id_obj = :objet
		AND date_fin >= CURDATE()
		ORDER BY date_debut");

	$query2->execute(array('objet' => $_GET['id']));
	echo "<h2>Disponibilités </h2>";

	if($query2->rowCount() > 0) {
			// Date du jour
		$dateAjd = new DateTime();

			// Dates de début et de fin du premier emprunt
		$row2 = $query2->fetch();
		$dateDeb1 = new DateTime($row2['date_debut']);
		$dateFin1 = new DateTime($row2['date_fin']);

			// Liste des dates de disponibilités
		echo "<ul>";

			// Disponibilité entre aujourd'hui et le premier emprunt
		$dateDeb1->modify('-1 day');
		if($dateDeb1->format('Y-m-d') > $dateAjd->format('Y-m-d')){
			echo "<li> jusqu'au " . strftime('%A %d %B', $dateDeb1->getTimeStamp()) . "</li>";
		}
		else if($dateDeb1->format('Y-m-d') == $dateAjd->format('Y-m-d')){
			echo "<li> aujourd'hui</li>";
		}
		$dateDeb1->modify('+1 day');

			// Disponibilité entre 2 emprunts
		while($row2 = $query2->fetch()){
				// Date de début de l'emprunt suivant
			$dateDeb2 = new DateTime($row2['date_debut']);

				// Disponibilité entre les deux emprunts
			if($dateFin1->modify('+1 day') < $dateDeb2){
				echo "<li> du " . strftime('%A %d %B ', $dateFin1->getTimeStamp()) .
				" au " . strftime('%A %d %B', $dateDeb2->modify('-1 day')->getTimeStamp()) . "</li>";
			}

				// Date de fin de cet emprunt
			$dateFin1 = new DateTime($row2['date_fin']);
		}

			// Disponibilité à partir du dernier emprunt
		echo "<li> à partir du " . strftime('%A %d %B', $dateFin1->modify('+1 day')->getTimeStamp()) . "</li>";
		echo "</ul>";
	}

		// Pas d'emprunts
	else{
		echo "Pas d'emprunts prévus, l'objet est disponible.";
	}
}
?>

<script>
	function TDate() {
    var debut = document.getElementById("debut").value;
    var fin = document.getElementById("fin").value;

/*Comparaison des dates choisis avec la date d'aujourd'hui.
- Si l'année courante est inférieure STRICTEMENT de l'année choisis la fonction retourne TRUE.
- Si l'année courante est supérieure STRICTEMENT que l'année choisis alors la fonction retourne FALSE.
- Si le mois courant est supérieure STRICTREMENT que l'année choisis alors la fonction retourne TRUE.
- Si le mois courant est inférieure STRICTEMENT que l'année choisis alors la fonction retourne FALSE.
- Si l'année courante et le mois courant sont égaux aux années et mois choisis alors on compare les jours:
	- si la date du jour courant est inférieure à la date choisis alors la fonction retourne TRUE.
	- sinon la fonction retourne FALSE.
*/
	
	var date_debut =  new Date (debut);
	var d_dd= date_debut.getDate();
	var d_mm= date_debut.getMonth();
	var d_yy= date_debut.getFullYear();
	
	var date_fin =  new Date (fin);
	var f_dd=date_fin.getDate();
	var f_mm=date_fin.getMonth();
	var f_yy=date_fin.getFullYear();
	


	var date = new Date();
    var c_dd= date.getDate();
    var c_mm= date.getMonth();
    var c_yy= date.getFullYear();

	
	if((c_yy > d_yy || c_yy > f_yy) )
	{  alert("Vous avez choisis une année dans le passé!");return false; }

    if((c_yy < d_yy || c_yy < f_yy) )
	{  return true; }


	if( (c_mm > d_mm || c_mm > f_mm)){
		
		alert ("Vous avez choisis un mois dans le passé"); return false;
	}
	if( (c_mm < d_mm || c_mm < f_mm)){
		
		return true;
	}
	
	if ((c_yy == d_yy) && (c_mm == d_mm ) && (c_mm == f_mm) && (c_yy == f_yy)){
		if( (c_dd > d_dd) || c_dd > f_dd  ) { alert ("Jour dans le passé!");return false;}
	}
	
	return true;

}

</script>

<?php require "footer.php" ?>
