<!DOCTYPE html>
<?php

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Recette.php';
include '../src/RecetteRepository.php';
include '../src/Commande.php';
include '../src/CommandeRepository.php';
  
include '../src/Factory/DbAdaperFactory.php';

session_start();

$dbAdaper = (new DbAdaperFactory())->createService();

$userRepository = new \User\UserRepository($dbAdaper);
$user = $userRepository->fetchUser($_GET['id']); //Récupère l'objet User correspondant à l'utilisateur dont on vitsite le profil

$recetteRepository = new \Recette\RecetteRepository($dbAdaper);
$recettes = $recetteRepository->fetchByAuteur($user->getId()); //Récupère la liste des recettes écrites par l'utilisateur dont on visite le profil sous forme d'une liste d'objet Aliment

$commandeRepository = new \Commande\CommandeRepository($dbAdaper);
$commandes = $commandeRepository->fetchByUser($user->getId()); //Récupère la liste des commandes de l'utilisateur dont on visite le profil sous forme d'une liste d'objet Commande
?>

<html>
<head>
	<title>EpicEvry</title>
	<meta charset="utf-8">
	<?php include "css_head.html" ?>
	<style>
		#profile {font-weight : bold; text-align : center; color : #26272B; font-size : 50px;}
		.data1 {font-weight : bold; margin-left: 530px; color : #BECFBD;}
		.data2 {font-weight : bold; margin-left : 520px; color : #FFFACD;}
		.author {text-align : center; color : #26272B; font-weight : bold; font-size : 30px;}
		th {color : #BECFBD; text-align:center; }
		td {color : #FFFFFF; text-align:center;}
		.bouton {color : #FFFFFF; background-color : #26272B; font-weight : bold; border : none; margin: 10px 530px;}
		.bouton2 {color : #FFFFFF; background-color : #26272B; font-weight : bold; border : none; }

		#edit {color : #87CEEB; margin-left : 520px;}
		#publish {color : #87CEEB;}
		#bar {color : #87CEEB;}
		#warning {text-align : center; font-weight : bold; color : ##26272B;}
		
	</style>
</head>
<body style="background-color:#677179">
<?php include "header.html" ?>
<br /><br /><br /><br /><br />
	<div>
		<h1 id="profile">Profil utilisateur</h1>
		<br /><br />
		<table class="table">
		  <tr>
		    <th>Prénom</th>
		    <th>Nom</th>
		    <th>Pseudo</th>
		    <th>E-mail</th>
		  </tr>
		  <tr>
		    <td data-th="Prénom">
		      <?php if(empty($user->getPrenom())):
		       	       echo "Non renseigné";
			       else:
			       echo $user->getPrenom();
			       endif;?> </td>
		    <td data-th="Nom">
		      <?php if(empty($user->getNom())):
		       	       echo "Non renseigné";
			       else:
			       echo $user->getNom();
			       endif;?>		    </td>
<td data-th="Pseudo">
<?php  echo $user->getUsername(); ?>
</td>
<td data-th="E-mail">
<?php echo $user->getEmail(); ?>
</td>
		  </tr>
</table>
		  </br></br>
<?php
		if(isset($_SESSION['id']) AND $user->getId() == $_SESSION['id'])
		{
?>


<p ><a href="userprofileedition.php" class="bouton"><i class="fa fa-th"></i> Éditer mon profil </a></p>

<p ><a href="recetteedition.php" class="bouton" ><i class="fa fa-th"></i> Publier une recette </a></p>


			<?php
		}
		  ?>
		<br /><br />
		
<!-- Affichage des recettes -->
<div class="row">
  <div class="col-sm-12">
    <h2  class="author">Auteur des recettes</h2><br />
  </div>
  <div class="col-sm-12">
  <!-- On vérifie que l'utilisateur à bien écrit des recettes -->
  <?php if(!empty($recettes)): ?>
    <table class="table">
      <tr>
	<th>Titre de la recette</th>
	<th>Difficulté</th>
	<th>Temps de préparation</th>
	<th>Nombre de personnes</th>
	<th>Action</th>
      </tr>
      <!-- Boucle sur les recettes de l'auteur récupéré dans la base de donéées-->
      <?php foreach($recettes as $recette): ?>
      <tr>
	      <td><?= $recette->getTitre_recette() ?></td>
	      <td><?= $recette->getDifficulte() ?></td>
	      <td><?= $recette->getTps_prep() ?></td>
	      <td><?= $recette->getNb_pers() ?></td>
	      <td>
		<!-- Détails de la recette -->
		<form method="POST" action="/detailsRecette.php">
		  <input name="recette_id" type="hidden" value="<?= $recette->getId_recette() ?>">
			  <button class="bouton2" type="submit">Voir la recette</button>
		</form>
	      </td>
      </tr>
      <?php endforeach; ?>
    </table>
    
    <!-- Affichage si l'utilisateur n'a pas écrit de recettes -->
    <?php else: ?>
    <p id="warning" >N'a actuellement posté aucune recette.</p>
    <?php endif; ?>
    
  </div>
</div>
<br /><br />

<!-- Pour afficher les commandes l'utilisateur du profil doit être connecté -->
<?php if(isset($_SESSION['id']) AND $user->getId() == $_SESSION['id']): ?>
<div class="row">
  <div class="col-sm-12">
    <h2 class="author">Commandes en cours</h2><br />

    <!-- On vérifie que l'utilisateurs à des commandes en cours-->
    <?php if(!empty($commandes)): ?>
    <div class="col-sm-12">
      <table class="table">
                <tr>
                    <th>Numéro de commande</th>
		    <th>Date de livraison</th>
                    <th>Prix total</th>
		    <th>Client</th>
		    <th>Action</th>
                </tr>

		<!-- Boucle sur les commandes de l'utilisateur trouvées dans la bdd-->
                <?php foreach($commandes as $commande): ?>
                    <tr>
                        <td><?= $commande->getId() ?></td>
                        <td><?= $commande->getDateLivraison() ?></td>
			<td><?= $commande->getPrixTotal() ?></td>
			<td><?= $commandeRepository->associatedClient($commande->getId()) ?></td>
                        <td>
			  <!-- Supprimer la commande-->
                            <form method="POST" action="/deleteCommande.php">
                                <input name="commande_id" type="hidden" value="<?= $commande->getId() ?>">
                                <button class="bouton2" type="submit">Supprimer</button>
                            </form>

			  <!-- Détails de la commande -->
			    <form method="POST" action="/detailsCommande.php">
			    	   <input name="commande_id" type="hidden" value="<?= $commande->getId() ?>"><br />
                                <button class="bouton2" type="submit">Détails</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
    </table>
    </div>
    <?php else: ?>

    <!-- Message si l'utilisateur n'a pas de commande en cours -->
    <p id="warning">Aucune commande </p>

    <?php endif; ?>
     </div>
</div>
<?php endif ?>
<br /><br /><br />
<?php include "footer.html" ?>
</body>
</html>
