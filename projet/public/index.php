<?php
  
  session_start();

  include '../src/Factory/DbAdaperFactory.php';

  $dbAdapter = (new DbAdaperFactory())->createService();

  if(!empty($_POST)){
    extract($_POST);
    $valid=true;

    if (isset($_POST['search'])){

      $contenu = (String) trim($contenu);

      if(empty($contenu)){
        $valid = false;
        $message_er = "Mettre une recherche";
      }

      if($valid){
        $req_search = $dpAdapter->prepare("SELECT * FROM Oeuvre WHERE titre LIKE ? ORDER BY titre LIMIT 10 ");
        $req_search->execute(array($contenu . "%"));
        $req_search=$req_search->fetchAll();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <link rel="stylesheet" href="/css/all.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script type="text/javascript" src="js/carousel.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
</head>

<body >
<header>
    <nav class="navbar navbar-expand-lg navbar-expand-sm navbar-dark bg-dark">
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
                    <div class = "show-autocomplete rounded" > 
                      <span class="autocomplete" id="txtHint"></span>
                    </div>
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
<div class="container-fluid-caroussel-bg" >
  <div class="container-fluid-caroussel" >
      <div id="carouselOeuvresMoment" class="carousel slide" data-ride="carousel" data-interval="500" alt="Les oeuvres du moments"> 
      <?php $n=4;//Nombre de slides?>
      <ol class="carousel-indicators" id="carousel-indicators">
        <?php 
        for ($i = 0;$i <= $n -1 ;$i++){
        ?>          
        <li data-target="#carouselOeuvresMoment<?php $i?>" data-slide-to="<?php $i?>"></li>
        <?php }?>
      </ol>
      <div class="carousel-inner" id="carousel-inner">
        <?php 
          $oeuvre_select = $dbAdapter->prepare("SELECT * FROM Oeuvre JOIN Noter ON Oeuvre.numero=Noter.numero ORDER BY Noter.note DESC LIMIT ?");
          $oeuvre_select->execute(array($n));
          $oeuvre=$oeuvre_select->fetchAll();
        

        for ($i = 0;$i <= $n -1 ;$i++){
          if (strlen ($oeuvre[$i]['synopsis'])>300){
            $oeuvre[$i]['synopsis']=substr($oeuvre[$i]['synopsis'],0,250).'...';
          }
        }

        for ($i = 0;$i <= $n -1 ;$i++){
        ?>
        <div class="carousel-item ">
          <a href="resultat-search.php?contenu=<?=$oeuvre[$i]['titre'] ?> " id="wrapper"><img src=<?=$oeuvre[$i]['lien_photo']?> class=" img-hover d-block w-100 h-100" alt="Oeuvre 1"></a>
          <div class="carousel-caption d-none d-md-block gradient-overlay">
            <h5> <?=$oeuvre[$i]['titre'] ?> </h5>
            <p><?=$oeuvre[$i]['synopsis']?></p>
          </div>
        </div>
        <?php }?>
      </div>
      <a class="carousel-control-prev" href="#carouselOeuvresMomentPrev"  role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" id="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselOeuvresMomentNext"  role="button" data-slide="next">
        <span class="carousel-control-next-icon" id="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
      </div>
  </div>
</div>


<div class="container container-dark">
  
  <div>
  <?php if(isset($_SESSION['username'])){?>
      <div class="card" style="padding: 2% ; margin:4%" >  
      <h2 class="bold">Récemment ajouté en favoris</h2>
      <hr/>
      <?php
      $liste_user = $dbAdapter->prepare("SELECT * FROM Liste JOIN Ravoir ON Liste.id=Ravoir.id_liste WHERE Liste.nom_liste LIKE 'Favoris' AND Ravoir.pseudo = ?");
      $liste_user->execute(array($_SESSION['username']));
      $liste_user = $liste_user->fetch();
      $oeuvre = $dbAdapter->prepare('SELECT * FROM Oeuvre JOIN EtreDans ON Oeuvre.numero=EtreDans.numero WHERE id_liste = ? LIMIT 6');
      $oeuvre->execute(array($liste_user['id']));
      
      $i = 1;
      while ($res=$oeuvre->fetch()){
      if (($i-1)%4==0 || $i==1){echo'<div class="row">';}
        echo '<div class="col-sm-3">'; 
        echo '<div class="card rounded" style="box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding-top: 10%; border-radius: 2%; margin-top: 4%; min-height:max-content; max-height:100%;overflow: auto;">';
        echo '<a href="resultat-search.php?contenu='.$res['titre'].'" style="text-decoration: none;" id="wrapper" ><img class="hover img-hover card-img" src="'.$res['lien_photo'].'"alt="'.$res['titre'].'" style="margin:auto;width:100%;heigth:100%;"> </a>'; 
        echo '<p class="text-hover" >'.$res['titre'].'</p>';
        echo '</div>';
        echo '</div>';
        echo '<hr/>';
      if (($i)%4==0 && ($i)!=0){echo '</div>';}
      $i=$i+1;
      }?>
      </div>
      <?php
    }
    
  ?>
  </div>
 </hr>
  <div class="card" style="padding: 2% ; margin:4%" >      
    <h2 class="bold">Les listes préférées des utilisateurs</h2>     
        <?php

        $listes = $dbAdapter->prepare('SELECT * FROM Liste ORDER BY likes DESC LIMIT 10');
        $listes->execute();
        $listes = $listes->fetchAll();
        $i = 1;
        foreach($listes as $liste): 
          $owner = $dbAdapter->prepare('SELECT pseudo FROM Ravoir JOIN Liste ON Ravoir.id_liste=Liste.id WHERE Ravoir.id_liste=?');
          $owner->execute(array($liste['id']));
          $owner = $owner->fetch();
          
          if (($i-1)%3==0 || $i==1){echo'<div class="row">';}
            ?>
          <div class="col-sm-4">  
            <div class="card rounded" style="box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding-top: 10%; border-radius: 2%; margin-top: 4%; min-height:max-content; max-height:100%;overflow: auto;">
              <!--<img class="card-img-top" src="" alt="Card image cap">-->
              <div class="card-body">
                <h5 class="card-title" style="font-weight: bold;"><?= $liste['nom_liste'] ?></h5>
               
                <p class="card-text">De <?= $owner['pseudo'] ?></p>
                <?php
                  $ami = $dbAdapter->prepare('SELECT suivi FROM Suivre WHERE suivi=? AND suiveur=?');
                  $ami->execute(array($owner['pseudo'],$_SESSION['username']));
                  if($owner['pseudo']!=$_SESSION['username']){
                  if (!($ami = $ami->fetch())){ // Une personne ne peut pas se suivre elle-même
                          ?>
                          <form method="post" action="suivre.php"  style="display: inline-block">
                            <input type="hidden" name="suivi" value="<?=$owner['pseudo']?>">
                            <button type="submit" name="suivre" class="btn btn-xsm btn-primary rounded-pill">Suivre</button>
                          </form>

                          <form method="get" action="voir-listes.php" style="display: inline-block">
                            <input type="hidden" name="personne" value="<?=$owner['pseudo']?>">
                            <button type="submit" class="btn btn-xsm btn-primary rounded-pill">Voir les listes</button>
                          </form>

                          <?php
                        }
                  else{
                    ?>
                          <form method="post" action="unfollow.php"  style="display: inline-block">
                            <input type="hidden" name="ami" value="<?=$owner['pseudo']?>">
                            <button type="submit" name="suivre" class="btn btn-xsm btn-secondary rounded-pill">Ne plus suivre</button>
                          </form>

                          <form method="get" action="voir-listes.php" style="display: inline-block">
                            <input type="hidden" name="personne" value="<?=$owner['pseudo']?>">
                            <button type="submit" class="btn btn-xsm btn-primary rounded-pill">Voir les listes</button>
                          </form>

                          <?php
                  }
                }
                  ?>
                <p class="card-text"><?= $liste['likes']?> <i class="fa fa-heart"></i></p>
                <p class="card-text"><small class="text-muted">Rang : #<?= $i?></small></p>
            
                <?php
                $n=$dbAdapter->prepare('SELECT COUNT(titre) FROM Oeuvre JOIN EtreDans ON Oeuvre.numero=EtreDans.numero WHERE id_liste=?');
                $n->execute(array($liste['id']));
                $n=$n->fetch();
                if ($_SESSION['username']){ // Il faut être connecté pour pouvoir liker
                  $personneLike = $dbAdapter->prepare('SELECT * FROM Liker WHERE pseudo=? AND liste=?');
                  $personneLike->execute(array($_SESSION['username'],$liste['id']));
      
                  if (!($personneLike = $personneLike->fetch())){
                    echo '<form method="post" action="liker.php">';
                    echo '	<input type="hidden" name="liste" value="'.$liste['id'].'">';
                    echo '	<input type="hidden" name="personne" value="'.$owner['pseudo'].'">';
                    echo '	<button class="btn btn-outline-danger my-2 my-sm-0 rounded-pill collapsible " type="submit" name="liker"><i class="fa fa-heart"></i></button>';
                    echo ' </form>';
                  }
                  else{
                    echo '<form method="post" action="dislike.php">';
                    echo '	<input type="hidden" name="liste" value="'.$liste['id'].'">';
                    echo '	<input type="hidden" name="personne" value="'.$owner['pseudo'].'">';
                    echo '	<button class="btn btn-outline-danger my-2 my-sm-0 rounded-pill collapsible" type="submit" name="liker"><i class="fa fa-heart-broken"></i></button>';
                    echo ' </form>';
                  }
                }?>
                
                <button class="btn btn-outline-success my-2 my-sm-0 rounded-pill collapsible" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" >
                  Afficher les oeuvres (<?= $n[0] ?>)
                </button>
        
                <div class="collapse contentCollapse" id="collapseExample">
                  <!-- Affichage des oeuvres dans la liste -->
                  <div class="container" style="width:100%;heigth:0%;">
                    <?php
                    $oeuvre = $dbAdapter->prepare('SELECT * FROM Oeuvre JOIN EtreDans ON Oeuvre.numero=EtreDans.numero WHERE id_liste=?');
                    $oeuvre->execute(array($liste['id']));
                    $j=1;// Permet de séparer en colonnes
                    echo "<div>";
                    while ($res=$oeuvre->fetch()){
                      if (($j-1)%2==0 || $j==1){echo'<div class="row">';}

                      echo '<div class="col-sm-6">';  
                      echo "<div class='card border-0' id='wrapper'>";
                      echo '<a href="resultat-search.php?contenu='.$res['titre'].'" style="text-decoration: none;" id="wrapper" ><img class="hover img-hover card-img" src="'.$res['lien_photo'].'"alt="'.$res['titre'].'" style="margin:auto;width:100%;heigth:100%;"> </a>'; 
                      echo '<a class="text-hover" href="resultat-search.php?contenu='.$res['titre'].'" style="text-decoration:none">'.$res['titre'].'</a>';
                      echo '</div>';
                      echo '</div>';
                      if (($j)%2==0 && ($j)!=0){echo '</div>';}
                      $j=$j+1;
                      echo '<hr/>';
                    }
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
        endforeach;
      ?>    
  </div>

</div>
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

</body>
</html>
