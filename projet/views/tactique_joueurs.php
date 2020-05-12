<?php
session_start();
include("db_connect.php");

require('functions.php');



if(isset($_GET['nom'],$_GET['equipe'],$_GET['composition'],$_GET['id']) AND !empty($_GET['nom']) AND !empty($_GET['equipe']) AND !empty($_GET['composition']) AND !empty($_GET['id'])) {
    $get_nom = htmlspecialchars($_GET['nom']);
    $get_equipe = htmlspecialchars($_GET['equipe']);
    $get_composition=htmlspecialchars($_GET['composition']);
    $get_id = htmlspecialchars($_GET['id']);
    $nom_original = $bdd->prepare('SELECT nom FROM tactique WHERE id = ?');
    $nom_original->execute(array($get_id));
    $nom_original = $nom_original->fetch()['nom'];
    if($get_nom == $nom_original) {
        
        $tactique = $bdd->prepare('SELECT * FROM tactique WHERE id = ?');
        $tactique->execute(array($get_id));
        $tactique = $tactique->fetch();
        $composition = $bdd->query('SELECT * FROM Composition');
        if(isset($_SESSION['id'])) {
            if(isset($_POST['tsubmit'])) {
                $joueur1 = htmlspecialchars($_POST['joueur1']);
                $joueur2 = htmlspecialchars($_POST['joueur2']);
                $joueur3 = htmlspecialchars($_POST['joueur3']);
                $joueur4 = htmlspecialchars($_POST['joueur4']);
                $joueur5 = htmlspecialchars($_POST['joueur5']);
                $joueur6 = htmlspecialchars($_POST['joueur6']);
                $joueur7 = htmlspecialchars($_POST['joueur7']);
                $joueur8 = htmlspecialchars($_POST['joueur8']);
                $joueur9 = htmlspecialchars($_POST['joueur9']);
                $joueur10 = htmlspecialchars($_POST['joueur10']);
                $joueur11 = htmlspecialchars($_POST['joueur11']);
                $change = $bdd->prepare('UPDATE tactique SET joueur1=?, joueur2=?, joueur3=?, joueur4=?, joueur5=?, joueur6=?, joueur7=?, joueur8=?, joueur9=?, joueur10=?, joueur11=? WHERE nom=? AND equipe=? AND composition=?');
                $change->execute(array($joueur1, $joueur2, $joueur3, $joueur4, $joueur5, $joueur6, $joueur7, $joueur8, $joueur9, $joueur10, $joueur11, $get_nom, $get_equipe, $get_composition));
                header("Location: /projet/views/tact.php?id=".$get_id);
            }
        } 
        else {
            $terror = "Veuillez vous connecter pour creer une nouvelle tactique";
        }
    }
    else {
        die('erreur : probleme dans le nom');
    }
}
else {
    die('erreur...');
}


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



            <h1 class="titre_forum">LES JOUEURS POUR TA TACTIQUE</h1>
            
            <br />
            <form class="tactiquejoueur" method="POST">
                <table class="joueurtact" border="10" align="center">
                    <tr class="main1">
                        <td class='aaa'>Equipe</td>
                        <td class="sujet_topic"><?php echo $tactique['equipe'] ?><br /></td>
                    </tr>
                    <tr>
                        <td class='aaa'>Auteur</td>
                        <td class='sub_info1'>
                            <br /><?php $auteur = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
                            $auteur->execute(array($tactique['id_membre']));
                            $auteur = $auteur->fetch();
                            echo $auteur['pseudo']; ?><br /><br />
                        </td>
                    </tr>
                    <tr>
                        <td class='aaa'>Commentaire</td>
                        <td class='sub_info1'>
                            <br /><?php echo $tactique['commentaire']; ?><br />
                            <p class="dh_creat"><br /><?php echo $tactique['dateheure_creat']; ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td class='aaa'>L'equipe</td>
                        <td class='sub_info1'>
                            <!--  1 -> 4-2-3-1 | 2 -> 4-3-3 | 3-> 4-2-4  | 4 -> 5-2-2-1 | 5-> 3-4-3 -->
                            <?php if ($tactique['composition'] == 1) { ?>
                                <img  src="images/tact_4231.jpg" alt="4-2-3-1" class="tact_photo"/> 
                                
                            <?php } elseif ($tactique['composition'] == 2) { ?>
                                <img src="images/tact_433.jpg" alt="4-3-3" class="tact_photo"/>

                            <?php } elseif ($tactique['composition'] == 3) { ?>
                                <img src="images/tact_424.jpg" alt="4-2-4" class="tact_photo"/>

                            <?php } elseif ($tactique['composition'] == 4) { ?>
                                <img src="images/tact_5221.jpg" alt="5-2-2-1" class="tact_photo"/>
                            
                            <?php } elseif ($tactique['composition'] == 5) { ?>
                                <img src="images/tact_343.jpg" alt="3-4-3" class="tact_photo"/>
                            
                            <?php } else {
                                echo "Probleme"; 
                            } ?>
                        </td>
                    </tr>
                    <tr>
                        <td class='aaa'>Joueur 1</td> 
                        <td class='sub_info1'>
                            <select name="joueur1">
                                <?php $gardien=$bdd->query("SELECT * FROM joueurs WHERE poste = 'GK' ");
                                while($gk = $gardien->fetch()) { ?>
                                    <option value="<?php echo $gk['prenom']." ".$gk['nom'] ?>"><?php echo $gk['nom']." ".$gk['prenom'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class='aaa'>Joueur 2</td> 
                        <td class='sub_info1'>
                            <select name="joueur2">
                                <?php $defc=$bdd->query('SELECT * FROM joueurs');
                                while($dc1 = $defc->fetch()) { ?>
                                    <option value="<?php echo $dc1['prenom']." ".$dc1['nom'] ?>"><?php echo $dc1['nom']." ".$dc1['prenom'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class='aaa'>Joueur 3</td> 
                        <td class='sub_info1'>
                            <select name="joueur3">
                                <?php $defc=$bdd->query('SELECT * FROM joueurs');
                                while($dc2 = $defc->fetch()) { ?>
                                    <option value="<?php echo $dc2['prenom']." ".$dc2['nom'] ?>"><?php echo $dc2['nom']." ".$dc2['prenom'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class='aaa'>Joueur 4</td> 
                        <td class='sub_info1'>
                            <select name="joueur4">
                                <?php $milc=$bdd->query('SELECT * FROM joueurs');
                                while($mc2 = $milc->fetch()) { ?>
                                    <option value="<?php echo $mc2['prenom']." ".$mc2['nom'] ?>"><?php echo $mc2['nom']." ".$mc2['prenom'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class='aaa'>Joueur 5</td> 
                        <td class='sub_info1'>
                            <select name="joueur5">
                                <?php $att=$bdd->query('SELECT * FROM joueurs');
                                while($atk = $att->fetch()) { ?>
                                    <option value="<?php echo $atk['prenom']." ".$atk['nom'] ?>"><?php echo $atk['nom']." ".$atk['prenom'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class='aaa'>Joueur 6</td> 
                        <td class='sub_info1'>
                            <select name="joueur6">
                                <?php $gardien=$bdd->query('SELECT * FROM joueurs');
                                while($gk = $gardien->fetch()) { ?>
                                    <option value="<?php echo $gk['prenom']." ".$gk['nom'] ?>"><?php echo $gk['nom']." ".$gk['prenom'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class='aaa'>Joueur 7</td> 
                        <td class='sub_info1'>
                            <select name="joueur7">
                                <?php $defc=$bdd->query('SELECT * FROM joueurs');
                                while($dc1 = $defc->fetch()) { ?>
                                    <option value="<?php echo $dc1['prenom']." ".$dc1['nom'] ?>"><?php echo $dc1['nom']." ".$dc1['prenom'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class='aaa'>Joueur 8</td> 
                        <td class='sub_info1'>
                            <select name="joueur8">
                                <?php $defc=$bdd->query('SELECT * FROM joueurs');
                                while($dc2 = $defc->fetch()) { ?>
                                    <option value="<?php echo $dc2['prenom']." ".$dc2['nom'] ?>"><?php echo $dc2['nom']." ".$dc2['prenom'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class='aaa'>Joueur 9</td> 
                        <td class='sub_info1'>
                            <select name="joueur9">
                                <?php $milc=$bdd->query('SELECT * FROM joueurs');
                                while($mc2 = $milc->fetch()) { ?>
                                    <option value="<?php echo $mc2['prenom']." ".$mc2['nom'] ?>"><?php echo $mc2['nom']." ".$mc2['prenom'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class='aaa'>Joueur 10</td> 
                        <td class='sub_info1'>
                            <select name="joueur10">
                                <?php $att=$bdd->query('SELECT * FROM joueurs');
                                while($atk = $att->fetch()) { ?>
                                    <option value="<?php echo $atk['prenom']." ".$atk['nom'] ?>"><?php echo $atk['nom']." ".$atk['prenom'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class='aaa'>Joueur 11</td> 
                        <td class='sub_info1'>
                            <select name="joueur11">
                                <?php $att=$bdd->query('SELECT * FROM joueurs');
                                while($atk = $att->fetch()) { ?>
                                    <option value="<?php echo $atk['prenom']." ".$atk['nom'] ?>"><?php echo $atk['nom']." ".$atk['prenom'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br />
                                <input type="submit" name="tsubmit" value="Poster votre nouvelle Tactique" />       
                            <br /><br />
                        </td>
                    </tr>
                    <?php if(isset($terror)) { ?>
                    <tr>
                        <td colspan="2" class="fterror">
                            <br />
                            <?php echo $terror ?>
                            <br /><br />
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </form> 

            <br /><br /><br /><br /><br />




            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>
    </body>
</html>
