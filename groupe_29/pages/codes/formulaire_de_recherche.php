<?php
session_start();
?>

<!DOCTYPE html>

<html>
	<head>
    <meta charset = "utf-8">
		<title>Rechercher</title>
		<link rel="stylesheet" type="text/css" href="../mises_en_pages/recherche.css">
	</head>
	<body>
		<div class="topbar">
		    <a href="1_Page_1.php">Accueil</a>
            <a class="actif" href="formulaire_de_recherche.php">Rechercher un ami</a>
            <a href="Profil.php">Mon profil</a> 
            <a href="deconnexion.php" class="param">Déconnexion</a>
		</div> 
		<div class="logo" >
		<center>

		<img src="../mises_en_pages/friends.png">

		</center>
        <div class="form">

		<form method="POST" action="./pages_traitements/recherche.php">

			<input type="text" name="pseudo" class ="rechfond" placeholder="Pseudo">

			<input type="text" name="surname" class ="rechfond" placeholder="surname ?">

			<input type="text" name="firstname" class ="rechfond" placeholder="firstname ?">

			<input type="text" name="asso" class ="rechfond" placeholder="Est dans quelle asso ?"><br/><br/>

			
			Aime lire ?
			<select name="Aime_lire" id = "Aime lire ?">
				<option>  </option>
				<option value="oui"> Oui </option>
				<option value="non"> Non </option>
			</select>
			
			Aime voyager ?
			<select name="Aime_voyager" id = "Aime voyager ?">
			<option>  </option>
				<option value="oui"> Oui </option>
				<option value="non"> Non </option>
			</select>
			<br/><br/>


			<input type="submit" name="form" class ="boutonfond" value="Search">

        </div>
		</form>
	</body>
</html>
