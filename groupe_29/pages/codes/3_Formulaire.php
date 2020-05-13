<?php

//on démarre la session
session_start();

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title> Informations complémentaires </title>
		<link rel="stylesheet" type="text/css" href="../mises_en_pages/Formulaire.css">
	</head>
	<body>
		<div class="topbar">

		    <a href="1_Page_1.php">Accueil</a>
			<a href="2_Inscription.html">Inscription</a>
			<a class="actif" href="3_Formulaire.php">Formulaire</a>
		    <a href="informations.html">Informations</a>
        </div>
	<div class="form">
		<form method = "post" action = "./pages_traitements/3_traitement_formulaire.php">
		<fieldset>
		<legend><span class="number">1</span>Votre profil actuel </legend>
			prénom : <?php print_r($_SESSION["prenom"]); ?> <br/>
			nom : <?php print_r($_SESSION["nom"]); ?> <br/>
			pseudo : <?php print_r($_SESSION["pseudo"]); ?> <br/>
			date de naissance : <?php print_r($_SESSION["date_naissance"]); ?> <br/>
			ville de résidence : <?php print_r($_SESSION["ville"]); ?>
		<br/>

		<legend><span class="number">2 </span>Infomations supplémentaires</legend>
			
			<input type="text" name="association1" placeholder="Associations"/>
			<input type="text" name="sports" id = "sports1" placeholder="Sports" /> <br>
			En club ? <br/>
			<select name = "club1"  id = "club1" >
				<option value="oui" id="oui"> Oui </option>
				<option value="non" id="non"> Non </option>
			</select>
			<br/>
			
			Quel niveau ? <br>
			<select name="nivSportif" id = "nivSportif1">
				<option value="deb"> Débutant </option>
				<option value="moy"> Moyen </option>
				<option value="conf"> Confirmé </option>
				<option value="pro"> Professionel </option>
			</select>
			<br/>
				
			Aimez-vous lire ? 
			<select name = "aimer_lire"  id = "aimer_lire" >
				<option value="oui" id="oui"> Oui </option>
				<option value="non" id="non"> Non </option>
			</select>
			<br/>

			Aimez-vous voyager ? 
			<select name = "aimer_voyager"  id = "aimer_voyager" >
				<option value="oui" id="oui"> Oui </option>
				<option value="non" id="non"> Non </option>
			</select>
			<br/>


			Situations amoureuse : <br>
			<select name="situation_amoureuse" id = "en couple">
				<option value="en couple"> En couple </option>
				<option value="célibataire"> Célibataire </option>
				<option value="Marié"> Marié(e) </option>
				<option value="compliqué"> C'est compliqué </option>
			</select>
			<br/>

			Relation recherchée : <br>
			<select name="relation_rechercher" id = "Rrecherche">
				<option value="serieux"> Serieux </option>
				<option value="libre"> Libre </option>
			</select>

			<br/>
			Orientation sexuelle : <br/>
			<select name="osexe" id="osexe">
				<option value="femme" > Femmes </option>
				<option value="homme"> Hommes</option> 
				<option value= "bi"> Les deux </option>
				<option value= "aucun"> Aucun </option>
			</select>
			<br/>


		
		<input type="submit" value="Valider" />
		</form>
	</div>
	
	

	</body>
</html>