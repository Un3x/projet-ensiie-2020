<?php 
session_start();
include("db_connect.php");

$tactique = $bdd->query('SELECT * FROM tactique ');
$diff_tactiques = $bdd->prepare('SELECT * FROM tactique WHERE id_membre = ?');
$comp=$bdd->prepare('SELECT * FROM Composition WHERE id = ?');
$tact_membre = $bdd->query('SELECT * FROM membre LEFT JOIN tactique ON membre.id = tactique.id_membre ORDER BY id');
require('functions.php');

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
            <h1 class="titre">TACTIQUE</h1>
            <h2><img src="images/ico_joueur.png" alt="Joueur de football" class="ico_categorie" />Proposes ta tactique et commentes celle des autres</h2>
            <br /><br />

            <p class="create_tact">
                <?php if(isset($_SESSION['id'])) { ?>
                    <a href="/projet/views/tactique_newtact.php?id=<?php echo $_SESSION['id']?>">
                        Créer ta tactique
                    </a>
                <?php }
                else { ?>
                    <a href="/projet/views/tactique_newtact.php">
                        Créer ta tactique
                    </a>
                <?php } ?>
            </p>
            <table class="tactique_accueil" border=5 align=center style="color:white; font-size:1.5em">
                <tr class="header">
                    <th class="main">Les utilisateurs</th>
                </tr> 

                <?php 
                while ($t=$tactique->fetch()) { 
                    $diff_tactiques->execute(array($t['id_membre']));
                    $tact_par_utilisateurs = '';
                    
                    while($tact = $diff_tactiques->fetch()) {
                        $comp->execute(array($tact['composition']));
                        $compos=$comp->fetch();
                        $tact_par_utilisateurs .= '<a href="/projet/views/tact.php?nom='.$tact['nom'].'&equipe='.$tact['equipe'].'&id='.$tact['id'].'">'.$tact['nom']." (".$tact['equipe']." ".$compos['compo'].")".'</a> | ';
                    }
                ?>
                <tr>
                    <td>
                        <?php $pseudo = $bdd->prepare('SELECT pseudo FROM membre LEFT JOIN tactique ON tactique.id_membre=membre.id WHERE membre.id = ?');
                            $pseudo->execute(array($t['id_membre']));
                            $pseudo = $pseudo->fetch()['pseudo'];
                        ?>
                        <!--Ecrire une petite fonction pour supprimer les doublons-->
                        <h4 class="aaa"><?php echo $pseudo ?></h4>
                        <p class="bbb"><?php echo $tact_par_utilisateurs ?><br /><br /></p>
                    </td> 
                </tr>
                <?php } ?>
            </table>


  
            

            <br />
            <p class="create_tact">
                <?php if(isset($_SESSION['id'])) { ?>
                    <a href="/projet/views/tactique_newtact.php?id=<?php echo $_SESSION['id']?>">
                        Créer ta tactique
                    </a>
                <?php }
                else { ?>
                    <a href="/projet/views/tactique_newtact.php">
                        Créer ta tactique
                    </a>
                <?php } ?>
            </p>
            <br /><br /><br />
            


            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>
    </body>
</html>
