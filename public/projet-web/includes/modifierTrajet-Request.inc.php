<?php


if (isset($_POST["supprimer"])){
	require 'dbh.inc.php';
	$id_trajet = $_POST["id_trajet"];
	$sql='DELETE FROM trajet WHERE id_trajet=?';

	$stmt = $conn->prepare($sql);
    if($stmt == false){
        header("Location: ../nav/monCompte.php?error=sqlerror");
        exit();
    }else{
        $stmt->execute(array($id_trajet));
        header("Location: ../nav/monCompte.php?success=trajetsupprime");
        exit();
    }
	
}

if(isset($_POST["modifier"])){
	$id_trajet = $_POST["id_trajet"];
	$id_conducteur= $_POST["id_conducteur"];
	header("Location: /projet-web/nav/modifierTrajet.php?id_trajet=".$id_trajet."&id=".$id_conducteur);
	exit();
}

header("Location: /projet-web/index.php");
exit();

