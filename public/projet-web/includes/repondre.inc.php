<?php 
session_start();
require 'dbh.inc.php';


if(isset($_POST["repondre"])){
	$id_trajet = $_POST["id_trajet"];
	$id_passager = $_POST["id_passager"];
	$id_conducteur = $_SESSION['userId'];
	$nombrePlace = $_POST["nbPlace"];

	echo $id_trajet.'-'.$id_conducteur.'-'.$id_passager.'-'.$nombrePlace;

	$sql="INSERT INTO reservation_trajet (id_trajet,id_conducteur,id_passager,nombre_place_reserve) VALUES (?,?,?,?)";
	$stmt = $conn->prepare($sql);
	if($stmt == false){
	    //header("Location: ../nav/afficherTrajets.php?error=sqlerror");
	    //exit();
	}else{
		$stmt->execute(array($id_trajet,$id_conducteur,$id_passager,$nombrePlace));//Attention, on vas actualiser le nombre de place dans la table trajet mais pour avoir le nombre de place total initiale, il faudra faire nbrPlace+nbPlaceReservé
		
		$sql='UPDATE trajet SET nombre_place=? WHERE id_trajet=?';
		$stmt = $conn->prepare($sql);
		if($stmt == false){
	    	header("Location: ../nav/afficherTrajets.php?error=sqlerror");
            exit();
		}else{
			$stmt->execute(array(0,$id_trajet));
			header("Location: /projet-web/index.php?sucess=trajetreserve");
			exit();
		}

	}



}else{
	header("Location: /projet-web/nav/afficherTrajets.php");
	exit();
}