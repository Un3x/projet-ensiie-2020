<?php
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$users = $userRepository->fetchAll();
session_start();

require "voirObjet.php";


if(isset($_POST['date_Debut'])){
	
	$dateDebut=$_POST['date_Debut'];
	$dateFin=$_POST['date_Fin'];
	$idObjet=$_POST['objetId'];
	$Emprunteur=$_SESSION['id'];
//Si la date de fin est antérieur à la date de début.
	if ($dateDebut > $dateFin) 
	{  
		phpAlert("la date d'emprunt ne peut pas être avant la date de retour!"); exit();
		exit();

	}

// select les dates de début et dates de fin des empreint validé de l'objet pour vérifier que pendant les dates choisis l'ojet est disponible.
	$query_dates = $dbAdapter->prepare
	("SELECT id_emprunt, DATE_FORMAT(date_debut, '%Y-%m-%d') AS date_debut , DATE_FORMAT(date_fin, '%Y-%m-%d') AS date_fin
		FROM Objet O, Emprunt E
		WHERE O.id_obj = ?
		AND O.id_obj = E.id_obj
		ORDER BY E.date_debut");
	$query_dates->execute(array($idObjet));
	$nb=$query_dates->rowCount();

	
	while ($row = $query_dates ->fetch()){
		
		if(($dateDebut >= $row['date_debut'] && $dateDebut <= $row ['date_fin'])
			|| ($dateFin >= $row['date_debut'] && $dateFin <= $row ['date_fin']
				|| ($dateDebut <= $row['date_debut'] &&  $dateFin >= $row ['date_fin'])) ){
							//Si l'objet n'est pas disponible
			phpAlert('Cet objet ne sera pas disponible à cette date! Veuillez choisir une autre date.'); exit();
	}

} 


$reqObjet = $dbAdapter>prepare('INSERT INTO Emprunt (date_debut, date_fin, id_obj, Emprunteur) VALUES (?, ?, ?,?,\'0\')');
$reqObjet->execute(array($date_debut,$date_fin,$id_obj,$Emprunteur));
//Si la demande a été bien effectué.
phpAlert('Votre demande a été envoyée au proprietaire.');
}

else {
	
	phpAlert('Veuillez choisir  des dates pour effectuer un empreint!'); exit();
	
}
?>

<?php
	function phpAlert($msg) {
		echo '<script type="text/javascript">alert("' . $msg . '")</script>';
	}
?>
