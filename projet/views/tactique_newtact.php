<?php
session_start();
include("db_connect.php");
require('functions.php');




$tactique = $bdd->query('SELECT * FROM tactique');
$composition = $bdd->query('SELECT * FROM Composition');
if(isset($_SESSION['id'])) {
    if(isset($_POST['tsubmit'])) {
        
        if(isset($_POST['nom'],$_POST['equipe'],$_POST['commentaire'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $equipe = htmlspecialchars($_POST['equipe']);
        $composition = htmlspecialchars($_POST['composition']);
        $commentaire = htmlspecialchars($_POST['commentaire']);
            if(!empty($nom) AND !empty($equipe) AND !empty($commentaire)) {
                if(strlen($nom) <= 75) {
                    if(strlen($equipe) <= 50) {

                        $idmax = $bdd->query(" SELECT Max(id) FROM tactique  ");
                        $idv = $idmax->fetch()['max']+1;

                        $ins = $bdd->prepare('INSERT INTO tactique (id, nom, id_membre, equipe, composition, commentaire, dateheure_creat,joueur1,joueur2,joueur3,joueur4,joueur5,joueur6,joueur7,joueur8,joueur9,joueur10,joueur11) VALUES (?,?,?,?,?,?,NOW(),NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)');
                        
                        $ins->execute(array($idv,$nom, $_SESSION['id'], $equipe, $composition, $commentaire));

                        $id_tact = $bdd->prepare('SELECT * FROM tactique WHERE nom=? AND equipe= ? AND composition= ? AND commentaire= ?');
                        $id_tact->execute(array($nom, $equipe, $composition, $commentaire));
                        $id_tact= $id_tact->fetch();
                        header("Location: /projet/views/tactique_joueurs.php?nom=".$nom."&equipe=".$equipe."&composition=".$composition."&id=".$id_tact['id']);
                    } else {
                        $terror = "Le nom de votre équipe ne peut pas dépasser 50 caractères";
                        $composition = $bdd->query('SELECT * FROM Composition');
                    }
                } else {
                    $terror = "Le nom de votre tactique ne peut pas dépasser 75 caractères";
                    $composition = $bdd->query('SELECT * FROM Composition');
                }
            
            } else {
                $terror = "Veuillez compléter tous les champs";
                $composition = $bdd->query('SELECT * FROM Composition');
            }
        }
    }
} else {
    $terror = "Veuillez vous connecter pour creer une nouvelle tactique";
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





            <h1 class="titre_forum">NOUVELLE TACTIQUE</h1>
            
            <br />
            <form class="newtactique" method="POST">
                <table class="newtact" border="10" align="center">

                    <tr>
                        <td class='aaa'><h4><br />Nom</h4></td> 
                        <td class='sub_info1'>
                            <br />
                            <textarea name="nom"></textarea><br />
                            <span style="font-size:0.5em">Ex : Le nom de ma tactique</span>      
                            <br /><br />
                        </td>
                    </tr>

                    <tr>
                        <td class='aaa'><h4><br />Equipe</h4></td> 
                        <td class='sub_info1'>
                            <br />
                            <textarea name="equipe"></textarea><br />
                            <span style="font-size:0.5em">Ex : FC Equipe</span>     
                            <br /><br />
                        </td>
                    </tr>

                    <tr>
                        <td class='aaa'><h4><br />Composition</h4></td> 
                        <td class='sub_info1'> 
                            <select name="composition">
                                <?php while($compo = $composition->fetch()) { ?>
                                    <option value="<?php echo $compo['id'] ?>"><?php echo $compo['compo'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class='aaa'><h4><br />Commentaire</h4></td> 
                        <td class='sub_info1'> 
                            <br />
                            <textarea name="commentaire"></textarea><br />
                            <span style="font-size:0.5em">Ex : Je vous présente ma tactique, ...</span>       
                            <br />
                            <br />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br />
                                <input type="submit" name="tsubmit" value="Aller choisir vos joueur" />       
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
