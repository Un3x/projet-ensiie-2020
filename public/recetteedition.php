<!DOCTYPE html>
<?php
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Recette.php';
include '../src/RecetteRepository.php';
include '../src/Factory/DbAdaperFactory.php';
session_start();
?>

<html>
<head>
	<title>Publier une recette</title>
	<meta charset="utf-8">
	<?php include "css_head.html" ?>
	<style>
		
		#bouton {font-weight : bold; margin-left : 625px; color : #FFFFFF; background-color : #26272B; border : none;}

		input[type=submit] {
		width: 150px;
		padding: 10px;
		}

		label {
		width: 110px;
		display: inline-block;
		vertical-align: top;
		margin: 6px;
		}

		em {
		font-weight: bold;
		font-style: normal;
		color: #f00;
		}

		input:focus {
		background: #eaeaea;
		}

		input, textarea {
		width: 449px;
		height: 40px;
		}

		textarea {
		height: 150px;
		}

		select {
		width: 454px;
		height: 40px; }

		h1 {
		text-align: center;
		font-weight: bold;}

	</style>
</head>

<body style="background-color:#677179">
<?php include "header.html" ?>

<!-- On vérifie que l'utilisateur est connecté -->
<?php if(!isset($_SESSION['id'])):
header("Location: page_connexion.php?erreur=notConnected");
      endif;?>

	
		<br /><br /><br />
<center>
		
	 <h2> Ecrire une recette</h2>
</center>
		<br /><br />
		<center>
		  <!-- Formulaire de publication de la recette -->
		  <form id="recette" method="POST" action="addrecette.php">

		    <!-- Titre -->
		    <label for="nom">Titre <em>*</em></label>
		    <input type="text" id="nom" placeholder="Titre de votre recette" name="titre_recette" autofocus="" required=""></br></br>
		    
		    <!-- Difficulté -->
		    <label for="difficulte">Difficulté </label>
		    <select id="difficulte" name="difficulte">
			    <option value="Facile" name="difficulte">Facile</option>
			    <option value="Intermediaire" name="difficulte">Intermédiaire</option>	    
			    <option value="Difficile" name="difficulte">Difficile</option>
		    </select></br></br>

		    <!-- Temps de préparation -->
	  	    <label for="tps_prep">Temps de preparation <em>*</em></label>
		    <input id="tps_prep" type="number" name="tps_prep"  pattern="[0-9]{2}" required=""></br>

		    <!-- Nombre de personnes -->
		    <label for="nb_pers">Nombre de personnes <em>*</em></label>
		    <input id="nb_pers" type="number" name="nb_pers" pattern="[0-9]{2}" required=""></br>

		    <!-- Préparation -->
		    <label>Preparation <em>*</em></label>
		    <textarea class="yellow" form="recette" type="text" name="preparation" required></textarea><br /><br />
		    
		    <input type="hidden" name="id_auteur" value=<?= $_SESSION['id'] ?> >
		    <br />
		    <!-- Publier -->
		    <input id="bouton" type="submit" value="Publier la recette" />
		</form>
</center>
		
	<br /><br />
<?php include "footer.html" ?>
</body>
</html>
