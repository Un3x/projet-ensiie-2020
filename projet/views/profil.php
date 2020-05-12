<?php
session_start();
include("db_connect.php");

$reqadmin=$bdd->prepare('SELECT m_admin FROM membre WHERE id=?');
$reqadmin->execute(array($_SESSION['id']));
$reqadmin->fetch();
if(isset($reqadmin) AND !empty($reqadmin)){

        if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
            $supprime = (int) $_GET['supprime'];
            $req = $bdd->prepare("DELETE FROM membre WHERE id=?");
            $req->execute(array($supprime));
        }    
        $membre = $bdd->query('SELECT * FROM membre ORDER BY id ASC');
        
    }


if(isset($_GET['id']) AND $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requtilisateur = $bdd->prepare("SELECT * FROM membre WHERE id=?");
    $requtilisateur->execute(array($getid));
    $utilisateurinfo = $requtilisateur->fetch();
    

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

            <div id="prof_info">  
                <h1>Profil de <?php if($utilisateurinfo['m_admin']==1){
                    echo $utilisateurinfo['pseudo']." (admin)";
                } 
                else {
                    echo $utilisateurinfo['pseudo'];
                }  ?></h1>
                <br />
                Nom : <?php if (!empty($utilisateurinfo['nom'])){
                        echo $utilisateurinfo['nom']; 
                    }
                    else {?>
                        <span style="color : red">Non renseigné encore</span>
                    <?php } ?>
                <br /><br />
			    Prénom : <?php if (!empty($utilisateurinfo['prenom'])){
                        echo $utilisateurinfo['prenom']; 
                    }
                    else {?>
                        <span style="color : red">Non renseigné encore</span>
                    <?php } ?>
                <br /><br />
                Pseudo : <?php if (!empty($utilisateurinfo['pseudo'])){
                        echo $utilisateurinfo['pseudo']; 
                    }
                    else {?>
                        <span style="color : red">Non renseigné encore</span>
                    <?php } ?>
			    <br /><br />
                Mail : <?php if (!empty($utilisateurinfo['mail'])){
                        echo $utilisateurinfo['mail']; 
                    }
                    else {?>
                        <span style="color : red">Non renseigné encore</span>
                    <?php } ?>
                <br /><br />
                Club de coeur: <?php if (!empty($utilisateurinfo['club'])){
                        echo $utilisateurinfo['club']; 
                    }
                    else {?>
                        <span style="color : red">Non renseigné encore</span>
                    <?php } ?>
                <br /><br />
                Version : <?php if (!empty($utilisateurinfo['m_version'])){
                        echo $utilisateurinfo['m_version']; 
                    }
                    else {?>
                        <span style="color : red">Non renseigné encore</span>
                    <?php } ?>
            </div>
			<br /><br /><br />

            <div id="edit"> 
		        <?php if(isset($_SESSION['id']) AND $utilisateurinfo['id'] == $_SESSION['id']) { ?>
                    </br >Viens compléter ton profil </br >
                    <a href="<?php echo '/projet/views/edit.php?id='. $_SESSION['id']?>">Editer mon profil</a>
                <?php } ?>
		    </div>
            <br /><br />
			
			<div class="admin">
            <?php if($utilisateurinfo['m_admin']==1) { ?>
                <?php $nb_nombre = $bdd->query('SELECT * FROM membre'); ?>
                
                <table border="3" class="les_infos">
                    <th><h2>Les derniers arrivés</h2></th>
                    <?php while($m = $membre->fetch()){ ?> 
                        <tr>
                                <td><?php echo $m['pseudo'] ?></td>
                                <td><a href="<?php echo '/projet/views//profil.php?id='.$_SESSION['id'].'&supprime='.$m['id'] ?>">Supprimer</a></td>
                            </tr>
                        <?php } ?>
                </table><br /><br /><br /><br />
                
                <table border="3" class="les_infos">
                    <th><h1>Les petites informations sur le site</h1></th>
                    <tr>
                        <td><br />
                    Générale :<br />
                        <ul>
                            <li>Nombres de personnes inscrites : <?php echo $nb_nombre->rowCount();?><br /><br /></li>
                        </ul>
                    Forum : <br />
                        <ul>
                            <li>Nombres de topics dans le forum : <?php $nb_topics = $bdd->query('SELECT * FROM f_topics');
                                echo $nb_topics->rowCount();?><br /><br /></li>
                            <li>Nombres de réponses postées dans le forum : <?php $nb_rep = $bdd->query('SELECT * FROM f_messages');
                                echo $nb_rep->rowCount();?><br /><br /></li>
                        </ul>
                    Tactique : <br />
                        <ul>
                            <li>Nombres de tactiques postées : <?php $nb_tact = $bdd->query('SELECT * FROM tactique');
                                echo $nb_tact->rowCount();?><br /><br /></li>
                            <li>Nombres de commentaire sur les tactiques : <?php $nb_com_tact = $bdd->query('SELECT * FROM espace_com_tactique');
                                echo $nb_com_tact->rowCount();?><br /><br /></li>
                        </ul>
                    Joueur : <br />
                        <ul>
                            <li>Nombres de joueurs disponibles : <?php $nb_joueurs = $bdd->query('SELECT * FROM joueurs');
                                echo $nb_joueurs->rowCount();?><br /><br /></li>
                            <li>Nombres de commentaire sur les joueurs : <?php $nb_com_jou = $bdd->query('SELECT * FROM espace_com_joueur');
                                echo $nb_com_jou->rowCount();?><br /><br /></li>
                        </ul>
                    </td>
                    </tr>
                    
                </table><br /><br /><br />
            <?php } ?>

            <table border="3" class="les_infos">
                    <th><h1>Mon activité</h1></th>
                    <tr>
                        <td><br />
                    Forum : <br />
                        <ul>
                            <li>Nombre de topics postés : <?php $nb_topics = $bdd->query('SELECT * FROM f_topics WHERE id_createur='.$_SESSION['id']);
                            echo $nb_topics->rowCount();?><br /><br /></li>
                            <li>Nombres de réponses postées dans le forum : <?php $nb_rep = $bdd->query('SELECT * FROM f_messages WHERE id_posteur='.$_SESSION['id']);
                                echo $nb_rep->rowCount();?><br /><br /></li>
                        </ul>
                    Tactique : <br />
                        <ul>
                            <li>Nombres de tactiques postées : <?php $nb_tact = $bdd->query('SELECT * FROM tactique WHERE id_membre='.$_SESSION['id']);
                                echo $nb_tact->rowCount();?><br /><br /></li>
                            <li>Nombres de commentaire sur les tactiques : <?php $nb_com_tact = $bdd->query('SELECT * FROM espace_com_tactique WHERE id_posteur='.$_SESSION['id']);
                                echo $nb_com_tact->rowCount();?><br /><br /></li>
                        </ul>
                    Joueur : <br />
                        <ul>
                            <li>Nombres de commentaire sur les joueurs : <?php $nb_com_jou = $bdd->query('SELECT * FROM espace_com_joueur WHERE id_posteur='.$_SESSION['id']);
                                echo $nb_com_jou->rowCount();?><br /><br /></li>
                        </ul>
                    </td>
                    </tr>
                    
                </table><br /><br />
            </div>
            
            
            <div id="edit"> 
		        <?php if(isset($_SESSION['id']) AND $utilisateurinfo['id'] == $_SESSION['id']) { ?>
                    </br >Tu veux te déconnecter ? Alors à la prochaine !</br >
                    <a href="deconnexion.php">Se déconnecter</a>
                <?php } ?>
		    </div>
            <br /><br /><br />

            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>
    </body>
</html>
<?php
  }
?>
