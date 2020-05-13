<?php


//on démarre la session
session_start();



$_SESSION["prenom"] = htmlspecialchars($_POST["prenom"]);
$_SESSION["nom"] = htmlspecialchars($_POST["nom"]);
$_SESSION["date_naissance"] = htmlspecialchars($_POST["date_n"]);
$_SESSION["ville"] = htmlspecialchars($_POST["ville"]);
$_SESSION["adresse_mail"] = htmlspecialchars($_POST["adresse_mail"]);
$_SESSION["adresse"] = htmlspecialchars($_POST["adresse"]);
$_SESSION["num_tel"] = htmlspecialchars($_POST["num_tel"]);
$_SESSION["pseudo"] = htmlspecialchars($_POST["pseudo"]);
$_SESSION["filiere"] = htmlspecialchars($_POST["filiere"]);
$_SESSION["annee_etude"] = htmlspecialchars($_POST["annee_etude"]);
$_SESSION["sexe"] = htmlspecialchars($_POST["sexe"]);
$_SESSION["mdp"] = htmlspecialchars($_POST["mdp"]);
$_SESSION["statut"] = 'utilisateur';


try
{
	/*$conn_string = "host=localhost port=5432 dbname=ipw user=cao_caroline password=123"; */
	$conn_string = "host=localhost port=5432 dbname=projet_web user=lauriane password=lauriane"; // connection à la base de donnée. il faut la créer chez vous et modifier les nom, user et mdp

    $bdd = pg_connect($conn_string);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
$id_utilisateur = pg_query($bdd, 'SELECT id FROM utilisateur');
$nb_lignes = pg_num_rows($id_utilisateur);
$id_num = $nb_lignes + 1;
$_SESSION["id"] = $id_num;

$mdp = password_hash($_SESSION["mdp"], PASSWORD_DEFAULT); //on hash le mdp

$query = 'INSERT INTO utilisateur(id, nom, prenom, pseudo, date_naissance, genre, ville, adresse, email, annee_etude, filiere, mot_de_passe, numero_tel, statut)
VALUES (\''.$id_num.'\', \''.$_SESSION["nom"].'\', \''.$_SESSION["prenom"].'\', \''.$_SESSION["pseudo"].'\', \''.$_SESSION["date_naissance"].'\', \''.$_SESSION["sexe"].'\', \''.$_SESSION["ville"].'\', \''.$_SESSION["adresse"].'\', \''.$_SESSION["adresse_mail"].'\', \''.$_SESSION["annee_etude"].'\', \''.$_SESSION["filiere"].'\', \''.$mdp.'\', \''.$_SESSION["num_tel"].'\', \'utilisateur\')';
$action = pg_query($bdd, $query);

if ($action)
{
	pg_free_result($action);
	header('Location: ../3_Formulaire.php');
}
else 
{
	header('Location: ../2_Inscription.html');
}

?>
