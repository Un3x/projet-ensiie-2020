<?php
session_start();
include("db_connect.php");


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
else if ($_GET['categorie']=="annonces") {
    $nomcateg="Annonces";
}

if(isset($_GET['categorie']) AND !empty($_GET['categorie'])) {
    $get_categorie = htmlspecialchars($_GET['categorie']);
    $categories = array();
    $req_categories = $bdd->query('SELECT * FROM f_categories');
    while($c = $req_categories->fetch()) {
       array_push($categories, array($c['id'],url_custom_encode($c['nom'])));
    }
    foreach($categories as $cat) {
       if(in_array($get_categorie, $cat)) {
          $id_categorie = intval($cat[0]);
       }
    }

    if($id_categorie) {
        if(isset($_GET['souscategorie']) AND !empty($_GET['souscategorie'])) {
            $get_souscategorie = htmlspecialchars($_GET['souscategorie']);
            $souscategories = array();
            $req_souscategories = $bdd->prepare('SELECT * FROM f_souscategories WHERE id_cate = ?');
            $req_souscategories->execute(array($id_categorie));
            while($c = $req_souscategories->fetch()) {
                array_push($souscategories, array($c['id'],url_custom_encode($c['nom'])));
            }
            foreach($souscategories as $cat) {
                if(in_array($get_souscategorie, $cat)) {
                    $id_souscategorie = intval($cat[0]);
                }
            }
        }
        $req = "SELECT * FROM f_topics  
        LEFT JOIN f_topicscate ON f_topics.id = f_topicscate.id_topic 
        LEFT JOIN f_categories ON f_topicscate.id_cate = f_categories.id
        LEFT JOIN f_souscategories ON f_topicscate.id_souscate = f_souscategories.id
        LEFT JOIN membre On f_topics.id_createur = membre.id
        WHERE f_categories.id = ? ";
  
        if($id_souscategorie) {
            $req .= " AND f_souscategories.id = ?";
            $exec_array = array($id_categorie,$id_souscategorie);
            $a=5;
        } 
        else {
            $exec_array = array($id_categorie);
        }
  
        $req .= " ORDER BY f_topics.id DESC";

        $topics = $bdd->prepare($req);
        $topics->execute($exec_array);
    } 
    else {
        die('Erreur: 1 - Catégorie introuvable...');
    }
} 
else {
    die('Erreur: 1 - Vous n\'avez pas sélectionné de catégorie ou elle n\'existe pas...');
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
            
            


            <!--Banniere-->
            <div id="banniere_accueil">
                <div id="banniere_description">
                    <a href="https://www.footballmanager.com/fr" title="FM">
                        Football Manager
                    </a>
                    
                </div>
            </div>
            


            <!--Corps-->
            <br /><br />
            <h2 class="titre_forum">TOPICS</h2>
            
            <table class="cate" border=10 align=center >
            <tr><th>Bienvenue dans la Catégorie <?php echo $nomcateg ?></th></tr>
            </table>
            <br />

            <table class="forum" border="10" align="center">
                <tr class="header">
                    <th class="main">Sujets</th>
                    <th class="sub_info">Sous catégorie</th>
                    <th class="sub_info">Dernière réponse</th>
                </tr> 
                <?php while ($t=$topics->fetch()) {?>
                <tr>
                    <td class="main_topic">
                        <h4>
                        
                        <a href="/projet/views/topic.php?id=<?= $t['id_topicscate'] ?>"><?php echo $t['sujet'] ?></a><br /> 

                            
                        </h4>
                        <p class="contenu"><?php echo $t['contenu'] ?></p>
                        <p class="dateheureauteur">Le <?php echo $t['dateheure_creat'] ?> par <?= $t['pseudo'] ?> !</p>
                    </td>
                    <td class="sub-info">
                        <?php $sscateg = $bdd->query("SELECT * FROM f_souscategories 
                                LEFT JOIN f_topicscate ON f_souscategories.id = f_topicscate.id_souscate 
                                LEFT JOIN f_topics ON f_topicscate.id_topic = f_topics.id 
                                WHERE f_topics.sujet ='".$t['sujet']."'");
                                $c=$sscateg->fetch();
                                echo $c['nom'];
                        ?>
                    </td>
                    <td class="sub-info">

                        <?php $rep = $bdd->prepare("SELECT * FROM f_messages 
                        LEFT JOIN f_topics ON f_topics.id = f_messages.id_topic 
                        WHERE f_topics.id = ? 
                        ORDER BY f_messages.dateheure_post DESC ");
                        $rep->execute(array($t['id_topic']));

                        if($rep->rowCount() > 0) {  
                            $rep = $rep->fetch();
                            $dr = $rep['dateheure_post'];
                            $pseudo = $bdd->prepare("SELECT * FROM membre LEFT JOIN f_messages ON f_messages.id_posteur=membre.id WHERE f_messages.id_posteur = ?");
                            $pseudo->execute(array($rep['id_posteur']));
                            $pseudo = $pseudo->fetch()['pseudo'];
                        
                            $dr .= '<br /> de '.$pseudo;
                        } 
                        else {
                            $dr = 'Aucune réponse...';
                        }
                        echo $dr;?>
                    </td>
                    
                </tr> 
                <?php } ?>
            </table>
            <br />
            <p class="create_topic">
                <?php if($nomcateg!="Annonces") { ?>
                    <a href="/projet/views/forum_newtopic.php?categorie=<?php echo $id_categorie?>">
                        Créer un nouveau topic 
                    </a>
                <?php } 
                else {
                    $admin= $bdd->prepare('SELECT * FROM membre WHERE id=?');
                    $admin->execute(array($_SESSION['id']));
                    $admin=$admin->fetch();
                    if($admin['m_admin']==1){?>
                        <a href="/projet/views/forum_newtopic.php?categorie=<?php echo $id_categorie?>">
                        Créer un nouveau topic
                    </a>
                    <?php }
                } ?>
            </p>
            <br /><br /><br />

        
           



            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>
    </body>
</html>
