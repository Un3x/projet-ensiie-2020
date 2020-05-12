<?php

  session_start();

  include '../src/Factory/DbAdaperFactory.php';
  include 'dateFr.php';

  $dbAdapter = (new DbAdaperFactory())->createService();

  $oeuvre = $dbAdapter->prepare('SELECT * FROM Oeuvre WHERE date_sortie > NOW() ORDER BY date_sortie ASC LIMIT 10');
  $oeuvre->execute();
  $futures_oeuvres = $oeuvre->fetchAll();
  $count = $oeuvre->rowCount();

  if ($count==0){
    $oeuvre = $dbAdapter->prepare('SELECT * FROM Oeuvre ORDER BY date_sortie DESC LIMIT 5');
    $oeuvre->execute();
    $futures_oeuvres = $oeuvre->fetchAll();
  }

?>


<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Medialiste - Agenda</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Le grand trac">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" type="text/css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    
    <link rel="stylesheet" href="/css/all.css">
    <script type="text/javascript" src="js/scripts.js"></script>
</head>
<body>
<body>
<header>
    <nav class="navbar  navbar-expand-lg navbar-dark bg-dark">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a class="navbar-brand" href="/index.php">Medialiste</a>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="top.php">Top commu</a>
                 </li> 

                <li class="nav-item active">
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

<div class="container container-dark" style = "padding-top : 2%" >
  <?php 
  
  if($count==0){
    ?>
    <h1>Récemment arrivées</h1>
    <?php
  }
  else {
    ?>
    <h1>Bientôt disponibles</h1>
    
    <?php
}
  $i=1;
  echo '<div class="row">';
  foreach($futures_oeuvres as $future_oeuvre): 

    $titre=$future_oeuvre['titre'];
    $lien_photo=$future_oeuvre['lien_photo'];
    $synopsis=$future_oeuvre['synopsis'];
    if (strlen ($synopsis)>200){
      $synopsis=substr($synopsis,0,200).'...';
    }
    $date=$future_oeuvre['date_sortie'];
    if (($i-1)%3==0 || $i==1){echo'<div class="row">';}
    ?>
    <div class="col-sm-4">
      <div class="card rounded" style="box-shadow: 0 5px 15px rgba(0, 0, 0, .15); border-radius: 2%; margin-top: 10%;min-height:95%; max-height:max-content">
        <h1><?= $titre ?></h1>
          <?php 
          if($count==0){ 
            $note_moyenne = $dbAdapter->prepare('SELECT AVG(note) AS note FROM Noter WHERE Noter.numero = ?');
            $note_moyenne->execute(array($future_oeuvre['numero']));
            $note_moyenne = $note_moyenne->fetch();      
            echo $note_moyenne['note'];
          }
          else { 
            ?>
            <div>Sort le <?= dateToFrench($date,'d F Y') ?></div> 
            <?php
          }
          ?>
      
        <div class='card-body' style="text-overflow: ellipsis;">
          <?php echo '<a href="resultat-search.php?contenu='.$titre.'" style="text-decoration: none;" id="wrapper" ><img class="hover img-hover card-img" src="'.$lien_photo.'"alt="'.$titre.'" style="margin:auto;width:100%;heigth:100%;"> </a>';?>
          <p class="text-hover" style="font-weight:bold" > <?=$titre ?></p>
          <p class="synopsis" style= "float:right;text-overflow: ellipsis;">Synopsis: <?= $synopsis ?></p>
        </div>
      </div>
    </div>
    <?php
    if (($i)%3==0 && ($i)!=0){echo '</div>';}
    $i=$i+1;
  endforeach;
  echo '</div>';
  ?>
</div>
</body>
</html>