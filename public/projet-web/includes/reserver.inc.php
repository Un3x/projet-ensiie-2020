<?php 
session_start();
require 'dbh.inc.php';
$id_trajet = $_POST["id_trajet"];
$id_conducteur = $_POST["id_conducteur"];

if(isset($_POST["submit_commentaire"])){
	    
	    //require '../nav/afficherTrajets.php';
	    




	    if(empty($_POST['commentaire'])){
	    	header("Location: ../includes/confirmer-reservation.php?error=emptyfields");
	    }
	    else{
	    	$commentaire = $_POST['commentaire'];
	    	$id = $_SESSION['userId'];
	    	$id_trajet = $_POST['id_trajet'];


	    	$sql = "INSERT INTO commentaire(id_trajet,commentaire,id_personne) VALUES (?,?,?)";
	    	$stmt = $conn->prepare($sql);
	    	if($stmt == false){
            	header("Location: ../nav/confirmer-reservation.php?error=sqlerror");
            exit();
        	}
        	else{
        		$stmt->execute(array($id_trajet,$commentaire,$id));
        		header("Location:../nav/confirmer-reservation.php?succes=comment&id_trajet=".$id_trajet."&id_conducteur=".$id_conducteur);
        	}

	    }
}else if(isset($_POST["reserver"])){

	$id_passager = $_SESSION['userId'];
	$nombrePlaceTotal = $_POST["nbPlace"];
	$nombrePlaceAReserver = $_POST["nbPlaceReserver"];


	$sql4 = "SELECT mail FROM utilisateur WHERE id_utilisateur=?";
	$stmt4 = $conn->prepare($sql4);
	if($stmt4==false){
           header("Location: ../nav/confirmer-reservation.php?error=sqlerror");
	}else{
		$stmt4->execute(array($id_passager));
		$mail = $stmt4->fetch();
	}

	echo $id_trajet.'-'.$id_conducteur.'-'.$id_passager.'-'.$nombrePlaceTotal.'-'.$nombrePlaceAReserver;

	//création du code du trajet pour la vérif
	$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHYJKLMNOPQRSTUVWXYZ+-*/$!?';
	$longueurKey = 5;
	$key ="";
	for($i=1;$i<$longueurKey;$i++){
		$key .= $chars[rand(0, strlen($chars)-1)];
	}

	$sql="INSERT INTO reservation_trajet (id_trajet,id_conducteur,id_passager,nombre_place_reserve,trajet_key) VALUES (?,?,?,?,?)";
	$stmt = $conn->prepare($sql);
	if($stmt == false){
	    header("Location: ../nav/afficherTrajets.php?error=sqlerror");
	    exit();
	}else{

		$stmt->execute(array($id_trajet,$id_conducteur,$id_passager,$nombrePlaceAReserver,$key));//Attention, on vas actualiser le nombre de place dans la table trajet mais pour avoir le nombre de place total initiale, il faudra faire nbrPlace+nbPlaceReservé
		

		$header="MIME-Version: 1.0\r\n";
		$header.='From:"AllezRetour.fr"<allezretour@gmail.com>'."\n";
		$header.='Content-Type:text/html; charset="uft-8"'."\n";
		$header.='Content-Transfer-Encoding: 8bit';

		$message= '
		<html>
			<head>
				Bonjour,
			</head> 
			<body>
			voici votre code: "'.$key.'".Il faudra le  rentrer une fois le trajet réalisé dans la rubrique "Confirmation trajet".
			</body>
		<html>';
		mail($mail['mail'], "Code de validation",$message, $header);


		$sql='UPDATE trajet SET nombre_place=? WHERE id_trajet=?';
		$stmt = $conn->prepare($sql);
		if($stmt == false){
	    	header("Location: ../nav/afficherTrajets.php?error=sqlerror");
	    	exit();
		}else{
			$stmt->execute(array($nombrePlaceTotal-$nombrePlaceAReserver,$id_trajet));
			header("Location: /projet-web/index.php?sucess=trajetreserve&mail=".$mail['mail']);
			exit();
		}

	}



}else{
	header("Location: /projet-web/nav/afficherTrajets.php");
	exit();
}

 ?>
 