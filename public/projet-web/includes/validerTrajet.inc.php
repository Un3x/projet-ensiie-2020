<?php
session_start();
require 'dbh.inc.php';

if(isset($_POST['validerCode'])){
	$code = $_POST['code'];
	$codeValide = $_POST['trajet_code'];
	$id_trajet = $_POST['id_trajet'];
	$id_passager = $_SESSION['userId'];
	$placeReserve= $_POST['place'];

	$sql3 = "SELECT nombre_place_validee FROM trajet WHERE id_trajet=?";
	$stmt3= $conn->prepare($sql3);
	if($stmt3==false){
		header("Location: ../nav/monCompte.php#confirmer?error=sql");
	}else{
		$stmt3->execute(array($id_trajet));
		$placeActuelleValide = $stmt3->fetch();
	}
	


	if($code!=$codeValide){
		header("Location: ../nav/monCompte.php#confirmer?error=mauvaiscode");
		exit();
	}else{
		$sql= 'UPDATE reservation_trajet SET confirm_trajet=? WHERE id_trajet=? AND id_passager=?';
		$stmt = $conn->prepare($sql);
		if ($stmt==false) {
		header("Location: ../nav/monCompte.php#confirmer?error=sql");
		}else{
			$stmt->execute(array($code,$id_trajet,$id_passager));


			$placeValide = $placeReserve + $placeActuelleValide['nombre_place_validee'];

			$sql2= 'UPDATE trajet SET nombre_place_validee=? WHERE id_trajet=?';
			$stmt2 = $conn->prepare($sql2);
			if($stmt2==false){
				header("Location: ../nav/monCompte.php#confirmer?erreur=sql");

			}else{
			 	$stmt2->execute(array($placeValide,$id_trajet));
				header("Location: ../nav/monCompte.php#confirmer?success&placevalide=".$placeValide);
			}

		}
	}
}


?>