<?php 
session_start();
$bdd = new PDO("mysql:host=localhost;dbname=MyM;charset=utf8", "root", "root");

require('functions.php');


if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $get_id = htmlspecialchars($_GET['id']);
    if(isset($_SESSION['id'])) {
        $tactique = $bdd->prepare('SELECT * FROM tactique WHERE id = ?');
        $tactique->execute(array($get_id));
        $tactique = $tactique->fetch();
        if(isset($_POST['commentaire_submit'])) {
            if(isset($_POST['tactique_commentaire']) AND !empty($_POST['tactique_commentaire'])) {
                $commentaire = htmlspecialchars($_POST['tactique_commentaire']);
                $ins = $bdd->prepare('INSERT INTO espace_com_tactique (id_tactique, id_posteur, contenu, dateheure_post) VALUES (?,?,?, NOW())');
                $ins->execute(array($get_id,$_SESSION['id'],$commentaire));
                $commentaire_msg = "<span style='color:green'>Votre commentaire a bien été posté</span>";
            } 
            else {
                $commentaire_msg = "<p style='color:red'>Commentaire vide</p>";
            }
        }
    }
    else {
        $reponse_msg = "Veuillez vous connecter ou créer un compte pour poster une réponse";
    }

    $commentaires = $bdd->prepare('SELECT * FROM espace_com_tactique WHERE id_tactique = ?');
    $commentaires->execute(array($get_id));


}
else {
    die("erreur...");
}

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
            <header>
                <div id="titre_principal">
                    <div id="logo">
                        <img src="images/le_logo.png" alt="Logo de MyManager" />
                        <h1>MyManager</h1>    
                    </div>
                    <h2>L'entraineur c'est toi</h2>
                    <br />
                </div>
                
                <nav>
                    <ul>
                        <?php if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {?>
                            <li><a href="<?php echo '/projet/views/accueil.php?id='.$_SESSION['id'];?>">Accueil</a></li>
                            <li><a href="<?php echo '/projet/views/tactique.php?id='.$_SESSION['id'] ?>">Tactiques</a></li>
                            <li><a href="<?php echo '/projet/views/joueurs.php?id='.$_SESSION['id'] ?>">Joueurs</a></li>
                            <li><a href="<?php echo '/projet/views/forum_accueil.php?id='.$_SESSION['id'] ?>">Forum</a></li>
                            <li><a href="<?php echo '/projet/views/profil.php?id='. $_SESSION['id']?>">Profil</a></li>
                        <?php } 
                        else { ?>
                            <li><a href="/projet/views/accueil.php">Accueil</a></li>
                            <li><a href="/projet/views/tactique.php">Tactiques</a></li>
                            <li><a href="/projet/views/joueurs.php">Joueurs</a></li>
                            <li><a href="/projet/views/forum_accueil.php">Forum</a></li>
                            <li><a href="/projet/views/connexion.php">Connexion</a></li>
                        <?php } ?>
                    </ul>
                </nav>
            </header>
            <div id="deconnexion">
                <?php if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {?>
                    <a href="/projet/views/deconnexion.php">Deconnexion</a>
                <?php } ?>
            </div>
            

            <!--La bannière-->
            <div id="banniere_image">
                <div id="banniere_description" >
                    <a href="https://www.footballmanager.com/fr" title="FM">Football Manager</a>
                    <a href="<?php echo '/projet/views/forum_accueil.php?id='.$_SESSION['id'] ?>" class="bouton_rouge">
                        Viens discuter sur notre Forum <img src="images/flecheblanchedroite.png" alt="" />
                    </a>
                </div>
            </div>
            <br /><br />

            <!--Le corps de la page-->
            <h1 class="titre">TACTIQUE</h1>
            <h2><img src="images/ico_joueur.png" alt="Joueur de football" class="ico_categorie" />Propose ta tactique et commente celle des autres</h2>
            <br /><br />




            <!--Espace Commentaire-->
            <h1 style="text-align: center;">Espace Commentaire</h1> 
            <table class="commentaire" border=2 style="color:white">
                <tr class="main1">
                    <th ><br />Commentaire de :<br /><br /></th>
                    <th><br /></th>
                </tr>
                <?php while($r = $commentaires->fetch()) { ?>
                <tr>
                    <td><?php $pseudo = $bdd->prepare('SELECT * FROM membre LEFT JOIN espace_com_tactique ON espace_com_tactique.id_posteur=membre.id WHERE espace_com_tactique.id_posteur = ?');
                    $pseudo->execute(array($r['id_posteur']));
                    $pseudo = $pseudo->fetch()['pseudo'];
                    echo $pseudo ?></td>
                    <td>
                        <?php echo $r['contenu'] ?><br />
                        <p class="dh_creat"><br /><?php echo $tactique['dateheure_creat']; ?></p>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <br /><br />

            <?php if(isset($_SESSION['id'])) { ?>
                <form method="POST">
                    <label>Postez un commentaire :</label> <br />
                    <textarea name="tactique_commentaire" placeholder="Votre commentaire sur cette tactique" rows="5" cols="75">
                        <?php if(isset($commentaire)) { 
                            echo $commentaire; 
                        } ?>
                    </textarea><br />
                    <input class ="submit_tactiques" type="submit" name="commentaire_submit" value="Poster mon commentaire"></form>
                </form>
            <?php } 
            else { ?>
                <p style="color:red"><FONT size="5em">Vous devez être connecté pour poster une réponse.</FONT></p>
            <?php } ?>
            <?php if (isset($commentaire_msg)) {
                echo $commentaire_msg;
            } ?>
  
            

            <br /><br /><br /><br />
            


            <!--Le footer du site-->
            <footer>

                <div id="contact">
                    <!--remplacer les # par les liens vers la page "Contactez nous"-->
                    <h1>Contactez nous</h1>
                    <p><a href="mailto:votrenom@bidule.com">Envoyez-moi un e-mail !</a></p>
                </div>

                <div id="aa">
                    <h1> </h1>
                </div>

                <div id="mes_photos">
                    <h1>Nos réseaux sociaux</h1>
                    <!--Changer le lien pour aller sur Facebook-->
                    <?php if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {?>
                    <p><a href="<?php echo '/projet/views/pasdeRS.php?id='.$_SESSION['id'] ?>">
                            <img src="images/facebook.png" alt="Facebook" />
                        </a>    
                        <a href="<?php echo '/projet/views/pasdeRS.php?id='.$_SESSION['id'] ?>">
                            <img src="images/twitter.png" alt="Twitter" />
                        </a>
                    </p>
                    <?php }
                    else { ?>
                    <p><a href="/projet/views/pasdeRS.php">
                            <img src="images/facebook.png" alt="Facebook" />
                        </a>    
                        <a href="/projet/views/pasdeRS.php">
                            <img src="images/twitter.png" alt="Twitter" />
                        </a>
                    </p>
                    <?php } ?>
                </div>
            </footer>
        </div>
    </body>
</html>
