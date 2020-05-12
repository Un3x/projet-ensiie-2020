<?php
session_start();
include("db_connect.php");
require('functions.php');
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
            <h1><img src="images/ico_joueur.png" alt="Joueur de football" class="ico_categorie" />Reherche ton joueur pour créer la plus grande équipe</h1>
            <br /><br />

            <section>
                <div id="joueur_rech">
                    <p> Voici quelques joueurs :<br />
                        <ul>

                            <?php $joueur = $bdd->query('SELECT * FROM joueurs ORDER BY id DESC');
                            while($j=$joueur->fetch()){ ?>
                                <li><a href="<?php echo '/projet/views/joueurs_recherche.php?idjoueur='.$j['id'] ?>"><?php echo $j['prenom']." ".$j['nom'] ?></a></li><br />
                            <?php } ?>
                        </ul>
                    </p>
                </div>
                <br /><br />

                <aside class="aside_autres">
                    <h1><strong><em>Filtres</em></strong></h1>
                    <hr />


                    <img src="images/bulle.png" alt="" id="fleche_bulle" />
                    <h3>Affines ta recherche et trouves le futur crack de ton équipe</h3>
                    
                    <form action="/projet/views/recherche.php" method="POST" class="filtre_joueur">
                            
                        <label> Nom : </label>
                        <input type="text" name="nom" /><br /><br />
                    
                        <label>Prénom : </label>
                        <input type="text" name="prenom" /><br /><br />
                    
                        <label>Attaque : </label>
                        <select name="valeuratt">
                            <option value="att_tout">n'importe</option>
                            <option value="att_inf10">inférieure à 10</option>
                            <option value="att_entre_10_15">entre 10 et 15</option>
                            <option value="att_sup15">supérieure à 15</option>
                        </select><br /><br />
                    
                        <label>Défense : </label>
                        <select name="valeurdef">
                            <option value="def_tout">n'importe</option>
                            <option value="def_inf10">inférieure à 10</option>
                            <option value="def_entre_10_15">entre 10 et 15</option>
                            <option value="def_sup15">supérieure à 15</option>
                        </select><br /><br />

                        <label>Technique : </label>
                        <select name="valeurtech">
                            <option value="tech_tout">n'importe</option>
                            <option value="tech_inf10">inférieure à 10</option>
                            <option value="tech_entre_10_15">entre 10 et 15</option>
                            <option value="tech_sup15">supérieure à 15</option>
                        </select><br /><br />
                        <p><input type="submit" value="Rechercher"></p>
                    </form>

                 </aside>
                 

            </section>
            <br /><br /><br />


            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>
    </body>
</html>