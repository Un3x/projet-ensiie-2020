<?php
session_start();
include("db_connect.php");


require('functions.php');


if(isset($_GET['idjoueur']) AND !empty($_GET['idjoueur']) ) {
    $get_idjoueur = htmlspecialchars($_GET['idjoueur']);
    $nom_joueur = $bdd->prepare('SELECT nom FROM joueurs WHERE id = ?');
    $nom_joueur->execute(array($get_idjoueur));
    $nom_joueur = $nom_joueur->fetch();
    
    $prenom_joueur = $bdd->prepare('SELECT prenom FROM joueurs WHERE id = ?');
    $prenom_joueur->execute(array($get_idjoueur));
    $prenom_joueur = $prenom_joueur->fetch();

    if(isset($_POST['joueur_com_submit'],$_POST['joueur_com'])) {
        $commentaire = htmlspecialchars($_POST['joueur_com']);
        if(isset($_SESSION['id'])) {
            if(!empty($commentaire)) {
                
                $idv=$bdd->query('SELECT MAX(id) FROM espace_com_joueur');
                $idv=$idv->fetch()['max']+1;
                
                #check si db est vide car max vaut null
                if($idv==null){
                    $idv=1;
                }

                $ins = $bdd->prepare('INSERT INTO espace_com_joueur (id,id_joueur,id_posteur,dateheure_post,dateheure_edition,contenu) VALUES (?,?,?,NOW(),NOW(),?)');
                $ins->execute(array($idv,$get_idjoueur,$_SESSION['id'],$commentaire));


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
    $reponsesTotalesReq = $bdd->prepare('SELECT * FROM espace_com_joueur WHERE id_joueur = ?'); 
    $reponsesTotalesReq->execute(array($get_idjoueur));
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
    $reponses = $bdd->prepare("SELECT * FROM espace_com_joueur WHERE id_joueur = ? ORDER BY id ASC LIMIT '".$reponsesParPage."'  offset '".$depart."'"); 
    $reponses->execute(array($get_idjoueur));

} 
else {
    die('Erreur... pas le bon id');
}

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
            <?php 
                $pseudo_joueur = $bdd->prepare('SELECT * FROM joueurs WHERE id = ?');
                $pseudo_joueur->execute(array($get_idjoueur));
                $pseudo_joueur=$pseudo_joueur->fetch();
            ?>
            <h1 class="titre"><?php echo $pseudo_joueur['prenom']." ".$pseudo_joueur['nom'] ;?></h1>
            

            <section>
                
                <article>
                    <section class="joueur_info">
                    
                    <?php 
                    $nation_joueur = $bdd->prepare('SELECT * FROM joueurs RIGHT JOIN nation on nation.id = joueurs.nation_id WHERE joueurs.id = ?');
                    $nation_joueur->execute(array($get_idjoueur));
                    $nation_joueur=$nation_joueur->fetch();
                    ?>
                    <p> 
                        Nom : <?php echo $pseudo_joueur['nom'] ;?><br />
                        Prénom : <?php echo $pseudo_joueur['prenom'] ;?><br />
                        Age : <?php echo $pseudo_joueur['age'] ;?><br />
                        Nationalité : <?php echo $nation_joueur['nom'];?><br />
                        Valeur : <?php echo $nation_joueur['valeur'];?>M €<br />
                        Note :  <?php echo $nation_joueur['note'];?> étoiles
                    </p>
                    </section>
                    <br />
                    <p style="font-size:1.2em">Statistques : <br />
                        <ul style="font-size:1.2em">
                            <li>Attaque : <?php echo $pseudo_joueur['attaque'];?></li><br />
                            <li>Défense : <?php echo $pseudo_joueur['defense'];?></li><br /> 
                            <li>Technique : <?php echo $pseudo_joueur['technique'];?></li><br /> 
                        </ul>
                    </p>
                    <br /><br />
                    <p style="font-size:1.2em">
                        Note des utilisateurs : <?php echo $pseudo_joueur['note_utilisateur'];?><br /><br />
                        <rating>
                            <h2>Notes ce joueur aussi:</h2>
                                <div class="rating"><!--
                                    --><a href="#1" title="Donner 1 étoiles">*</a><!--
                                    --><a href="#2" title="Donner 2 étoiles">*</a><!--
                                    --><a href="#3" title="Donner 3 étoiles">*</a><!--
                                    --><a href="#4" title="Donner 4 étoiles">*</a><!--
                                    --><a href="#5" title="Donner 5 étoiles">*</a>
                                </div>
                        </rating>
                    </p>
                    
                </article>

            </section>
            <br /><br />


            <!--Espace Commentaire-->
            
            <table class="reponse" border=3>
                <tr class="main1" style="color:white">
                    <th  style="font-size:1.3em"><br />Commentaire de :<br /><br /></th>
                    <th><br /></th>
                </tr>
                <?php while($c = $reponses->fetch()) {  ?>
                <tr>
                    <td style="color:white; text-align:center" ><?php $pseudo = $bdd->prepare('SELECT * FROM membre LEFT JOIN espace_com_joueur ON espace_com_joueur.id_posteur=membre.id WHERE espace_com_joueur.id_posteur = ?');
                    $pseudo->execute(array($c['id_posteur']));
                    $pseudo = $pseudo->fetch()['pseudo'];
                    echo $pseudo ?></td>
                    <td style="color:white"> 
                        <?php echo $c['contenu'] ?><br />
                        <p class="dh_creat"><br /><?php echo $c['dateheure_post']; ?></p>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <br />


            <p class="page" style="font-size:1.3em">
                <span class="page2">Vous êtes à la page <?php echo $pageCourante ?></span>
                <br />Page : 
                <?php for($i=1;$i<=$pagesTotales;$i++) {
                    if($i == $pageCourante) {
                        echo $i.' ';
                    } 
                    else {
                        echo '<a href="/projet/views/joueurs_recherche.php?idjoueur='.$get_idjoueur.'&page='.$i.'">'.$i.'</a> ';
                    }
                }
                ?>
            </p><br /><br />


            <?php if(isset($_SESSION['id'])) { ?>
                <form method="POST">
                    <label>Postez un commentaire :</label><br />
                    <textarea placeholder="Votre commentaire" name="joueur_com"  rows="5" cols="75">
                        
                    </textarea><br />
                    <input type="submit" name="joueur_com_submit" value="Poster mon commentaire"></form>
                </form>
                <?php if(isset($reponse_msg)) { 
                    echo $reponse_msg; 
                } ?>
            <?php } 
            else { ?>
                <p style="color:red"><FONT size="5em">Vous devez être connecté pour poster une réponse.</FONT></p>
            <?php } ?>
            <br /><br />

            <div id="joueur_retour"> 
                <?php if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {?>
                    <a href="<?php echo '/projet/views/joueurs.php?id='.$_SESSION['id'] ?>">Revenir sur la recherche de joueur</a>
                <?php } 
                else { ?>
                    <a href="/projet/views/joueurs.php">Revenir sur la recherche de joueur</a>
                <?php } ?>
            </div>
            <br /><br /><br />


            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>
    </body>
</html>
