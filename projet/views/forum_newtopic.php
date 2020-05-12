<?php
session_start();
include("db_connect.php");
//$categories = $bdd->query('SELECT * FROM f_categories ORDER BY nom');
//$sscate = $bdd->prepare('SELECT * FROM f_souscategories WHERE id_cate = ? ORDER BY nom');

require('functions.php');

$nomcateg='';
if ($_GET['categorie']=="football") {
    $nomcateg="Football";
}
else if ($_GET['categorie']=="football-manager-2020") {
    $nomcateg="Football Manager 2020";
}
else if ($_GET['categorie']=="football-manager-2021") {
    $nomcateg="Football Manager 2021";
}

if(isset($_GET['categorie'])) {
    $get_categorie = htmlspecialchars($_GET['categorie']);
    $categorie = $bdd->prepare('SELECT * FROM f_categories WHERE id = ?');
    $categorie->execute(array($get_categorie));
    $cat_exist = $categorie->rowCount();
    if($cat_exist == 1) {
        $categorie = $categorie->fetch();
        $categorie = $categorie['nom'];
        $souscategories = $bdd->prepare('SELECT * FROM f_souscategories WHERE id_cate = ? ORDER BY nom');
        $souscategories->execute(array($get_categorie));
        if(isset($_SESSION['id'])) {
            if(isset($_POST['tsubmit'])) {
                if(isset($_POST['tsujet'],$_POST['tcontenu'])) {
                $sujet = htmlspecialchars($_POST['tsujet']);
                $contenu = htmlspecialchars($_POST['tcontenu']);
                $souscategorie = htmlspecialchars($_POST['souscategorie']);
                $verify_sc = $bdd->prepare('SELECT id FROM f_souscategories WHERE id = ? AND id_cate = ?');
                $verify_sc->execute(array($souscategorie,$get_categorie));
                $verify_sc = $verify_sc->rowCount();
                if($verify_sc == 1) {
                    if(!empty($sujet) AND !empty($contenu)) {
                        if(strlen($sujet) <= 70) {
                            
                            $idmax = $bdd->query(" SELECT Max(id) FROM f_topics  ");
                            $idv = $idmax->fetch()['max']+1;

                            $ins = $bdd->prepare('INSERT INTO f_topics (id,id_createur, sujet, contenu, dateheure_creat,resolu) VALUES(?,?,?,?,NOW(),0)');
                            $ins->execute(array($idv,$_SESSION['id'],$sujet,$contenu)); 


                            $lt = $bdd->query('SELECT Max(id) FROM f_topics  ');


                            $lt = $lt->fetch();
                            $id_topic = $lt['max'];

                            $idmax = $bdd->query(" SELECT Max(id_topicscate) FROM f_topicscate  ");
                            $idv = $idmax->fetch()['max']+1;
                            

                            $ins = $bdd->prepare('INSERT INTO f_topicscate (id_topicscate,id_topic, id_cate, id_souscate) VALUES (?,?,?,?)');
                            $ins->execute(array($idv,$id_topic, $get_categorie, $souscategorie));
                            header("Location: /projet/views/topic.php?id=".$idv);
                        } else {
                            $terror = "Votre sujet ne peut pas dépasser 70 caractères";
                        }
                    } else {
                        $terror = "Veuillez compléter tous les champs";
                    }
                } else {
                    $terror = "Sous-catégorie invalide";
                }
                }
            }
        } else {
            $terror = "Veuillez vous connecter pour poster un nouveau topic";
        }
    } else {
        die('2 - Catégorie invalide...');
    }
} else {
    die('1 - Aucune catégorie définie...');
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

            


            <div id="banniere_accueil">
                <div id="banniere_description">
                    <a href="https://www.footballmanager.com/fr" title="FM">
                        Football Manager
                    </a>
                    
                </div>
            </div>
            <br />





            <h1 class="titre_forum">NOUVEAU TOPIC</h1>
            
            <br />
            <form class="fntopic" method="POST">
                <table class="forum_newtopic" border="10" align="center">

                    <tr>
                        <td class='aaa'><h4><br />Categorie</h4></td> 
                        <td class='sub_info1'><?php echo $categorie ?></td>
                    </tr>

                    <tr>
                        <td class='aaa'><h4><br />Sous Categorie</h4></td> 
                        <td class='sub_info1'> 
                            <select name="souscategorie">
                                <?php while($sc = $souscategories->fetch()) { ?>
                                    <option value="<?php echo $sc['id'] ?>"><?php echo $sc['nom'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class='aaa'><h4><br />Sujet</h4></td> 
                        <td class='sub_info1'> 
                            <br />
                            <input type="text" name="tsujet" size="70" maxlenght="70" />
                            <br />
                            <br />
                        </td>
                    </tr>
                    
                    <tr>
                        <td class='aaa'><h4><br />Message</h4></td> 
                        <td class='sub_info1'> 
                            <br />
                            <textarea name="tcontenu"></textarea>       
                            <br />
                            <br />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br />
                                <input type="submit" name="tsubmit" value="Poster le Topic" />       
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
