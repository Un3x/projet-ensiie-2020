<?php

require "../header.php";
require '../includes/dbh.inc.php';

$id_trajet=$_POST["id_trajet"];
$id_passager = $_POST["id_conducteur"];//En faite le passager cest celui qui a créé l'annonce donc le conducteur dans la bdd


$sql = "SELECT * FROM trajet,utilisateur WHERE trajet.id_conducteur=utilisateur.id_utilisateur AND id_trajet=?";
$stmt = $conn->prepare($sql);

if($stmt == false){
	header("Location: /projet-web/index.php?error=sqlerror");
    exit();
}else{
	$stmt->execute(array($id_trajet));
	$result = $stmt->fetchAll();
    if(count($result)>0){
    	foreach($result as $row){
    		$ville_depart=$row['ville_depart'];
    		$adresse_depart=$row['adresse_depart'];
    		$cp_depart = $row['cp_depart'];
    		$cp_arrivee = $row['cp_arrivee'];
    		$adresse_arrivee=$row['adresse_arrivee'];
    		$ville_arrivee=$row['ville_arrivee'];
    		$prenom=$row['prenom'];
    		$nom=$row['nom'];
    		$jourD=$row['jour_depart'];
    		$anneeD=$row['annee_depart'];
    		$moisD=$row['mois_depart'];
    		$heureD=$row['heure_depart'];
			$minuteD=$row['minute_depart'];
			$nombrePlace=$row['nombre_place'];
		}
	}
}
?>

<link rel="stylesheet" href="/projet-web/style/afficherTrajets.css">

	<div class="container">
	<h1 style="text-align:center;">Confirmer le Covoiturage</h1>
	</div>

    <div class="container">
				<form method="POST" action="/projet-web/includes/repondre.inc.php">
				<div class="headTrajet">
				<h3 class="titreTrajet"><?php echo $ville_depart.' - '.$ville_arrivee;?></h3>
				<p class="auteurTrajet"><?php echo $prenom.' '.$nom;?></p>
				</div>

				<table class="trajetTab">
					<tr class="ligneTrajets">
						<td class="colTrajets"><b>Départ:</b> <?php echo $adresse_depart.', '.$cp_depart.' '.$ville_depart;?></td>
						<td class="colTrajets"><b>Arrivée :</b> <?php echo $ville_arrivee;?></td>
					</tr>
					<tr class="ligneTrajets">
						<td class="colTrajets"><b>Date :</b> <?php echo $jourD.' '.$moisD.' '.$anneeD; ?></td>
						<td class="colTrajets"><b>Heure :</b> <?php echo $heureD.':'.$minuteD; ?></td>
					</tr>
					<tr class="ligneTrajets">
						<td class="colTrajets"><b style="color: red;">Nombre de passager  :</b> <?php echo $nombrePlace; ?>																	  </select>
</td>
					</tr>
				</table>
				<div class="buttonWrapper">
					<input type="hidden" name="id_passager" value=<?php echo'"'.$id_passager.'"';?>>
					<input type="hidden" name="id_trajet" value=<?php echo'"'.$id_trajet.'"';?>>
					<input type="hidden" name="nbPlace" value=<?php echo'"'.$nombrePlace.'"';?>>
					<button type="submit" name="repondre" class="repondre">Confirmer</button>
				</div>
			</form>
			
	</div>