<?php
session_start();
include("db_connect.php");
require('functions.php');


if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $get_id = htmlspecialchars($_GET['id']);
    $tactique = $bdd->prepare('SELECT * FROM tactique WHERE id = ?');
    $tactique->execute(array($get_id));
    $tactique = $tactique->fetch();
    if(isset($_POST['tactique_com_submit'],$_POST['tact_com'])) {
        $commentaire = htmlspecialchars($_POST['tact_com']);
        if(isset($_SESSION['id'])) {
            if(!empty($commentaire)) {
                $idmax = $bdd->query(" SELECT Max(id) FROM espace_com_tactique  ");
                $idv = $idmax->fetch()['max']+1;

                if($idv==null){
                    $idv=1;
                }
                
                $ins = $bdd->prepare('INSERT INTO espace_com_tactique (id,id_tactique,id_posteur,dateheure_post,dateheure_edition,contenu) VALUES (?,?,?,NOW(),NOW(),?)');
                $ins->execute(array($idv,$get_id,$_SESSION['id'],$commentaire));
                $reponse_msg = "<span style='color:green'>Votre réponse a bien été postée</span>";
                unset($reponse);
            } 
            else {
                $reponse_msg = "<span style='color:red'>Votre réponse ne peut pas être vide !</span>";
            }
        } 
        else {
            $reponse_msg = "<span style='color:red'>Veuillez vous connecter ou créer un compte pour poster une réponse</span>";
        }
    }
    $reponsesParPage = 10;
    $reponsesTotalesReq = $bdd->prepare('SELECT * FROM espace_com_tactique WHERE id_tactique = ?');
    $reponsesTotalesReq->execute(array($get_id));
    $reponsesTotales = $reponsesTotalesReq->rowCount();
    $pagesTotales = ceil($reponsesTotales/$reponsesParPage);
    if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
        $_GET['page'] = intval($_GET['page']);
        $pageCourante = $_GET['page'];
    } 
    else {
        $pageCourante = 1;
    }
    $depart = ($pageCourante-1)*$reponsesParPage;
    $reponses = $bdd->prepare("SELECT * FROM espace_com_tactique WHERE id_tactique = ? ORDER BY id ASC LIMIT '".$reponsesParPage."'  offset '".$depart."'");
    $reponses->execute(array($get_id)); 
} 
else {
    die('Erreur...'); 
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


           
            <table class="forum" border=10 align=center >
                <tr class="main1">
                    <th></th>
                    <th class="sujet_topic"><?php echo $tactique['nom'] ?><br />
                            <br /><?php echo $tactique['equipe'] ?><br /></th>
                </tr>
                <tr>
                    <td>
                        <br /><?php $auteur = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
                        $auteur->execute(array($tactique['id_membre']));
                        $auteur = $auteur->fetch();
                        echo $auteur['pseudo']; ?><br /><br />
                    </td>
                    <td>
                        <br /><?php echo $tactique['commentaire']; ?><br />
                        <p class="dh_creat"><br /><?php echo $tactique['dateheure_creat']; ?></p>
                    </td>
                </tr>
                <tr>
                    <td>Mon équipe</td>
                    <td>
                        <section>  
                                <div><br /><br />
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
                                </div>
                            
                                <br /><br /><br />
                                <aside class = "aside_accueil">
                                <table class="forum" border=3 align=center>
                                    <?php $joueur_tact = $bdd->prepare('SELECT * FROM tactique WHERE id = ?');
                                    $joueur_tact->execute(array($get_id));
                                    $joueur_tact=$joueur_tact->fetch();?>
                                    <tr>
                                        <td>joueur1</td>
                                        <td><?php echo $joueur_tact['joueur1']?></td>
                                    </tr>
                                    <tr>
                                        <td>joueur2</td>
                                        <td><?php echo $joueur_tact['joueur2']?></td>
                                    </tr>
                                    <tr>
                                        <td>joueur3</td>
                                        <td><?php echo $joueur_tact['joueur3']?></td>
                                    </tr>
                                    <tr>
                                        <td>joueur4</td>
                                        <td><?php echo $joueur_tact['joueur4']?></td>
                                    </tr>
                                    <tr>
                                        <td>joueur5</td>
                                        <td><?php echo $joueur_tact['joueur5']?></td>
                                    </tr>
                                    <tr>
                                        <td>joueur6</td>
                                        <td><?php echo $joueur_tact['joueur6']?></td>
                                    </tr>
                                    <tr>
                                        <td>joueur7</td>
                                        <td><?php echo $joueur_tact['joueur7']?></td>
                                    </tr>
                                    <tr>
                                        <td>joueur8</td>
                                        <td><?php echo $joueur_tact['joueur8']?></td>
                                    </tr>
                                    <tr>
                                        <td>joueur9</td>
                                        <td><?php echo $joueur_tact['joueur9']?></td>
                                    </tr>
                                    <tr>
                                        <td>joueur10</td>
                                        <td><?php echo $joueur_tact['joueur10']?></td>
                                    </tr>
                                    <tr>
                                        <td>joueur11</td>
                                        <td><?php echo $joueur_tact['joueur11']?></td>
                                    </tr>
                                </table> 
                            </aside> 
                        </section>
                        <br />
                    </td>
                </tr>
            </table>
            <br /><br />


            <table class="reponse" border=2>
                <tr class="main1">
                    <th ><br />Commentaire de :<br /><br /></th>
                    <th><br /></th>
                </tr>
                <?php while($c = $reponses->fetch()) { ?>
                <tr>
                    <td><?php $pseudo = $bdd->prepare('SELECT * FROM membre LEFT JOIN espace_com_tactique ON espace_com_tactique.id_posteur=membre.id WHERE espace_com_tactique.id_posteur = ?');
                    $pseudo->execute(array($c['id_posteur']));
                    $pseudo = $pseudo->fetch()['pseudo'];
                    echo $pseudo ?></td>
                    <td>
                        <?php echo $c['contenu'] ?><br />
                        <p class="dh_creat"><br /><?php echo $c['dateheure_post']; ?></p>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <br />
            

            <?php if(isset($_SESSION['id'])) { ?>
                <form method="POST">
                    <label>Postez un commentaire :</label> 
                    <textarea placeholder="Votre commentaire" name="tact_com"  rows="5" cols="75">
                    </textarea><br />
                    <input type="submit" name="tactique_com_submit" value="Poster mon commentaire"></form>
                </form>
                <?php if(isset($reponse_msg)) { 
                    echo $reponse_msg; 
                } ?>
            <?php } 
            else { ?>
                <p style="color:red"><FONT size="5em">Vous devez être connecté pour poster une réponse.</FONT></p>
            <?php } ?>
            <br /><br />

            
            <p class="page">
                <span class="page2">Vous êtes à la page <?php echo $pageCourante ?></span>
                <br />Page : 
                <?php for($i=1;$i<=$pagesTotales;$i++) {
                    if($i == $pageCourante) {
                        echo $i.' ';
                    } 
                    else {
                        echo '<a href="tact.php?id='.$get_id.'&page='.$i.'">'.$i.'</a>  ';
                    }
                }
                ?>
            </p>
            
            <br /><br /><br /><br />
            
           

            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>
    </body>
</html>
