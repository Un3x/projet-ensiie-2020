<?php
session_start();
include("db_connect.php");

//$categorie = $bdd->query('SELECT * FROM f_categories ORDER BY id');
//$sscate = $bdd->prepare('SELECT * FROM f_souscategories WHERE id_cate = ? ORDER BY id');


require('functions.php');


if(isset($_GET['id']) AND !empty($_GET['id'])) {
    
    $get_id = htmlspecialchars($_GET['id']);

        $topic = $bdd->prepare('SELECT * FROM f_topics WHERE id = ?');
        $topic->execute(array($get_id));
        $topic = $topic->fetch();

        if(isset($_POST['topic_reponse_submit'],$_POST['topic_reponse'])) {
            $reponse = htmlspecialchars($_POST['topic_reponse']);
            if(isset($_SESSION['id'])) {
               if(!empty($reponse)) {
                  
                  $idv=$bdd->query('SELECT MAX(id) FROM f_messages');
                  $idv=$idv->fetch()['max']+1;
                  
                  #check si db est vide car max vaut null
                  if($idv==null){
                      $idv=1;
                  }

                  $ins = $bdd->prepare("INSERT INTO f_messages(id, id_topic,id_posteur,dateheure_post,dateheure_edition,meilleur_reponse,contenu) VALUES (?,?,?,NOW(),NOW(),0,?)");
                  $ins->execute(array($idv,$get_id,$_SESSION['id'],$reponse));


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
    $reponsesTotalesReq = $bdd->prepare('SELECT * FROM f_messages WHERE id_topic = ?'); 
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
    $reponses = $bdd->prepare("SELECT * FROM f_messages WHERE id_topic = ? ORDER BY id ASC LIMIT '".$reponsesParPage."'  offset '".$depart."'"); 
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

            


            <div id="banniere_accueil">
                <div id="banniere_description">
                    <a href="https://www.footballmanager.com/fr" title="FM">
                        Football Manager
                    </a>
                </div>
            </div>
            <br /><br /><br />


           
            <table class="forum" border=10 align=center >
                <tr class="main1">
                    <th class="auteur"><br />Auteur<br /><br /></th>
                    <th class="sujet_topic"><br /><?php echo $topic['sujet'] ?><br /><br /></th>
                </tr>
                <tr>
                    <td>
                        <br /><?php $auteur = $bdd->prepare('SELECT * FROM membre WHERE id = ?');
                        $auteur->execute(array($topic['id_createur']));
                        $auteur = $auteur->fetch();
                        echo $auteur['pseudo']; ?><br /><br />
                    </td>
                    <td>
                        <br /><?php echo $topic['contenu']; ?><br />
                        <p class="dh_creat"><br /><?php echo $topic['dateheure_creat']; ?></p>
                        <div id="edit">
                            <br /><?php if(isset($_SESSION['id']) && $_SESSION['id']==$topic['id_createur']) {?>
                                <a href="<?php echo '/projet/views/forum_edit.php?id='.$_SESSION['id'].'&id_topic='.$topic['id'] ?>"> Modifier le message </a><br /><br />
                            <?php } ?>
                        </div>
                    </td>
                </tr>
            </table>
            
            <br /><br />


            <?php if(isset($_SESSION['id'])) { ?>
                <form method="POST">
                    <label>Postez une réponse :</label> 
                    <textarea name="topic_reponse" placeholder="Votre réponse" rows="5" cols="75">
                       
                    </textarea><br />
                    <input type="submit" name="topic_reponse_submit" value="Poster ma réponse"></form>
                </form>
                <?php if(isset($reponse_msg)) { 
                    echo $reponse_msg; 
                } ?>
            <?php } else { ?>
                <p style="color:red"><FONT size="5em">Vous devez être connecté pour poster une réponse.</FONT></p>
            <?php } ?>
            <br /><br />


            <table class="reponse" border=2>
                <tr class="main1">
                    <th ><br />Réponse de :<br /><br /></th>
                    <th><br /></th>
                </tr>
                <?php while($r = $reponses->fetch()) { ?>
                <tr>
                    <td><?php $pseudo = $bdd->prepare('SELECT * FROM membre LEFT JOIN f_messages ON f_messages.id_posteur=membre.id WHERE f_messages.id_posteur = ?');
                    $pseudo->execute(array($r['id_posteur']));
                    $pseudo = $pseudo->fetch();
                    echo $pseudo['pseudo'] ?></td>
                    <td>
                        <?php echo $r['contenu'] ?><br />
                        <p class="dh_creat"><br /><?php echo $r['dateheure_post']; ?></p>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <br />
            
            
            <p class="page">
                <span class="page2">Vous êtes à la page <?php echo $pageCourante ?></span>
                <br />Page : 
                <?php for($i=1;$i<=$pagesTotales;$i++) {
                    if($i == $pageCourante) {
                        echo $i.' ';
                    } 
                    else {
                        echo '<a href="topic.php?titre='.$get_titre.'&id='.$get_id.'&page='.$i.'">'.$i.'</a> ';
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
