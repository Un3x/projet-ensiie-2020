<?php 

	session_start();

	include '../src/Factory/DbAdaperFactory.php';
  include 'dateFr.php';
    $contenu = trim(htmlentities($_GET['contenu']));

    if(empty($contenu)){
      header('Location: index.php');
      exit;
    }

  	$dbAdapter = (new DbAdaperFactory())->createService();

  	$oeuvre_select = $dbAdapter->prepare("SELECT * FROM Oeuvre WHERE titre=?");
  	$oeuvre_select->execute(array($_GET['contenu']));
    $oeuvre = $oeuvre_select->fetch();

    if(!isset($oeuvre['numero'])){
      header('Location: index.php');
      exit;
    }

    if(!isset($oeuvre['lien_photo'])){
      header('Location: index.php');
      exit;
    }

    $titre=$oeuvre['titre'];
    $lien_photo=$oeuvre['lien_photo'];
  	$idOeuvre=$oeuvre['numero'];

    $req_commentaire = $dbAdapter->prepare("SELECT * FROM Commentaire WHERE numero = ? ORDER BY date_com DESC");
    $req_commentaire->execute(array($idOeuvre));
    $req_commentaire = $req_commentaire->fetchAll();

    $nbr_notes= $dbAdapter->prepare('SELECT COUNT(note) AS note FROM Noter WHERE Noter.numero = ?');
    $nbr_notes->execute(array($idOeuvre));
    $nbr_notes=$nbr_notes->fetch();
    $nb_notes=$nbr_notes['note'];

    if ($nb_notes>0){
      $note_moyenne_array = $dbAdapter->prepare('SELECT AVG(note) AS note FROM Noter WHERE Noter.numero = ?');
      $note_moyenne_array->execute(array($idOeuvre));
      $note_moyenne_array = $note_moyenne_array->fetch();
      $note_moyenne=number_format($note_moyenne_array['note'],$decimals = 1);
      if($nb_notes==1){
        $str_notes=$note_moyenne."/5"." (".$nb_notes." note)";
      }
      else{
        $str_notes=$note_moyenne."/5"." (".$nb_notes." notes)";
      }
      

    }
    else{
      $str_notes="(Pas encore noté)";
    }

  	if (!empty($_POST)){
  		extract($_POST);
  		$valid=true;

	  	if (isset($_POST['ajout-commentaire'])){
	      	$text  = (String) trim($text); 
	      	if(empty($text)){
	        	$valid = false;
	        	$er_commentaire = "Il faut mettre un commentaire";
		    }
		    elseif(iconv_strlen($text, 'UTF-8') <= 3){
		        $valid = false;
		        $er_commentaire = "Il faut mettre plus de 3 caractères";
		   	}
		 
		    $text = htmlentities($text);
		 
		    if($valid){
		        $date_creation = date('Y-m-d H:i:s');
		        $com = $dbAdapter->prepare("INSERT INTO Commentaire(pseudo,numero, texte, date_com) 
		        	VALUES(?, ?, ?, ?)");
		        $com->execute(array($_SESSION['username'],$idOeuvre,$text, $date_creation)); 
		        header('Location: /resultat-search.php?contenu='.$_GET['contenu']);
		        exit;
	      }
	  }
  } 		
?>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Medialiste</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Le grand trac">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="/css/all.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
</head>
<body>
<header >
    <nav class="navbar  navbar-expand-lg navbar-dark bg-dark">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a class="navbar-brand" href="/index.php">Medialiste</a>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="top.php">Top commu</a>
                 </li> 

                <li class="nav-item">
                  <a class="nav-link" href="agenda.php">Agenda</a>
                </li>  

                <li class="nav-item">
                  <a class="nav-link" href="affichageOeuvre.php">Oeuvres</a>
                </li>  

                <?php
                    if(isset($_SESSION['username'])){
                      ?>
                <li class="nav-item">
                  <a class="nav-link" href="mylists.php">Mes Listes</a>
                </li>  
                <?php 
                }
                if (isset($_SESSION['statut']) && $_SESSION['statut']==true){
                  ?>
                  <li class="nav-item">
                    <a class="nav-link" href="administration.php">Administration</a>
                  </li>
                  <?php
                }
                ?>
                <li class="nav-item">
                  <div class="container-research">
                    <form class="form-inline my-2 my-lg-0" method="get" action="resultat-search.php">            
                      <input class="form-control mr-sm-2 rounded-pill" type="search" name="contenu" onkeyup="showHint(this.value)" id="txt1" placeholder="Rechercher une oeuvre"/>       
                      <button type="submit" class="btn btn-outline-success my-2 my-sm-0 rounded-pill"><i class="fas fa-search"></i></button>
                    </form>
                  </div>
                  <div class = "show-autocomplete rounded"> 
                    <span class="autocomplete" id="txtHint"></span>
                  </div>
                </li>
              </ul>
                  <?php
                    if(isset($_SESSION['username'])){
                      ?>
                    <ul class="navbar-nav text-right">
                      <div class="d-flex flex-row-reverse">
                      <li class="nav-item" style="float:right">
                        <a class="nav-link" class="nav-button"  href="profil.php" >Mon profil</a>
                      </li>
                      <li class="nav-item" style="float:right">
                        <a class="nav-link" class="nav-button" href="logout.php">Déconnexion</a>
                      </li>
                    </ul>
                      <?php
                    }
                    else { 
                      ?>
                    <ul class="navbar-nav text-right">
                      <li class ="nav-item" style="float:right">
                        <a class="nav-link" class="nav-button" href="/signIn.php">Se connecter</a>
                      </li> 
                      <li class="nav-item" style="float:right">                                 
                        <a class="nav-link" class="nav-button" href="/signUp.php">S'inscrire</a>
                      </li>
                      </ul>
                      <?php
                  }
                  ?>          
            
        </div>
      </nav>        
</header>

  <div class = "container" style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15);  margin-top: 2%; min-height:max-content; padding-bottom:0">
      <div class="card border-0" >
        
          <div style="float:left">
            <?php echo '<img src="'.$lien_photo.'"alt="'.$titre.'" style="max-width: 80%;max-height: 50%;"/>';?>
          </div>
          <div style="float:right">
            <div class="card-body">
              <h1 class="card-title"><?= $oeuvre['titre']; ?></h1>
              <p class="card-text" style="max-width: 100%"><?= $oeuvre['synopsis'] ?></p>
              <p class="card-text"><small class="text-muted">Note : 
                <?= $str_notes ?> </small></p>
            </div>
          </div>
      </div>
      <hr/>

        <?php
        if(isset($_SESSION['username'])){
        
          ?>
          <div class="container interaction-oeuvre">
            <div style="padding-right: 5%">
              <form method="GET" action="notation.php">
                <h3>Quelle note donnez-vous à cette oeuvre ?</h3>
                <input type="radio" name="note" id="1" value=1>
                <label for="1">Mauvais</label>
                <input type="radio" name="note" id="2" value=2>
                <label for="2">Moyen</label>
                <input type="radio" name="note" id="3" value=3>
                <label for="3">Bon</label>
                <input type="radio" name="note" id="4" value=4>
                <label for="4">Très bon</label>
                <input type="radio" name="note" id="5" value=5>
                <label for="5">Excellent</label>
                <input type="hidden" name="contenu" value="<?=$_GET['contenu']?>">
                <button class="btn btn-outline-success my-2 my-sm-0 rounded-pill" type="submit">Valider</button>
              </form>
            </div>
            <div style="border-left: 1px solid rgba(0,0,0,.1);height:auto"></div>
            <div id="Ajout" style="padding-left: 5%">
              <h3>Ajouter à ma liste</h3>
              <form method="GET" action="addOeuvreListe.php">
              <div class="formfield-select ">
                <div class="formfield-select--container rounded-pill">
                  <select class="formfield-select--container" name="id_liste">

                    <?php

                      $nom_liste = $dbAdapter->prepare("SELECT * 
                        FROM Liste JOIN Ravoir ON Liste.id=Ravoir.id_liste WHERE Ravoir.pseudo=?"); // Il faut encore tester si jamais l'oeuvre est déjà dans la liste //
                      $nom_liste->execute(array($_SESSION['username']));
                      $listes = $nom_liste->fetchAll();

                      foreach($listes as $liste):

                      ?>

                      <option value="<?= $liste['id'] ?>"><?= $liste['nom_liste'] ?></option>

                      <?php
                      endforeach;
                      ?>

                  </select>
                </div>
              </div>
                <input type="hidden" name="nom_oeuvre" value="<?= $titre ?>">
                <button class="btn btn-outline-success my-2 my-sm-0 rounded-pill" type="submit">Ajouter</button>
              </form>
            </div>
          </div>

    		<div class="container ajout-commentaire" style="background: white;  margin-top: 2%">
    			<?php
                /* S'il y a une erreur sur le nom alors on affiche */
                if (isset($er_commentaire)){
              ?>

              	<div class="er-msg"><?= $er_commentaire ?></div>

              <?php   
                }
          if(!$_SESSION['banni']){
            ?>
          <hr/>
    			<h3>Ajoutez un commentaire</h3>
  	  		<form method="post">
  	            <div class="form-group">
  	              <textarea class="form-control" name="text" rows="4" placeholder="Soyez constructif ..."></textarea>
  	            </div>
  	            <div class="form-group">
  	              <button type="submit" class="btn btn-outline-success my-2 my-sm-0 rounded-pill" name="ajout-commentaire" onclick=""><i class="fas fa-paper-plane"></i> Envoyer</button>
  	            </div>
  	        </form>
        </div>
            <?php
          }
        }
        $n=$dbAdapter->prepare('SELECT COUNT(texte) FROM Commentaire WHERE numero = ?');
        $n->execute(array($idOeuvre));
        $n=$n->fetch();
          ?>
  	        <div class="container rounded-0" style="background: white;  margin-top: 2%; border-radius: 10px">

            <hr/>
              <h3>Commentaires (<?= $n[0]?>)</h3>
              
              <?php
                foreach($req_commentaire as $rc){ // Affichage des commentaires un à un 
              ?>  

              <div class="container"  style="background: #eee; margin-top: 20px; border-radius: 10px">
                  
                  <div style=" text-align:center;">
                  <div style="font-weight: bold;display: inline-block"> <?= $rc['pseudo']?> </div>
                  <?php
                  $ami = $dbAdapter->prepare('SELECT suivi FROM Suivre WHERE suivi=? AND suiveur=?');
                  $ami->execute(array($rc['pseudo'],$_SESSION['username']));
                  if ($rc['pseudo']!=$_SESSION['username']){
                  if ( !($ami = $ami->fetch())){ // Une personne ne peut pas se suivre elle-même
                          ?>
                          <form method="post" action="suivre.php"  style="display: inline-block">
                            <input type="hidden" name="suivi" value="<?=$rc['pseudo']?>">
                            <button type="submit" name="suivre" class="btn btn-xsm btn-primary rounded-pill">Suivre</button>
                          </form>

                          <form method="get" action="voir-listes.php" style="display: inline-block">
                            <input type="hidden" name="personne" value="<?=$rc['pseudo']?>">
                            <button type="submit" class="btn btn-xsm btn-primary rounded-pill">Voir les listes</button>
                          </form>

                          <?php
                        }
                  else{
                    ?>
                          <form method="post" action="unfollow.php"  style="display: inline-block">
                            <input type="hidden" name="ami" value="<?=$rc['pseudo']?>">
                            <button type="submit" name="suivre" class="btn btn-xsm btn-secondary rounded-pill">Ne plus suivre</button>
                          </form>

                          <form method="get" action="voir-listes.php" style="display: inline-block">
                            <input type="hidden" name="personne" value="<?=$rc['pseudo']?>">
                            <button type="submit" class="btn btn-xsm btn-primary rounded-pill">Voir les listes</button>
                          </form>

                          <?php
                  }
                }
                  ?>
                  
                  </div>
                  <hr/>
                  <?= nl2br($rc['texte']) ?>
                  <div style="text-align: left; font-size: 12px; color: #665"><?= dateToFrench($rc['date_com'],'d F Y') ?>, <?= date('H:i', strtotime($rc['date_com']))  ?> </div>

                <div class="bouton-commentaire">
                  <?php
                        
                      if($_SESSION['username']){
                      if ($rc['pseudo']!=$_SESSION['username'] && !$_SESSION['banni']){ ?>
                        <form method="post" action="signaler.php">
                          <div class="formfield-select " style="display: inline-block; ">
                            <div class="formfield-select--container" style="display: inline-block">
                              <select class="formfield-select--container" name="signalement">
                                <option value="">signaler</option>
                                <option value="spam">spam</option>
                                <option value="vulgarité">vulgarité</option>
                                <option value="pub">pub</option>
                              </select>
                            </div>
                          </div>
                          <div style="display: inline-block;float:right;padding-left:5px">
                          <input type="hidden" name="commentaire" value="<?=$rc['id']?>">
                          <button type="submit" class="btn btn-lg btn-outline-danger" style="margin-bottom:2%">signaler</button>
                          </div>
                        </form>

                        <?php
                      }
                      if ($rc['pseudo']==$_SESSION['username']){?>
                        <form method="post" action="supprimer-commentaire.php" style="margin-right:2%;float:right">
                        <input type="hidden" name="commentaire" value="<?= $rc['id']?>">
                        <button type="submit" class="btn btn-outline-danger">Supprimer le commentaire</button>
                        </form>
                      <?php
                      }
                    }

                    ?>

                </div> 
              </div>            
                  <?php
                    }
                  ?>
              
            </div> 
         
  </div>                
  	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  
  ﻿</body>
</html>
