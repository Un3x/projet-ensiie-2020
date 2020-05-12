<!DOCTYPE html>
<html>
  <head>
    <base href="/"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Blog : <?= $req['titre'] ?></title>
    <link rel="stylesheet" href="../css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../css/style.css"/>
  </head>
  <body>
    <?php
      require_once('../menu.php');    
    ?>
    <div class="container">
      <div class="row" style="margin-top: 20px">  
        <div class="col-sm-12 col-md-12 col-lg-12">
          <?php

    if(!empty($_POST)){
    extract($_POST);
    $valid = true;
 
    if (isset($_POST['ajout-commentaire'])){
      $text  = (String) trim($text); 
      if(empty($text)){
        $valid = false;
        $er_commentaire = "Il faut mettre un commentaire";
      }elseif(iconv_strlen($text, 'UTF-8') <= 3){
        $valid = false;
        $er_commentaire = "Il faut mettre plus de 3 caractères";
      }
 
      $text = htmlentities($text);
 
      if($valid){
        $date_creation = date('Y-m-d H:i:s');
        $DB->insert("INSERT INTO blog_commentaire (id_user, id_blog, text, date_creation) VALUES (?, ?, ?, ?)", 
          array($_SESSION['id'], $get_id, $text, $date_creation));
          header('Location: /blog/' . $get_id);
          exit; 
      }
    }
  }
?>  
          <?php
            if(isset($_SESSION['id'])){
          ?>
          <div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px; margin-top: 20px">
            <h3>Participer à l'article</h3>
            <?php
              /* S'il y a une erreur sur le nom alors on affiche */
              if (isset($er_commentaire)){
            ?>
            <div class="er-msg"><?= $er_commentaire ?></div>
            <?php   
              }
            ?>
            <form method="post">
              <div class="form-group">
                <textarea class="form-control" name="text" rows="4" placeholder="Écrivez-votre commentaire ..."></textarea>
              </div>
              <div class="form-group">
                <button class="btn btn-primary" type="submit" name="ajout-commentaire">Envoyer</button>
              </div>
            </form>
          </div>
          <?php
            }   
          ?>       
          <div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px; margin-top: 20px">
            <h3>Commentaires</h3>
            <?php
              foreach($req_commentaire as $rc){ 
            ?>  
            <div style="background: #eee; margin-top: 20px; padding: 5px 10px; border-radius: 10px">
              <div style="font-weight: bold"><?= "De " . $rc['nom'] . " " . $rc['prenom']  . " : "?></div>
              <?= nl2br($rc['text']) ?>
              <div style="text-align: right; font-size: 12px; color: #665"><?= $rc['date_c'] ?></div>
            </div>
            <?php
              }
            ?>
          </div>  
        </div>
      </div>
    </div>﻿
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>