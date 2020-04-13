<?php
session_start();
if(isset($_POST['username']) && isset($_POST['password']))
{
    // connexion à la base de données
    $db_username = 'ensiie';
    $db_password = 'ensiie';
    $db_name     = 'ensiie';
    $db_host     = 'localhost';
    $db = pg_connect("host=localhost dbname=ensiie user=ensiie password=ensiie");
    
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    $username = pg_escape_string($db,htmlspecialchars($_POST['username'])); 
    $password = pg_escape_string($db,htmlspecialchars($_POST['password']));
     echo "<p> $username </p>";
    if($username !== "" && $password !== "")
    {
        $requete = "SELECT count(*) FROM membre where 
              username = '".$username."' and passwd = '".$password."' ";
        $exec_requete = pg_query($db,$requete);
        $reponse      = pg_fetch_array($exec_requete);
        $count = $reponse["count"];
        if($count!=0) // nom d'utilisateur et mot de passe correctes
        {
           $_SESSION['username'] = $username;
           header('Location: userlist.php');
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
pg_close($db); // fermer la connexion
?>