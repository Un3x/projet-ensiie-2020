<?php

session_start();
require "../header.php";
require '../includes/dbh.inc.php';

$id_trajet = $_GET["id_trajet"];

$sql = "SELECT * FROM trajet WHERE id_trajet=?";
$stmt = $conn->prepare($sql);
if($stmt==false){
	header("Location: /projet-web/index.php?error=sqlerror");
}
else{
	$stmt->execute(array($id_trajet));
	$trajet=$stmt->fetchAll();
}

if(!empty($_GET["id"]) && $_GET["id"] == $_SESSION["userId"]){


?>

	<link rel="stylesheet" href="/projet-web/style/mesTrajets.css">
	<div class="container">
		<br><br>
	<?php 
		foreach ($trajet as $row) {?>
			<div class="wrapper">
			<h3 style="text-align: center"><?php echo $row["ville_depart"]." - ".$row["ville_arrivee"]; ?></h3>

			<form action="/projet-web/includes/modifierTrajet.inc.php" method="POST">
			<table class="trajetTab">
			<tr class="ligneTrajets">
				<td class="colTrajets"><b>Départ:</b> <?php echo $row['ville_depart'];?></td>
				<td class="colTrajets"><b>Arrivée :</b> <?php echo $row['ville_arrivee'];?></td>
			</tr>
			<tr class="ligneTrajets">
				<td class="colTrajets"><b>Date :</b> <?php echo $row['jour_depart'].' '.$row['mois_depart'].' '.$row['annee_depart']; ?></td>

				<td class="colTrajets"><b>Heure :</b> <?php echo $row['heure_depart'].':'.$row['minute_depart']; ?></td>
			</tr>
			<tr class="ligneTrajets">
				<td class="colTrajets">
					<label><b>Nombre de place</b></label>
					<select name="nombrePlace">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				</td>
			</tr>
			</table>
			<div class="buttonWrapper">
					<button type="submit" name="confirmer">Confirmer</button>
			</div>
			<input type="text" name="id_trajet" value="<?php echo $id_trajet; ?>" hidden="hidden">
			</form>
			</div>
			</div>
		<?php }
	?>
	</div>

<?php }else{
	header("Location: /projet-web/index.php");
} ?>

