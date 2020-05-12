<!DOCTYPE HTML>
<?php

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Aliment.php';
include '../src/AlimentRepository.php';
include '../src/Recette.php';
include '../src/RecetteRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$users = $userRepository->fetchAll();
$alimentRepository = new \Aliment\AlimentRepository($dbAdaper);
$aliments = $alimentRepository->fetchall();
$recetteRepository = new \Recette\RecetteRepository($dbAdaper);
$recette = $recetteRepository->fetchall();
session_start();

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>EpicEvry</title>

    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Us">
    <?php include "./css_head.html" ?>
</head>

	<style>
		h2 {color: #26272B; text-align : center;}
		th {color : #BECFBD; text-align: center;}
		td {color : #FFFFFF; text-align: center; }
		p {color : #FFFFFF; }
		#bouton {color : #FFFACD; font-weight : bold;}
		button {background-color : transparent; border : none;}

	</style> 

<body style="background-color: #677179">
<?php include "./header.html" ?>
</br>
</br>

<?php $recette = $recetteRepository->fetchRecette($_POST['recette_id']); ?>

<?php if (empty($recette)):
$erreur="recetteUnknown";
header("Location: index.php?erreur={$erreur}");
endif ?>
<?php $auteurInfos = $recetteRepository->fetchInfosAuteur($recette->getId_recette()); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
	<div class="title-table">
	    <h2><?=$recette->getTitre_recette()?></h2>
        </div>
</br>
	<table class="table">
	<tr>
		    <th>Difficulté</th>
                    <th>Temps de préparation</th>
		    <th>Nombre de personne</th>
		    <th>Auteur</th>
        </tr>
	<tr>
                        <td><?= $recette->getDifficulte() ?></td>
			<td><?= $recette->getTps_prep() ?></td>
			<td><?= $recette->getNb_pers() ?></td>
			<td><button><a id="bouton" href="userprofile.php?id=<?= $auteurInfos['id']?>"><?= $auteurInfos['username'] ?></a></button></td>
        </tr>
	</table>
	</div>

	<div class="col-sm-12">
	  <div class="title-table">
	    
	   <h2> Des ingrédients que vous trouverez chez nous pour cette recette</h2>
</br>
	    <?php $aliments = $recetteRepository->getDetailsRecette($_POST['recette_id']); ?>
        </div>
	<table class="table">
	<tr>
		    <th>Aliment</th>
                    <th>Quantité</th>
        </tr>
	<?php foreach($aliments as $alimentInfos): ?>
	<?php $aliment = $alimentRepository->fetchAliment($alimentInfos[0]) ?>
	<tr>
		<td><?= $aliment->getNom_aliment() ?></td>
		<td><?= $alimentInfos[1] ?> g </td>
	</tr>
	<?php endforeach; ?>
	</table>
	</div>

<div class="col-sm-12">
	<div class="title-table">
	  <fieldset style="border: 2px #BECFBD solid; padding: 0 10px;">

	    <legend style="border: 2px #BECFBD solid;margin-left: 1em; padding: 0.2em 0.8em ">
	  Préparation</legend>
        
</br>
	<p> <?= $recette->getPreparation(); ?> </p>
	</div>
	</fieldset>
	</div>
</div>
</div>
</br>
</br>
<script src="js/scripts.js"></script>
<?php include "./footer.html" ?>
</body>

</html>
