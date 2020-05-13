<?php
session_start();
if (!isset($_SESSION["id"]))
{
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title> Bienvenue sur FrIIEnd ++ </title>
        <link rel="stylesheet" type="text/css" href="../mises_en_pages/Page_1.css">
    </head>
    <body>

	    <div class="topbar">
		    <a class="actif" href="1_Page_1.php">Accueil</a>
	   	    <a href="2_Inscription.html">Inscription</a>
		    <a href="informations.html">Informations</a>
        </div>

        <div class="clignotement">
            <p></p>
        </div>

        <div id="Presentation" style="float:right;clear:right;">
            <p>
                <b>FrIIEnds++
                    <span>FrIIEnds++ est LE réseau social de l'ENSIIE</span>
            </p>




            <div id="Connexion" style="float:right;clear:right;">
                
                <h2> Connectez vous ! </h2>
                <form method = "post" action = "4_Page_2.php">
                    <div class="connx">
                    Identifiant : <input type="text" name="Identifiant">
                    <br/>
                    Mot de passe : <input type="password" name="password">
                </div>
                    <br/>
                    <input type="submit" value="Connection">  
                    <br/>
                </form>
                
                <br/>
                <font size=2> Pas encore de compte ? <a href="2_Inscription.html"> Inscrivez-vous </a> </font>

            </div>

            

        </div>
    </body>
</html>

<?php
}

else 
{
    header('Location: 4_Page_2.php');
    exit();
}