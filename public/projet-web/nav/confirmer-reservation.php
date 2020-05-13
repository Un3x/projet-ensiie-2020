<?php

require "../header.php";
require '../includes/dbh.inc.php';

$id_utilisateur = $_SESSION['userId'];


if (isset($_GET["id_trajet"]) AND !empty($_GET["id_trajet"])) {
	$id_trajet=$_GET["id_trajet"];
	$id_conducteur = $_GET["id_conducteur"];
}



if (isset($_POST["reserver"])) {
	$id_trajet=$_POST["id_trajet"];
	$id_conducteur = $_POST["id_conducteur"];
}



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


$sql2 = "SELECT nom,prenom,commentaire FROM commentaire,utilisateur WHERE utilisateur.id_utilisateur = commentaire.id_personne AND id_trajet=?";
$stmt2 = $conn->prepare($sql2);

if($stmt2 == false){
	header("Location: /projet-web/index.php?error=sqlerror");
	exit();
}
else{
	$stmt2->execute(array($id_trajet));
}
?>




<link rel="stylesheet" href="/projet-web/style/afficherTrajets.css">

	<div class="container">
	<h1 style="text-align:center;">Confirmer la Réservation</h1>
	</div>

	<div class="container">
				<form method="POST" action="/projet-web/includes/reserver.inc.php">
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
						<td class="colTrajets"><b style="color: red;">Nombre de passager  :  </b> <select name="nbPlaceReserver">
						<?php 
							for ($i=1; $i < ($nombrePlace+1); $i++) { 
								echo '<option valeur="'.$i.'">'.$i.'</option>';
							}	 
						  ?>
						  </select>
</td>
					</tr>
				</table>
				

				<div class="buttonWrapper">
					<input type="hidden" name="id_conducteur" value=<?php echo'"'.$id_conducteur.'"';?>>
					<input type="hidden" name="id_trajet" value=<?php echo'"'.$id_trajet.'"';?>>
					<input type="hidden" name="nbPlace" value=<?php echo'"'.$nombrePlace.'"';?>>
					<button type="submit" name="reserver" class="repondre" <?php if($id_conducteur == $id_utilisateur){?> disabled <?php }?>>Réserver</button>
					<input type="hidden" name="id_trajet" value=<?php echo'"'.$id_trajet.'"';?>>
					
				</div>
			

			<div>
					<h3>Commentaires</h3>
					<br /><ul class="chatbox"><?php while($c = $stmt2->fetch()){ ?>
						
							<li class="chatline">
								<b><?php echo $c['nom'].' '.$c['prenom'].': </b>'.$c['commentaire']?>
							</li>
						

					<?php } ?>
					</ul>
					<textarea class="comArea" type="text" name="commentaire" placeholder="Entrez votre commentaire"></textarea>
			</div>
				<button type="submit" name="submit_commentaire" class="repondre">Commenter</button>
				</form>
	</div>




<?php

require "../footer.php";

?>