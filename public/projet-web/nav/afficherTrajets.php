<?php
require '../header.php';
require '../includes/dbh.inc.php';

$sql = "SELECT * FROM trajet,utilisateur WHERE trajet.id_conducteur=utilisateur.id_utilisateur";
$stmt = $conn->prepare($sql);
if($stmt == false){
	header("Location: /projet-web/index.php?error=sqlerror");
    exit();
}else{
	$stmt->execute(array());
    $result = $stmt->fetchAll();

//Dans la classe des boutons on met l'id du trajet pour pouvoir 
?>


<link rel="stylesheet" href="/projet-web/style/afficherTrajets.css">

<div class="container">
	<div class="row justify-content-around">
		<div class="col-lg-5 colonnes">
			<h2 class="titleCol">Propositions de trajet</h2>

			<?php
			if (count($result) > 0){
			foreach ($result as $row){
				if($row["type"] === "proposition" && $row["nombre_place"] > 0){?>
			<div class="wrapper">
				<form method="POST" action="./confirmer-reservation.php">
				<div class="headTrajet">
				<h3 class="titreTrajet"><?php echo $row['ville_depart'].' - '.$row['ville_arrivee'];?></h3>
				<p class="auteurTrajet"><?php echo $row['prenom'].' '.$row['nom'];?></p>
				</div>

				<table class="trajetTab">
					<tr class="ligneTrajets">
						<td class="colTrajets"><b>Départ:</b> <?php echo $row['ville_depart'];?></td>
						<td class="colTrajets"><b>Arrivée :</b> <?php echo $row['ville_arrivee'];?></td>
					</tr>
					<tr class="ligneTrajets">
						<td class="colTrajets"><b>Date :</b> <?php echo $row['jour_depart'].' '.$row['mois_depart'].' '.$row['annee_depart']; ?></td>
						<td class="colTrajets"><b>Heure :</b> <?php echo $row['heure_depart'].':'.$row['minute_depart']; ?></td>
					</tr>
				</table>
				<div class="buttonWrapper">
					<input type="hidden" name="id_trajet" value=<?php echo'"'.$row["id_trajet"].'"';?>>
					<input type="hidden" name="id_conducteur" value=<?php echo'"'.$row["id_conducteur"].'"';?>>
					<button type="submit"class="reserver" name="reserver"  >Réserver</button>
				</div>
				</form>
			</div>
			<?php }} ?>
		</div>

		<div class="col-lg-5 colonnes">
			<h2 class="titleCol">Demandes de trajet</h2>
			<?php
			foreach ($result as $row){
			if($row["type"] === "demande" && $row["nombre_place"] > 0){ ?>
			<div class="wrapper">
				<form method="POST" action="/projet-web/nav/confirmer-repondre.php">
				<div class="headTrajet">
				<h3 class="titreTrajet"><?php echo $row['ville_depart'].' - '.$row['ville_arrivee'];?></h3>
				<p class="auteurTrajet"><?php echo $row['prenom'].' '.$row['nom'];?></p>
				</div>

				<table class="trajetTab">
					<tr class="ligneTrajets">
						<td class="colTrajets"><b>Départ:</b> <?php echo $row['ville_depart'];?></td>
						<td class="colTrajets"><b>Arrivée :</b> <?php echo $row['ville_arrivee'];?></td>
					</tr>
					<tr class="ligneTrajets">
						<td class="colTrajets"><b>Date :</b> <?php echo $row['jour_depart'].' '.$row['mois_depart'].' '.$row['annee_depart']; ?></td>
						<td class="colTrajets"><b>Heure :</b> <?php echo $row['heure_depart'].':'.$row['minute_depart']; ?></td>
					</tr>
				</table>
				<div class="buttonWrapper">
					<input type="hidden" name="id_trajet" value=<?php echo'"'.$row["id_trajet"].'"';?>>
					<input type="hidden" name="id_conducteur" value=<?php echo'"'.$row["id_conducteur"].'"';?>>
					<button type="submit" name="repondre" class="repondre">Répondre</button>
				</div>
			</form>
			
			</div>
			<?php }} ?>
		</div>
	</div>
</div>

<?php
		}else{
		echo"<p>Aucun résultat</p>";
	}
}

require "../footer.php";
?>

<?php 
preg_match('!\d+!', "reserver 1202", $matches); //Pour extraire l'id du bouton.
print_r($matches[0]);
?>


