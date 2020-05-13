<?php

//on démarre la session
session_start();

try
{
	/*$conn_string = "host=localhost port=5432 dbname=ipw user=cao_caroline password=123";*/
	$conn_string = "host=localhost port=5432 dbname=projet_web user=lauriane password=lauriane"; // connection à la base de donnée. il faut la créer chez vous et modifier les nom, user et mdp

    $bdd = pg_connect($conn_string);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

$id_num = $_SESSION["id"];


/**********************************************************************************************
									ASSOCIATION
**********************************************************************************************/
$action1 = false; $action2 = false; $action3 = false; $action4 = false;

if (isset($_POST["association1"]))
{
	$action1 = pg_query($bdd, 'INSERT INTO association(id, nom_association) 
	VALUES (\''.$id_num.'\', \''.htmlspecialchars($_POST["association1"]).'\')');

}

/**********************************************************************************************
									SPORT
**********************************************************************************************/

if (isset($_POST["sports"])) 
{
	$action2 = pg_query($bdd, 'INSERT INTO sport(id, nom_sport, club, niveau)
	VALUES (\''.$id_num.'\', \''.htmlspecialchars($_POST["sports"]).'\', \''.htmlspecialchars($_POST["club1"]).'\',\''.htmlspecialchars($_POST["nivSportif"]).'\')'); 
}



/**********************************************************************************************
									GOUT
**********************************************************************************************/


if (isset($_POST["aimer_lire"]) && isset($_POST["aimer_voyager"]))
{
	$action3 = pg_query($bdd, 'INSERT INTO gout(id, aime_lire, aime_voyager)
	VALUES (\''.$id_num.'\', \''.htmlspecialchars($_POST["aimer_lire"]).'\', \''.htmlspecialchars($_POST["aimer_voyager"]).'\')'); 
}

/**********************************************************************************************
									AMOUR
**********************************************************************************************/

if (htmlspecialchars($_POST["situation_amoureuse"]) != NULL || htmlspecialchars($_POST["relation_rechercher"]) != NULL || htmlspecialchars($_POST["osexe"]) != NULL ) {
	$action4 = pg_query($bdd, 'INSERT INTO relation(id, relation_recherchée, situation_actuelle, attirance_sexuelle)
	VALUES (\''.$id_num.'\', \''.htmlspecialchars($_POST["relation_rechercher"]).'\', \''.htmlspecialchars($_POST["situation_amoureuse"]).'\',\''.htmlspecialchars($_POST["osexe"]).'\')');}




if ($action1 || $action2 || $action3 || $action4 ) 
{
	echo "<script type = 'text/javascript'> alert('Données enregistrées ! Vous pouvez donc dès maintenant rechercher des amis en fonctions de vos gôuts et de vos passions !');
                                                    document.location.href = '../4_Page_2.php';</script>";
}
else 
{
	echo "<script type = 'text/javascript'> alert('Il y a eu un problème avec l'une des inscriptions. Veuillez réessayer.');
                                                    document.location.href = '../3_Formulaire.php';</script>";
}


?>
