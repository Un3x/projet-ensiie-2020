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
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
    <link rel="stylesheet" href="/css/all.css">
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

                <li class="nav-item active">
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
  <h1>Les oeuvres disponibles</h1>  <?php
  $oeuvre = $dbAdapter->prepare('SELECT * FROM Oeuvre ');
  $oeuvre->execute();
  
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
  }
  
 ?>

</div>  

  	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <!--<script src="../js/bootstrap.min.js"></script>-->

  ﻿</body>
</html>