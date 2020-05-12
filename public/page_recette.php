<?php session_start(); ?>
<?php

include '../src/Recette.php';
include '../src/RecetteRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \Recette\RecetteRepository($dbAdaper);
$users = $userRepository->fetchAll();

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
        <title>EpicEvry : Recettes</title>
	    <meta name="description" content="Projet web Ensiie">
	    <meta name="author" content="Us">
	<?php include "./css_head.html" ?>
	<style>
		#titrerec {color: #26272B; text-align : center;}
		th {color : #BECFBD; }
		td {color : #FFFFFF; }
		#author {font-weight : bold; color : #FFFACD;}
		#bouton {color : #FFFFFF; background-color : #26272B; font-weight : bold; border : none;}
	</style>
</head>

<body style="background-color:#677179">
    <?php include "./header.html" ?>
	<br /><br /><br />
<div class="container">

<div class="row">
<div class="col-sm-12">
<h1 id="titrerec" >Liste des recettes</h1><br /><br />
</div>
<div class="col-sm-12">
<table class="table">
<tr>
<th>Titre de la recette</th>
<th>Difficulté</th>
<th>Temps (min)</th>
<th>Portions</th>
<th>Auteur</th>
<th>Action</th>
</tr>
<?php foreach($users as $user): ?>
<?php $auteurInfos = $userRepository->fetchInfosAuteur($user->getId_recette()); ?>
<td><?= $user->getTitre_recette() ?></td>
<td><?= $user->getDifficulte() ?></td>
<td ><?= $user->getTps_prep() ?></td>
<td ><?= $user->getNb_pers() ?></td>
<td><a id="author" href="/userprofile.php?id=<?= $auteurInfos['id'] ?>"><?= $auteurInfos['username']; ?></a></td>
<td>
<form method="POST" action="/detailsRecette.php">
<input name="recette_id" type="hidden" value="<?= $user->getId_recette() ?>">
<button id="bouton" type="submit">Voir la recette</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</table>
</div>
</div>
</div>
<br /><br /><br />
<script src="js/scripts.js"></script>
  <?php include "./footer.html" ?>
</body>
</html>
																																																																																    
