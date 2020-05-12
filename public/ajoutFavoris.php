<?php 

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$users = $userRepository->fetchAll();
session_start();
require "voirObjet.php";

	$new = $bdd->prepare('INSERT INTO Favori(id_Obj, id_membre) VALUES(:id_Obj, :id_membre)'); 
	$new->execute(array(':idObjet' => $_GET['idObjetFav'], ':id_membre' => $_SESSION['id']));
	echo "<script>alert(\" Cet objet a été ajouté à vos favoris \");</script>";
	echo "<script type='text/javascript'>document.location.replace('voirObjet.php?id=".$_GET['idObjetFav'].".php');</script>";
?>
