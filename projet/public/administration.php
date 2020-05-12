<?php
	
	session_start();

  include '../src/Factory/DbAdaperFactory.php';
  include 'dateFr.php';

	$dbAdapter = (new DbAdaperFactory())->createService();
	$signalements = $dbAdapter->prepare("SELECT * FROM Commentaire WHERE alerte!='' ORDER BY date_com DESC");
	$signalements->execute();
  $signalements = $signalements->fetchAll();
  
  $mute = $dbAdapter->prepare("SELECT * FROM Commentaire WHERE alerte!='' ORDER BY date_com DESC");
	$mute->execute();
	$mute = $mute->fetchAll();

?>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Medialiste - Administration</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Le grand trac">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="/css/all.css">
    <script src="js/scripts.js"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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
                if ($_SESSION['statut']==true){
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


<div class = "container container-dark" style=" box-shadow: 0 5px 15px rgba(0, 0, 0, .15);  margin-top: 2%; padding-bottom:5%; max-height:max-content; padding-bottom:0">
  <div class="row">
    <div class="col-sm-6">                
      <h1>Signalements récents</h1>
      <?php

      if($signalements){
        foreach($signalements as $signalement){ ?>

          <div style="background: #eee; margin-top: 5%;margin-bottom: 5%; padding: 5px 10px; border-radius: 10px">
            <div style="font-weight: bold"><?= "Raison du signalement : " . $signalement['alerte'] ?></div>
            <hr/>
            <div><?= "De " . $signalement['pseudo'].":" ?></div>
            
            <p>"<?= nl2br($signalement['texte']) ?>"</p>
            
                <div style="text-align: right; font-size: 12px; color: #665">Date de signalement :<?= dateToFrench($signalement['date_com'],'d F Y') ?>, <?= date('H:i', strtotime($signalement['date_com'])) ?> </div>

                  <div class="bouton-signalement">
                    <form method="post" action="supprimer.php" style="margin-right:2%">
                      <input type="hidden" name="commentaire" value="<?= $signalement['id']?>">
                      <button type="submit" class="btn btn-outline-primary">Supprimer</button>
                    </form>
                    
                    <form method="post" action="supprimer-commentaire.php" style="margin-right:2%">
                      <input type="hidden" name="commentaire" value="<?= $signalement['id']?>">
                      <button type="submit" class="btn btn-outline-danger">Supprimer le commentaire</button>
                    </form>

                    <form method="post" action="muter.php" style="margin-right:2%">
                      <input type="hidden" name="commentaire" value="<?= $signalement['id']?>">
                      <input type="hidden" name="personne" value="<?= $signalement['pseudo']?>">
                      <button type="submit" class="btn btn-outline-dark ">Muter l'utilisateur </button>
                    </form>
                </div>
          </div>
              <?php
            }
          }else{?>
            <div style="background: #eee; margin-top: 5%;margin-bottom: 5%; padding: 5px 10px; border-radius: 10px">
              <div style="font-weight: bold">Aucun signalement</div>
            </div>
          <?php
      }
      ?>
    </div> 
  
    <div class="col-sm-6">                
      <h1>Utilisateurs mis en sourdine</h1>
      <?php
      $demute = $dbAdapter->prepare('SELECT * FROM Utilisateur WHERE banni=true');
      $demute->execute();

      if($demute){
      foreach($demute as $person){ ?>

        <div style="background: #eee; margin-top: 5%;margin-bottom: 5%; padding: 5px 10px; border-radius: 10px">
          <div style="font-weight: bold"><?= $person['pseudo'] ?></div>
          <hr/>
                <div class="bouton-demute">

                  <form method="post" action="demuter.php" style="margin-right:2%">
                    <input type="hidden" name="personne" value="<?= $person['pseudo']?>">
                    <button type="submit" class="btn btn-outline-primary">Démuter l'utilisateur</button>
                  </form>
              </div>
        </div>
        <?php
        }
        }else{?>
      <div style="background: #eee; margin-top: 5%;margin-bottom: 5%; padding: 5px 10px; border-radius: 10px">
        <div style="font-weight: bold">Aucun utilisateur</div>
      </div>
      <?php
      }
      ?>
    </div> 
  </div>
</div>
</body>
</html>