<?php
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{
  $username = $_POST['username'];
  $password = $_POST['password'];

    // connexion à la base de données
    $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
           or die('Erreur de connexion  la base de données');
    
    if($username !== "" && $password !== "")
    {
        $select = "SELECT count(*) as num FROM utilisateur WHERE user_id = '$username' AND password = '$password';";
        $exec_requete = pg_query($select)
		      or die('Erreur commande');
        $reponse      = pg_fetch_array($exec_requete);
        $count = $reponse['num'];
        if($count!=0) // nom d'utilisateur et mot de passe correctes
        {
           $_SESSION['username'] = $username;
	   $_SESSION['password'] = $password;
	   $select2 = "SELECT admin FROM utilisateur WHERE user_id = '$username' AND password = '$password';";
           $exec_requete2 = pg_query($select2)
		      or die('Erreur commande');
           $reponse2      = pg_fetch_array($exec_requete2);
           $admin = $reponse2['admin'];
	   $_SESSION['admin'] = $admin;
           header('Location: accueil.php');
        }
        else
        {
           header('Location: index.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
    }
    else
    {
       header('Location: index.php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
   header('Location: index.php');
}
pg_close($db); 
?>