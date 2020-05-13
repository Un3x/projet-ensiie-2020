<?php

session_start();

try {
/*$conn_string = "host=localhost port=5432 dbname=ipw user=cao_caroline password=123";*/
$conn_string = "host=localhost port=5432 dbname=projet_web user=lauriane password=lauriane";
$bdd = pg_connect($conn_string);
}

catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}


if ($_POST["categorie"] == 'voyage') {	
	$query = 'DELETE FROM voyage WHERE id = \''.$_POST["id"].'\' AND lieu = \''.$_POST["delete_lieu"].'\' AND ville = \''.$_POST["delete_ville"].'\' AND pays = \''.$_POST["delete_pays"].'\''; /*requete*/

	$data = pg_query($bdd, $query); /*execution requete*/

	if ($data == false) {
		print_r(pg_last_error());	
	}
	echo "<script type = 'text/javascript'> alert('Données supprimées !');
                                                    document.location.href = '../Profil.php';</script>";
}

if ($_POST["categorie"] == 'oeuvre') {
	$query = 'DELETE FROM lecture WHERE id = \''.$_POST["id"].'\' AND type_oeuvre = \''.$_POST["type"].'\' AND genre_oeuvre = \''.$_POST["genre"].'\' AND titre = \''.$_POST["titre"].'\' AND auteurs = \''.$_POST["auteur"].'\''; /*requete*/

	$data = pg_query($bdd, $query); /*execution requete*/

	if ($data == false) {
		print_r(pg_last_error());	
	}
	echo "<script type = 'text/javascript'> alert('Données supprimées !');
                                                    document.location.href = '../Profil.php';</script>";
}

if ($_POST["categorie"] == 'films') {
	$query = 'DELETE FROM film WHERE id = \''.$_POST["id"].'\' AND nom_film = \''.$_POST["titre"].'\' AND realisateur_film = \''.$_POST["realisateur"].'\' '; /*requete*/

	$data = pg_query($bdd, $query); /*execution requete*/

	if ($data == false) {
		print_r(pg_last_error());	
	}
	echo "<script type = 'text/javascript'> alert('Données supprimées !');
                                                    document.location.href = '../Profil.php';</script>";
}

if ($_POST["categorie"] == 'asso') {
	$query = 'DELETE FROM association WHERE id = \''.$_POST["id"].'\' AND nom_association = \''.$_POST["delete_asso"].'\' '; /*requete*/

	$data = pg_query($bdd, $query); /*execution requete*/

	if ($data == false) {
		print_r(pg_last_error());	
	}
	echo "<script type = 'text/javascript'> alert('Données supprimées !');
                                                    document.location.href = '../Profil.php';</script>";
}

if ($_POST["categorie"] == 'sport') {
	$query = 'DELETE FROM sport WHERE id = \''.$_POST["id"].'\' AND nom_sport = \''.$_POST["delete_sport"].'\' '; /*requete*/

	$data = pg_query($bdd, $query); /*execution requete*/

	if ($data == false) {
		print_r(pg_last_error());	
	}
	echo "<script type = 'text/javascript'> alert('Données supprimées !');
                                                    document.location.href = '../Profil.php';</script>";
}

if ($_POST["categorie"] == 'tel') {
	$query = 'UPDATE utilisateur SET numero_tel = \''.NULL.'\' WHERE  numero_tel = \''.$_POST["delete_tel"].'\' '; /*requete*/

	$data = pg_query($bdd, $query); /*execution requete*/

	if ($data == false) {
		print_r(pg_last_error());	
	}
	echo "<script type = 'text/javascript'> alert('Numéro supprimé !');
                                                    document.location.href = '../Profil.php';</script>";
}

if ($_POST["categorie"] == 'adresse') {
	$query = 'UPDATE utilisateur SET adresse = \''.NULL.'\' WHERE  id = \''.$_POST["id"].'\' '; /*requete*/

	$data = pg_query($bdd, $query); /*execution requete*/

	if ($data == false) {
		print_r(pg_last_error());	
	}
	echo "<script type = 'text/javascript'> alert('Adresse supprimée !');
                                                    document.location.href = '../Profil.php';</script>";
}

if ($_POST["categorie"] == 'supr_profil') {
	$queryf = 'DELETE FROM film WHERE id = \''.$_POST["id"].'\'';
	$dataf = pg_query($bdd, $queryf); /*execution requete*/

	if ($dataf == false) {
		print_r(pg_last_error());	
	}

	$queryl = 'DELETE FROM lecture WHERE id = \''.$_POST["id"].'\'';
	$datal = pg_query($bdd, $queryl); /*execution requete*/

	if ($datal == false) {
		print_r(pg_last_error());	
	}

	$queryv = 'DELETE FROM voyage WHERE id = \''.$_POST["id"].'\'';
	$datav = pg_query($bdd, $queryv); /*execution requete*/

	if ($datav == false) {
		print_r(pg_last_error());	
	}

	$querya = 'DELETE FROM association WHERE id = \''.$_POST["id"].'\'';
	$dataa = pg_query($bdd, $querya); /*execution requete*/

	if ($dataa == false) {
		print_r(pg_last_error());	
	}

	$querys = 'DELETE FROM sport WHERE id = \''.$_POST["id"].'\'';
	$datas = pg_query($bdd, $querys); /*execution requete*/

	if ($datas == false) {
		print_r(pg_last_error());	
	}

	$queryr = 'DELETE FROM relation WHERE id = \''.$_POST["id"].'\'';
	$datar = pg_query($bdd, $queryr); /*execution requete*/

	if ($datar == false) {
		print_r(pg_last_error());	
	}

	$queryd = 'DELETE FROM demande_ami WHERE id1 = \''.$_POST["id"].'\' OR id2 = \''.$_POST["id"].'\'';
	$datad = pg_query($bdd, $queryd); /*execution requete*/

	if ($datad == false) {
		print_r(pg_last_error());	
	}

	$queryam = 'DELETE FROM amis WHERE id1 = \''.$_POST["id"].'\' OR id2 = \''.$_POST["id"].'\' ';
	$dataam = pg_query($bdd, $queryam); /*execution requete*/

	if ($dataam == false) {
		print_r(pg_last_error());	
	}

	$queryu = 'DELETE FROM utilisateur WHERE id = \''.$_POST["id"].'\'';
	$datau = pg_query($bdd, $queryu); /*execution requete*/

	if ($datau == false) {
		print_r(pg_last_error());	
	}

	echo "<script type = 'text/javascript'> alert('Profil supprimé !');
                                                  document.location.href = '../4_Page_2.php';</script>";
}




?>