<!DOCTYPE html>
<?php
include '../src/User.php';
include '../src/UserRepository.php';
  
include '../src/Recette.php';
include '../src/RecetteRepository.php';

include '../src/Factory/DbAdaperFactory.php';

include '../src/Aliment.php';
include '../src/AlimentRepository.php';
session_start();

$dbAdaper = (new DbAdaperFactory())->createService();
$recetteRepository = new \Recette\RecetteRepository($dbAdaper);
$alimentRepository = new \Aliment\AlimentRepository($dbAdaper);
?>

<html>
<head>
	<title>Publier une recette</title>
	<meta charset="utf-8">
	<?php include "css_head.html" ?>
	<style>
		label {color : #BECFBD; text-align: center; font-weight : bold;}
		.bouton {color : #FFFFFF; background-color : #26272B; font-weight : bold; border : none; }
		.space {background-color : #FFFACD;}
		#mes {text-align:center;}
		.h1 {text-align : center; }
	</style>
</head>

<body style="background-color: #677179">
<?php include "header.html" ?>

<!-- Vérification que l'utilisateur est connecté -->  
<?php if(!isset($_SESSION['id'])):
header("Location: page_connexion.php?erreur=notConnected");
      endif;?>
<!-- Vérification que l'on provient bien de la page recetteedition.php -->
<?php if(!isset($_POST['last_recette'])):
header("Location: recetteedition.php");
      endif;?>

	<div align="center"><br /><br />
		<h1>Ajoutez les légumes de votre recette</h1><br /><br />
		<div align="left">
		  <center>
		  <!-- Formulaire d'ajout de légume -->
		  <form id="leg" method="POST" action="addlegume.php">
			<label>Nom du légume :</label>
			<input class="space" type="text" name="nom_legume" required><br /><br />
			<label>Quantité (en grammes) :</label>
			<input class="space" type="number" name="qte" required><br /><br />

			<input type="hidden" name="id_auteur" value=<?= $_SESSION['id'] ?> >
			<input type="hidden" name="id_recette" value=<?= $_POST['last_recette'] ?> >
			<input class="bouton" type="submit" value="Ajouter legume" />
		  </form>

		<!-- Teminer l'éditon de la recette -->  
		<form action="page_recette.php"><br />
			<input class="bouton" type="submit" value="Terminer" />
		</form>
                </centre>
		</div>
	</div>

	<div class="col-sm-12">
	  <div class="title-table"><br />
	   <!-- Affichage des aliments déjà ajouté à la recette -->
	   <center> <h1>Ingrédients</h1> </center></br>
	    <?php $aliments = $recetteRepository->getDetailsRecette($_POST['last_recette']); ?>
          </div>
	  
	<!-- Vérification que la recette contient des aliments -->
	<?php if(!empty($aliments)): ?>
	<table class="table">
	<tr>
		    <th>Aliment</th>
                    <th>Quantité</th>
        </tr>
	<!-- Boucle sur tout les aliments déjà ajoutés à la recette -->
	<?php foreach($aliments as $alimentInfos): ?>
	<?php $aliment = $alimentRepository->fetchAliment($alimentInfos[0]) ?>
	<tr>
		<td><?= $aliment->getNom_aliment() ?></td>
		<td><?= $alimentInfos[1] ?> g </td>
	</tr>
	<?php endforeach; ?>
	</table>
	
	<!-- Si il n'y à pas d'ingrédients -->
	<?php else: ?>
	<p id="mes">Il n'y a aucun ingrédient dans votre recette.</p>
	<?php endif; ?>
	</div><br /><br />
	
<?php include "footer.html" ?>
</body>
</html>
