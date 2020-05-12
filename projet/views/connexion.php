<?php
session_start();
include("db_connect.php");


if(isset($_POST['connection'])) {
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mdp = sha1($_POST['mdp']);
    if(!empty($pseudo) AND !empty($mdp)) {
        $requtilisateur = $bdd->prepare("SELECT * FROM membre WHERE pseudo=? AND motdepasse=?");
        $requtilisateur->execute(array($pseudo,$mdp));
        $utilisateurexiste = $requtilisateur->rowCount();
        if($utilisateurexiste == 1) {
            $utilisateurinfo = $requtilisateur->fetch();
            $_SESSION['id'] = $utilisateurinfo['id'];
            $_SESSION['pseudo'] = $utilisateurinfo['pseudo'];
            $_SESSION['mail'] = $utilisateurinfo['mail'];
            header("Location: /projet/views/profil.php?id=".$_SESSION['id']);
        }
        else {
            $erreur = "Ces identifiants ne correspondent à aucun utilisateur !";
        }
    }
    else {
        $erreur = "tous les champs doivent être complétés !";
    }
}

?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style_MyM.css" />
        <title>MyManager</title>
    </head>
    
    <body>
        <div id="bloc_page">

            <!--Le header de la page-->
            <?php include('header.php'); ?>
            
			

            <!--La bannière-->
            <div id="banniere_accueil">
                <div id="banniere_description">
                    <a href="https://www.footballmanager.com/fr" title="FM">
                        Football Manager
                    </a>
                </div>
            </div>
            <br /><br />


            <div id="container" align="center">  
                <h1>Connectez-vous</h1>
                <br /><br /><br />
	            <form method="POST" action="" class="co_insc">
                    <table>
                    <tr>
                        <td>
                            <label for="pseudo"><h2>Pseudo : </h2></label> 
                        </td>
                        <td>
                            <input type="text" name="pseudo" placeholder="pseudo" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="mdp"><h2>Mot de passe : </h2></label>
                        </td>
                        <td>
                            <input type="password" name="mdp" placeholder="mot de passe" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>   
                        <td>
                            <input type="submit" name="connection" value="Se connecter" />
                        </td>
                    </tr>
                    
	            </form>
		        <?php
                if(isset($erreur)) {
                    echo '<font color = "red" >'.$erreur."</font>";
                }
                ?>
                </table>
                <p id="co">Pas de compte ?<br />
                <a href="/projet/views/inscription.php">Inscrivez-vous</a></p>
            </div>		
            <br /><br /><br />
            

            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>

        <script src="JS/formulaire_validation.js"></script>
    </body>
</html>
