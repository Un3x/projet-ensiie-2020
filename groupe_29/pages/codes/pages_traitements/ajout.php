<?php

session_start();

try {
	/*$conn_string = "host=localhost port=5432 dbname=ipw user=cao_caroline password=123"; */
	$conn_string = "host=localhost port=5432 dbname=projet_web user=lauriane password=lauriane";
$bdd = pg_connect($conn_string);
}

catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

if ($_POST["categorie"] == 'voyage') {	
	if (!empty(htmlspecialchars($_POST["lieu"])) || !empty(htmlspecialchars($_POST["ville"])) || !empty(htmlspecialchars($_POST["pays"])))
	{
		$query = 'INSERT INTO voyage(id, lieu, ville, pays) 
		VALUES (\''.$_SESSION["id"].'\', 
		\''.htmlspecialchars($_POST["lieu"]).'\',
		\''.htmlspecialchars($_POST["ville"]).'\', 
		\''.htmlspecialchars($_POST["pays"]).'\')';  /*requete*/

		$data = pg_query($bdd, $query); /*execution requete*/

		if ($data == false) {
			print_r(pg_last_error());	
		}
		echo "<script type = 'text/javascript'> alert('Données enregistrées !');
                                                    document.location.href = '../Profil.php';</script>";
	}
	else {
		echo "<script type = 'text/javascript'> alert('Vous enregistrez des données vides...');
                                                    document.location.href = '../Profil.php';</script>";
	}
	
}

if ($_POST["categorie"] == 'oeuvre') {
	if (!empty(htmlspecialchars($_POST["auteur"])) || !empty(htmlspecialchars($_POST["titre"])) || !empty(htmlspecialchars($_POST["type"])) || !empty(htmlspecialchars($_POST["genre"])))
	{
		$query = 'INSERT INTO lecture(id, type_oeuvre, genre_oeuvre, titre, auteurs) 
		VALUES (\''.$_SESSION["id"].'\', 
		\''.htmlspecialchars($_POST["type"]).'\',
		\''.htmlspecialchars($_POST["genre"]).'\', 
		\''.htmlspecialchars($_POST["titre"]).'\',
		\''.htmlspecialchars($_POST["auteur"]).'\')';  /*requete*/

		$data = pg_query($bdd, $query); /*execution requete*/

		if ($data == false) {
		print_r(pg_last_error());	
		}
	echo "<script type = 'text/javascript'> alert('Données enregistrées !');
													document.location.href = '../Profil.php';</script>";
	}
	else {
		echo "<script type = 'text/javascript'> alert('Vous enregistrez des données vides...');
                                                    document.location.href = '../Profil.php';</script>";
	}

}

if ($_POST["categorie"] == 'films') {
	if (!empty(htmlspecialchars($_POST["titre"])) || !empty(htmlspecialchars($_POST["type"])) || !empty(htmlspecialchars($_POST["realisateur"])))
	{
		$query = 'INSERT INTO film(id, type_film, nom_film, realisateur_film) 
		VALUES (\''.$_SESSION["id"].'\', 
		\''.htmlspecialchars($_POST["type"]).'\',
		\''.htmlspecialchars($_POST["titre"]).'\', 
		\''.htmlspecialchars($_POST["realisateur"]).'\'
		)';  /*requete*/

		$data = pg_query($bdd, $query); /*execution requete*/

		if ($data == false) {
			print_r(pg_last_error());	
		}
		echo "<script type = 'text/javascript'> alert('Données enregistrées !');
													document.location.href = '../Profil.php';</script>";
	}
	else {
		echo "<script type = 'text/javascript'> alert('Vous enregistrez des données vides...');
                                                    document.location.href = '../Profil.php';</script>";
	}
}

if ($_POST["categorie"] == 'asso') {
	if (!empty(htmlspecialchars($_POST["nom"]))) 
	{
		$query = 'INSERT INTO association(id, nom_association) 
		VALUES (\''.$_SESSION["id"].'\', 
		\''.htmlspecialchars($_POST["nom"]).'\'
		)';  /*requete*/

		$data = pg_query($bdd, $query); /*execution requete*/

		if ($data == false) {
			print_r(pg_last_error());	
		}
		echo "<script type = 'text/javascript'> alert('Données enregistrées !');
													document.location.href = '../Profil.php';</script>";
	}
	else {
		echo "<script type = 'text/javascript'> alert('Vous enregistrez des données vides...');
																								document.location.href = '../Profil.php';</script>";
	}
}

if ($_POST["categorie"] == 'sport') {
	if (!empty(htmlspecialchars($_POST["sports"])) && (!empty(htmlspecialchars($_POST["club"])) || !empty(htmlspecialchars($_POST["nivSportif"]))))
	{
		$query = 'INSERT INTO sport(id, nom_sport, club, niveau) 
		VALUES (\''.$_SESSION["id"].'\', 
		\''.htmlspecialchars($_POST["sports"]).'\',
		\''.htmlspecialchars($_POST["club"]).'\',
		\''.htmlspecialchars($_POST["nivSportif"]).'\'
		)';  /*requete*/

		$data = pg_query($bdd, $query); /*execution requete*/

		if ($data == false) {
			print_r(pg_last_error());	
		}
		echo "<script type = 'text/javascript'> alert('Données enregistrées !');
													document.location.href = '../Profil.php';</script>";
	}
	else {
		echo "<script type = 'text/javascript'> alert('Vous enregistrez des données vides...');
													document.location.href = '../Profil.php';</script>";
	}
}

if ($_POST["categorie"] == 'tel') {
	if (!empty(htmlspecialchars($_POST["num_tel"])))
	{
		$query = 'UPDATE utilisateur SET numero_tel = \''.htmlspecialchars($_POST["num_tel"]).'\' WHERE id = \''.$_SESSION["id"].'\'';
		$data = pg_query($bdd, $query); /*execution requete*/

		if ($data == false) {
			print_r(pg_last_error());	
		}
		echo "<script type = 'text/javascript'> alert('Numéro enregistrée !');
													document.location.href = '../Profil.php';</script>";
	}
	else {
		echo "<script type = 'text/javascript'> alert('Vous enregistrez des données vides...');
													document.location.href = '../Profil.php';</script>";
	}
}

if ($_POST["categorie"] == 'adresse') {
	if (!empty(htmlspecialchars($_POST["adresse"])))
	{
		$query = 'UPDATE utilisateur SET adresse = \''.htmlspecialchars($_POST["adresse"]).'\' WHERE id = \''.$_SESSION["id"].'\'';
		$data = pg_query($bdd, $query); /*execution requete*/

		if ($data == false) {
			print_r(pg_last_error());	
		}
		echo "<script type = 'text/javascript'> alert('Adresse enregistrée !');
													document.location.href = '../Profil.php';</script>";
	}
	else {
		echo "<script type = 'text/javascript'> alert('Vous enregistrez des données vides...');
													document.location.href = '../Profil.php';</script>";
	}
}


if ($_POST["categorie"] == 'ville') {
	if (!empty(htmlspecialchars($_POST["ville"])))
	{
		$query = 'UPDATE utilisateur SET ville = \''.htmlspecialchars($_POST["ville"]).'\' WHERE id = \''.$_SESSION["id"].'\'';
		$data = pg_query($bdd, $query); /*execution requete*/

		if ($data == false) {
			print_r(pg_last_error());	
		}
		echo "<script type = 'text/javascript'> alert('Ville enregistrée !');
													document.location.href = '../Profil.php';</script>";
	}
	else {
		echo "<script type = 'text/javascript'> alert('Vous enregistrez des données vides...');
													document.location.href = '../Profil.php';</script>";
	}
}

if ($_POST["categorie"] == 'email') {
	if (!empty(htmlspecialchars($_POST["email"])))
	{
		$query = 'UPDATE utilisateur SET email = \''.htmlspecialchars($_POST["email"]).'\' WHERE id = \''.$_SESSION["id"].'\'';
		$data = pg_query($bdd, $query); /*execution requete*/

		if ($data == false) {
			print_r(pg_last_error());	
		}
		echo "<script type = 'text/javascript'> alert('Adresse e_mail enregistrée !');
													document.location.href = '../Profil.php';</script>";
	}
	else {
		echo "<script type = 'text/javascript'> alert('Vous enregistrez des données vides...');
													document.location.href = '../Profil.php';</script>";
	}
}

if ($_POST["categorie"] == 'aimer_lire') {
	if (!empty(htmlspecialchars($_POST["aimer_lire"])))
	{
		$query = 'UPDATE gout SET aime_lire = \''.htmlspecialchars($_POST["aimer_lire"]).'\' WHERE id = \''.$_SESSION["id"].'\'';
		$data = pg_query($bdd, $query); /*execution requete*/

		if ($data == false) {
			print_r(pg_last_error());	
		}
		echo "<script type = 'text/javascript'> alert('Goûts de lectures modifiés !');
													document.location.href = '../Profil.php';</script>";
	}
	else {
		echo "<script type = 'text/javascript'> alert('Vous enregistrez des données vides...');
													document.location.href = '../Profil.php';</script>";
	}
}

if ($_POST["categorie"] == 'aimer_voyager') {
	if (!empty(htmlspecialchars($_POST["aimer_voyager"])))
	{
		$query = 'UPDATE gout SET aime_voyager = \''.htmlspecialchars($_POST["aimer_voyager"]).'\' WHERE id = \''.$_SESSION["id"].'\'';
		$data = pg_query($bdd, $query); /*execution requete*/

		if ($data == false) {
			print_r(pg_last_error());	
		}
		echo "<script type = 'text/javascript'> alert('Goûts de voyages modifiés !');
													document.location.href = '../Profil.php';</script>";
	}
	else {
		echo "<script type = 'text/javascript'> alert('Vous enregistrez des données vides...');
													document.location.href = '../Profil.php';</script>";
	}
}

?>