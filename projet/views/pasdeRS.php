<?php 
session_start();
include("db_connect.php");
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
            <br />


            <!--Le corps de la page-->
           <h1 style="text-align:center; font-size:5em">Désolé !</h1>
           <br />
           <p> Nos réseaux sociaux n'existent pas encore, mais seront très bientôt disponible, 
           des infos vous seront très bientôt communiqués sur la catégorie "Annonces" de notre Forum</p>
           <br /><br /><br /><br />

           <!--Le footer du site-->
           <?php include('footer.php'); ?>
            
        </div>
    </body>
</html>
