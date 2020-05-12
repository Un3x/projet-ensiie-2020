<?php

include("api.php");
include("db_connect.php");

$result=getplayer($_POST['nom'],$_POST['prenom'],$_POST['valeuratt'],$_POST['valeurdef'],$_POST['valeurtech']);

?>


<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style_MyM.css" />
        <title>MyManager Joueur</title>
    </head>
    
    <body>
        <div id="bloc_page">

            <!--Le header de la page-->
            <?php include('header.php'); ?>
            
            

            <!--La bannière-->
            <div id="banniere_image">
                <div id="banniere_description" >
                    <a href="https://www.footballmanager.com/fr" title="FM">Football Manager</a>
                    <?php if(isset($_SESSION['id'])) { ?>
                        <a href="<?php echo '/projet/views/forum_accueil.php?id='.$_SESSION['id'] ?>" class="bouton_rouge">
                            Viens discuter sur notre Forum <img src="images/flecheblanchedroite.png" alt="" />
                        </a>
                    <?php }
                    else { ?>
                        <a href="/projet/views/forum_accueil.php" class="bouton_rouge">
                            Viens discuter sur notre Forum <img src="images/flecheblanchedroite.png" alt="" />
                        </a>
                    <?php } ?>
                </div>
            </div>
            <br /><br />



            <!--Le corps de la page-->
            <h1 class="titre">JOUEURS</h1>
            <br /><br />
            <div id="joueur_rech"> 
                <p>Voici les joueurs trouvés, choisis celui que tu souhaites:<br /><br />
                <ul>
                    <?php foreach($result as $value){?>
                        <li><a href="<?php echo '/projet/views/joueurs_recherche.php?idjoueur='.$value['id'] ?>"> <?php echo $value["prenom"]." ".$value["nom"]; ?></a></li><br />
                    <?php } ?>
                </ul>
                <br /><br />
                </p>
            </div>
            <div id="joueur_retour"> 
                <?php if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {?>
                    <a href="<?php echo '/projet/views/joueurs.php?id='.$_SESSION['id'] ?>" style="text-align:end">Revenir sur la recherche de joueur</a>
                <?php } 
                else { ?>
                    <a href="/projet/views/joueurs.php">Revenir sur la recherche de joueur</a>
                <?php } ?>
                <br /><br /><br />
            </div>

            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>
    </body>
</html>