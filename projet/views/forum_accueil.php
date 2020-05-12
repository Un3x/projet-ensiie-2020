<?php
session_start();
include("db_connect.php");

$categorie = $bdd->query('SELECT * FROM f_categories ORDER BY id');
$sscate = $bdd->prepare('SELECT * FROM f_souscategories WHERE id_cate = ? ORDER BY id');


require('functions.php');


?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style_forum.css" />
        <title>MyManager</title>
    </head>
    
    <body>
        <div id="bloc_page">

            <!--Le header de la page-->
            <?php include('header.php'); ?>
            


            <div id="banniere_accueil">
                <div id="banniere_description">
                    <a href="https://www.footballmanager.com/fr" title="FM">
                        Football Manager
                    </a>
                </div>
            </div><br />

            
            <h1 class="titre_forum">Bienvenue sur le Forum de MyManager</h1>
            <br /><br />


           
            <table class="forum" border=5 align=center>
                <tr class="header">
                    <th class="main">Catégories</th>
                </tr> 
                
                <?php 
                while ($c=$categorie->fetch()) { 
                    $sscate->execute(array($c['id']));
                    $souscategories = '';
                    while($sc = $sscate->fetch()) {
                        $souscategories .= '<a href="/projet/views/forum_topic.php?categorie='.url_custom_encode($c['nom']).'&souscategorie='.url_custom_encode($sc['nom']).'">'.$sc['nom'].'</a> | ';
                    }
                ?>
                <tr>
                    <td>
                        <h4 class="aaa"><a href="/projet/views/forum_topic.php?categorie=<?= url_custom_encode($c['nom']) ?>"><?php echo $c['nom'] ?></a></h4>
                        <p class="bbb"><?php echo $souscategories ?><br /><br /></p>
                    </td> 
                </tr>
                <?php } ?>
            </table>
            <br /><br /><br /><br />
            
           

            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>
    </body>
</html>
