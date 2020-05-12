<!DOCTYPE HTML>
<?php

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Aliment.php';
include '../src/AlimentRepository.php';
include '../src/Commande.php';
include '../src/CommandeRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$userRepository = new \User\UserRepository($dbAdaper);
$users = $userRepository->fetchAll();

$alimentRepository = new \Aliment\AlimentRepository($dbAdaper);
$aliments = $alimentRepository->fetchall();

$commandeRepository = new \Commande\CommandeRepository($dbAdaper);
$commandes = $commandeRepository->fetchall();

session_start();

$commande = $commandeRepository->fetchCommande($_POST['commande_id']); //Récupération de l'objet commande
$user_username = $commandeRepository->associatedClient($commande->getId()); //récupération du nom de l'utilisateur (unique)
?>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Détails de commande</title>

    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Us">
    <?php include "./css_head.html" ?>
</head>


	<style>
		h1 {color: #26272B; text-align : center;}
		th {color : #BECFBD; text-align: center;}
		td {color : #FFFFFF; text-align: center; }
		#bouton {color : #FFFFFF; background-color : #26272B; font-weight : bold; border : none; }
	</style> 

<body style="background-color: #677179">

  <?php include "./header.html" ?>
  <!-- On vérifie que l'utilisateur est soit un administrateur soit le commanditaire de la commande-->
  <?php if (!isset($_SESSION['id']) OR (($_SESSION['role'] != 1) AND ($user_username != $_SESSION['username'])))
	{
	  $erreur="notConnected";
	  header("Location: page_connexion.php?erreur={$erreur}");
	}
	?>

<!-- On vérifie que la commande existe -->
<?php if (empty($commande)):
$erreur="commandeUnknown";
header("Location: page_gestion_admin.php?erreur={$erreur}");
      endif ?>

<!-- Affichage des informations principales de la commande -->
<div class="container">
    <div class="row">
        <div class="col-sm-12">
	<div class="title-table"><br /><br /><br />
	    <h1>Commande n° : <?= $_POST['commande_id']?></h1><br />
        </div>
	<table class="table">
	<tr>
		    <th>date_livraison</th>
                    <th>prix total</th>
		    <th>Client</th>
        </tr>
	<tr>
                        <td><?= $commande->getDateLivraison() ?></td>
			<td><?= $commande->getPrixTotal() ?></td>
			<td><?= $commandeRepository->associatedClient($commande->getId()) ?></td>
        </tr>
	</table>
	</div>

	<!-- Affichage des aliments contenus dans la commande -->
	<div class="col-sm-12">
	<div class="title-table">
	  <h1>Aliments commandés</h1><br />
	  <!-- Récupération de la liste des aliments dans la base de donnée via l'objet CommandeRepository -->
	    <?php $aliments = $commandeRepository->getDetailsCommande($_POST['commande_id']); ?> 
        </div>
	<table class="table">
	<tr>
		    <th>Aliment</th>
                    <th>Quantité</th>
		    <th>Sous total</th>
        </tr>
	<!-- Boucle sur les aliments dans la commande -->
	<?php foreach($aliments as $alimentInfos): ?>
	<!-- Récupération de l'objet Aliment associé -->
	<?php $aliment = $alimentRepository->fetchAliment($alimentInfos[0]) ?>
	<tr>
		<td><?= $aliment->getNom_aliment() ?></td>
		<td><?= $alimentInfos[1] ?> kg </td>
		<td><?= $aliment->getPrix_aliment() * $alimentInfos[1] ?> € </td>
	</tr>
	<?php endforeach; ?>
	</table>
	</div>
	<!-- Supression de la commande -->
                            <form method="POST" action="/deleteCommande.php">
                                <input name="commande_id" type="hidden" value="<?=  $_POST['commande_id']?>">
                                <button id="bouton" type="submit">Supprimer</button>
                            </form>
    </div>
</div>
<br /><br /><br />
<?php include "./footer.html" ?>
</body>
</html>
