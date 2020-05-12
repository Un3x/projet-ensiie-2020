<?php
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Commande.php';
include '../src/CommandeRepository.php';
include '../src/Factory/DbAdaperFactory.php';
session_start();

$dbAdaper = (new DbAdaperFactory())->createService();
$commandeRepository = new \Commande\CommandeRepository($dbAdaper);

if(!isset($_SESSION['id'])):
{
	header('Location: page_connexion.php?erreur=notConnected');
}
endif;

$idcommande = $commandeRepository->addCommande($_POST); //Création de la nouvelle commande

$ids= array_keys($_SESSION['panier']);

//Boucle sur tout les aliments du panier
foreach($ids as $id) {
$commandeRepository->addAlimentToCommande($idcommande,$id, $_SESSION['panier'][$id]); //Ajout de l'aliment à la commande
}
$_SESSION['panier'] = []; //On vie de la panier après le passage de la commande
header("Location: index.php");
?>