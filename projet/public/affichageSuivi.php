<?php

session_start(); 

include '../src/OeuvreRepository.php';
include '../src/ListeRepository.php';
include '../src/Liste.php';
include '../src/SuivreRepository.php';
include '../src/Oeuvre.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdapter = (new DbAdaperFactory())->createService();

$listeRepository = new \Liste\ListeRepository($dbAdapter);
$suiviRepository = new \Suivre\SuivreRepository($dbAdapter);
$oeuvreRepository = new \Oeuvre\OeuvreRepository($dbAdapter);

// On récupère le pseudo de l'utilisateur suivi sélectionné
$pseudo = $_POST['pseudo'];

// Récuprération de toutes ses listes
$listes = $listeRepository->fetch($pseudo);

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
<div class="container container-dark" >  
  <h1>Listes de <?= $pseudo?></h1>

  <?php 
  $i = 1;
  foreach($listes as $liste):
        if (($i-1)%3==0 || $i==1){echo'<div class="row">';}
            ?>
          <div class="col-sm-4">  
            <div class="card rounded element-grey" style="box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding-top: 10%; border-radius: 2%; margin-top: 4%; min-height:max-content; max-height:100%;overflow: auto;">
              <!--<img class="card-img-top" src="" alt="Card image cap">-->
              <div class="card-body">
                <h5 class="card-title" style="font-weight: bold;"><?= $liste->getNomListe () ?></h5>
                <!--<p class="card-text">id : <?= $liste->getId() ?></p>-->
                <p class="card-text">De <?= $pseudo ?></p>
                <?php
                  $ami = $dbAdapter->prepare('SELECT suivi FROM Suivre WHERE suivi=? AND suiveur=?');
                  $ami->execute(array($pseudo,$_SESSION['username']));
                  if ($pseudo!=$_SESSION['username']){
                  if (!($ami = $ami->fetch())){ // Une personne ne peut pas se suivre elle-même
                          ?>
                          <form method="post" action="suivre.php"  style="display: inline-block">
                            <input type="hidden" name="suivi" value="<?=$pseudo?>">
                            <button type="submit" name="suivre" class="btn btn-xsm btn-primary rounded-pill">Suivre</button>
                          </form>

                          <?php
                        }
                  else{
                    ?>
                          <form method="post" action="unfollow.php"  style="display: inline-block">
                            <input type="hidden" name="ami" value="<?=$pseudo?>">
                            <button type="submit" name="suivre" class="btn btn-xsm btn-secondary rounded-pill">Ne plus suivre</button>
                          </form>

                          <?php
                  }
                }
                  ?>
                <?php $likes= $dbAdapter->prepare('SELECT likes FROM Liste WHERE id=?');
                  $likes->execute(array($liste->getId()));
                  $likes=$likes->fetch();

                ?>
                <p class="card-text"><?= $likes[0] ?> <i class="fa fa-heart"></i></p>

                <?php
                $n=$dbAdapter->prepare('SELECT COUNT(titre) FROM Oeuvre JOIN EtreDans ON Oeuvre.numero=EtreDans.numero WHERE id_liste=?');
                $n->execute(array($liste->getId()));
                $n=$n->fetch();
              if ($_SESSION['username']){ // Il faut être connecté pour pouvoir liker
	          $personneLike = $dbAdapter->prepare('SELECT * FROM Liker WHERE pseudo=? AND liste=?');
	          $personneLike->execute(array($_SESSION['username'],$liste->getId()));

	          if (!($personneLike = $personneLike->fetch())){
              echo '<form method="post" action="liker.php">';
              echo '	<input type="hidden" name="liste" value="'.$liste->getId().'">';
              echo '	<input type="hidden" name="personne" value="'.$pseudo.'">';
              echo '	<button class="btn btn-outline-danger my-2 my-sm-0 rounded-pill collapsible " type="submit" name="liker"><i class="fa fa-heart"></i></button>';
              echo ' </form>';
            }
            else{
              echo '<form method="post" action="dislike.php">';
              echo '	<input type="hidden" name="liste" value="'.$liste->getId().'">';
              echo '	<input type="hidden" name="personne" value="'.$pseudo.'">';
              echo '	<button class="btn btn-outline-danger my-2 my-sm-0 rounded-pill collapsible" type="submit" name="liker"><i class="fa fa-heart-broken"></i></button>';
              echo ' </form>';
            }
          }?>
            
                <?php
                $n=$dbAdapter->prepare('SELECT COUNT(titre) FROM Oeuvre JOIN EtreDans ON Oeuvre.numero=EtreDans.numero WHERE id_liste=?');
                $n->execute(array($liste->getId()));
                $n=$n->fetch();
                ?>
                
                <button class="btn btn-outline-success my-2 my-sm-0 rounded-pill collapsible" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" >
                  Afficher les oeuvres (<?= $n[0] ?>)
                </button>
        
                <div class="collapse contentCollapse" id="collapseExample">
                  <!-- Affichage des oeuvres dans la liste -->
                  <div class="container" style="width:100%;heigth:0%;">
                    <?php
                    $oeuvre = $dbAdapter->prepare('SELECT * FROM Oeuvre JOIN EtreDans ON Oeuvre.numero=EtreDans.numero WHERE id_liste=?');
                    $oeuvre->execute(array($liste->getId()));
                   $oeuvres = $oeuvreRepository->fetch($liste->getId()); 
                    $j=1;// Permet de séparer en colonnes
                    echo "<div>";
                    foreach($oeuvres as $oeuvre):
                      
                      if (($j-1)%2==0 || $j==1){echo'<div class="row">';}

                      echo '<div class="col-sm-6">';  
                      echo "<div class='card border-0' id='wrapper'>";
                      echo '<a href="resultat-search.php?contenu='.$oeuvre->getTitre ().'" style="text-decoration: none;" id="wrapper" ><img class="hover img-hover card-img" src="'.$oeuvre->getLienPhoto ().'"alt="'.$oeuvre->getTitre ().'" style="margin:auto;width:100%;heigth:100%;"> </a>'; 
                      echo '<a class="text-hover" href="resultat-search.php?contenu='.$oeuvre->getTitre ().'" style="text-decoration:none">'.$oeuvre->getTitre ().'</a>';
                      echo '</div>';
                      echo '</div>';
                      if (($j)%2==0 && ($j)!=0){echo '</div>';}
                      $j=$j+1;
                      echo '<hr/>';
                      
                    endforeach;
                    if (($j)%2==0 && ($j)!=0){echo '</div>';}
                    echo '</div>';
                    ?>
                  </div>
                </div>  
              </div>
            </div>
          </div>
          
            <?php
          if (($i)%3==0 && ($i)!=0){echo '</div>';}
          $i=$i+1;  
  endforeach; ?>

  <div class="container"> <a href="/profil.php" style="text-decoration:none">Retourner sur votre profil</a></div>
  <!--<input type="button" onclick="document.location.href='/profil.php'">Retournez voir votre profil</button>-->
</div>
</body>

<script>
  // Pour objet de type collapsible
  var coll = document.getElementsByClassName("collapsible");
      var i;

      for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
          this.classList.toggle("active");
          var content = this.nextElementSibling;
          if (content.style.display === "block") {
            content.style.display = "none";
          } else {
            content.style.display = "block";
          }
        });
      }
</script>
</html>