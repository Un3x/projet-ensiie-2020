<?php
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
if (isset($_POST['Identifiant']) && isset($_POST['password']))
{
    if (!empty($_POST['Identifiant']) && !empty($_POST['password']))
    {
        $identifiant = $_POST['Identifiant'];
        $req = pg_query($bdd, 'SELECT id, mot_de_passe, pseudo, nom, prenom, date_naissance, ville, statut  FROM utilisateur WHERE email = \''.$identifiant.'\'');
        $arr = pg_fetch_row($req);
        $id = $arr[0];
        $mdp = $arr[1];
        $pseudo = $arr[2];
        $nom = $arr[3];
        $prenom = $arr[4];
        $ddn = $arr[5];
        $ville = $arr[6];
        $statut = $arr[7];
        
        if (!$arr || !password_verify($_POST['password'], $mdp))
        {
            echo "<script type = 'text/javascript'> alert('Votre identifiant ou mot de passe est incorrect. Veuillez réessayer.');
                                                    document.location.href = '1_Page_1.php';</script>";
            
        }
        else
        {
            $_SESSION["id"] = $id;
            $_SESSION["pseudo"] = $pseudo;
            $_SESSION["nom"] = $nom;
            $_SESSION["prenom"] = $prenom;
            $_SESSION["date_naissance"] = $ddn;
            $_SESSION["ville"] = $ville;
            $_SESSION["statut"] = $statut;
        }
    }
    else
    {
        echo "<script type = 'text/javascript'> alert('Votre identifiant ou mot de passe est incorrect. Veuillez réessayer.');
                                                document.location.href = '1_Page_1.php';</script>";
    }
}

?>




<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title> Bienvenue sur FrIIEnd ++ </title>
        <link rel="stylesheet" type="text/css" href="../mises_en_pages/Page_2.css">
    </head>
    <body>

	    <div class="topbar">
		    <a class="actif" href="4_Page_2.php">Accueil</a>
            <a href="formulaire_de_recherche.php">Rechercher un ami</a>
            <a href="Profil.php">Mon profil</a> 
            <a href="deconnexion.php" class="param">Déconnexion</a>
            
        </div>

       

        
        <div class="profil">
            <img class="photo" src="../mises_en_pages/Iprofil.jpg.png"><br>
            Votre profil actuel <br/>
                        Prénom : <?php print_r($_SESSION["prenom"]); ?> <br/>
                        Nom : <?php print_r($_SESSION["nom"]); ?> <br/>
                        Pseudo : <?php print_r($_SESSION["pseudo"]); ?> <br/>
                        Date de naissance : <?php print_r($_SESSION["date_naissance"]); ?> <br/>
                        Ville de résidence : <?php print_r($_SESSION["ville"]); ?> <br/>
        </div>


    </body>
</html>
