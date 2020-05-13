<?php
if (isset($_POST['demanderTrajet'])){ //vérifier que on a bien cliquer sur proposer un trajet pour y accéder
	session_start();
	require 'dbh.inc.php'; //vérifie qu'on est bien connecté à la db

	// On récupère les données du formulaire d'inscription

	$jourD = $_POST['jour'];
	$moisD = $_POST['mois'];
	$anneeD = $_POST['annee'];
	$heureD = $_POST['heure'];
	$minuteD = $_POST['minute'];
	$nombrePlace = $_POST['nombre'];
	$villeD = $_POST['ville1'];
	$villeA = $_POST['ville2'];
	$cpD = $_POST['cp1'];
	$cpA = $_POST['cp2'];
	$adresseD = $_POST['adresse1'];
	$adresseA = $_POST['adresse2'];
	$longitudeD = $_POST['lon1'];
	$longitudeA = $_POST['lon2'];
	$lattitudeD = $_POST['lat1'];
	$lattitudeA = $_POST['lat2'];
	$idConducteur = $_SESSION['userId'];
	$type = 'demande';
	

	//On vérifie que les champs ont été remplient et sinon on renvoie l'utilisateur sur la page, en lui permettant de récupérer les champs qu'il avait déjà rentrer


	if(empty($jourD) || 
	   empty($moisD) || 
	   empty($anneeD) || 
	   empty($heureD) || 
	   empty($minuteD) || 
	   empty($nombrePlace) || 
	   empty($villeD) || 
	   empty($villeA) || 
	   empty($cpD) || 
	   empty($cpA) || 
	   empty($adresseA) || 
	   empty($adresseD) ||
	   empty($longitudeD) ||
	   empty($longitudeA) ||
	   empty($lattitudeD) ||
	   empty($lattitudeA)
	){
		header("Location: ../demanderTrajet.php?error=emptyfields");
		exit();
	}
	
        else{
        	$sql= "INSERT INTO  trajet(adresse_arrivee,adresse_depart,annee_depart,cp_arrivee,cp_depart,heure_depart,id_conducteur,jour_depart,minute_depart,mois_depart,nombre_place,type,ville_arrivee,ville_depart,longitude_depart,longitude_arrivee,lattitude_depart,lattitude_arrivee) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$stmt = $conn->prepare($sql);
			
			if($stmt == false){
            	header("Location: ../nav/demanderTrajet.php?error=sqlerror");
            exit();
        	}
        	else{
            	$stmt->execute(array($adresseA,$adresseD,$anneeD,$cpA,$cpD,$heureD,$idConducteur,$jourD,$minuteD,$moisD,$nombrePlace,$type,$villeA,$villeD,$longitudeD,$longitudeA,$lattitudeD,$lattitudeA));

            	header("Location: ../nav/demanderTrajet.php?demanderTrajet=success");
            exit();
        }
    }
    $stm=null; //Fermeture de la connexion à la bd
	$conn=null;

}
else{
	header("Location: /projet-web/index.php"); //Dans le cas où l'user n'arrive pas sur cette page grâce au bouton proposer un trajet on le redirige vers la page principale
    exit();
}


?>