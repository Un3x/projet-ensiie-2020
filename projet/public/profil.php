<?php

  session_start(); 

  include '../src/Factory/DbAdaperFactory.php';
  include '../src/User.php';
  include '../src/UserRepository.php';
  include '../src/Suivre.php';
  include '../src/SuivreRepository.php';
  include 'dateFr.php';

  $dbAdapter = (new DbAdaperFactory())->createService();
  // S'il n'y a pas de session alors on ne va pas sur cette page
  if(!isset($_SESSION['username'])){ 
    header('Location: index.php'); 
    exit; 
  }
  // On récupère les informations de l'utilisateur connecté
  $afficher_profil = $dbAdapter->prepare("SELECT * FROM Utilisateur WHERE pseudo = ?");
  $afficher_profil->execute(array($_SESSION['username'])); 
  $profil=$afficher_profil->fetch();

  $userRepository = new \User\UserRepository($dbAdapter);
  $suivis = $userRepository->fetchSuivis($profil['pseudo']); 
  $suiveurs = $userRepository->fetchSuiveurs($profil['pseudo']); 

?>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Medialiste - Mon profil</title>
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
                      <li class="nav-item active" style="float:right">
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
  <div class="container container-dark">
    <h1>Mon profil</h1>
    <div class="card rounded" style="box-shadow: 0 5px 15px rgba(0, 0, 0, .15); border-radius: 2%; margin-top: 4%; min-height:max-content; max-height:100%;overflow: auto;">
              <!--<img class="card-img-top" src="" alt="Card image cap">-->
              <div class="card-body">
                <h5 class="card-title" style="font-weight: bold;">Pseudo</h5>
                <hr/>
                <p class="card-text"> <?= $profil['pseudo'] ?></p>
              </div>
    </div>
    <div class="card rounded" style="box-shadow: 0 5px 15px rgba(0, 0, 0, .15); border-radius: 2%; margin-top: 4%; min-height:max-content; max-height:100%;overflow: auto;">
              <!--<img class="card-img-top" src="" alt="Card image cap">-->
              <div class="card-body">
                <h5 class="card-title" style="font-weight: bold;">Nom</h5>
                <hr/>
                <p class="card-text"> <?= $profil['nom'] ?></p>
              </div>
    </div>
    <div class="card rounded" style="box-shadow: 0 5px 15px rgba(0, 0, 0, .15); border-radius: 2%; margin-top: 4%; min-height:max-content; max-height:100%;overflow: auto;">
              <!--<img class="card-img-top" src="" alt="Card image cap">-->
              <div class="card-body">
                <h5 class="card-title" style="font-weight: bold;">Prénom</h5>
                <hr/>
                <p class="card-text"> <?= $profil['prenom'] ?></p>
              </div>
    </div>
    <div class="card rounded" style="box-shadow: 0 5px 15px rgba(0, 0, 0, .15); border-radius: 2%; margin-top: 4%; min-height:max-content; max-height:100%;overflow: auto;">
              <!--<img class="card-img-top" src="" alt="Card image cap">-->
              <div class="card-body">
                <h5 class="card-title" style="font-weight: bold;">e-mail</h5>
                <hr/>
                <p class="card-text"> <?= $profil['mail'] ?></p>
              </div>
    </div>
    <div class="card rounded" style="box-shadow: 0 5px 15px rgba(0, 0, 0, .15); border-radius: 2%; margin-top: 4%; min-height:max-content; max-height:100%;overflow: auto;">
              <!--<img class="card-img-top" src="" alt="Card image cap">-->
              <div class="card-body">
                <h5 class="card-title" style="font-weight: bold;">Date de création</h5>
                <hr/>
                <p class="card-text"> <?= dateToFrench($profil['date_creation'],'d F Y') ?></p>
              </div>
    </div>
    <br/>

    <a href="modifier-profil.php" class = "btn btn-sm btn-primary rounded-pill">Editer mon profil</a>
    <hr style="border-color:grey"/>

    <div class="card rounded" style="box-shadow: 0 5px 15px rgba(0, 0, 0, .15); border-radius: 2%; margin-top: 4%; min-height:max-content; max-height:100%;overflow: auto;">
              <!--<img class="card-img-top" src="" alt="Card image cap">-->
              <div class="card-body">
              <h3 class="card-title" style="font-weight: bold;">Liste des utilisateurs que vous suivez </h3>
                <hr/>
                
      <?php foreach($suivis as $suivi): ?>
        <div class="form-group" style="text-align:center">
              <form method="GET" action="voir-listes.php" style="display: inline-block">
              <button class="btn btn-sm btn-primary rounded-pill" name="personne" value="<?=$suivi->getUsername()?>" type="submit" id="personne" style="display:inline-block"><?= $suivi->getUsername() ?> </button>
              </form>
              <form method="post" action="unfollow.php"  style="display: inline-block">
                            <input type="hidden" name="ami" value="<?=$suivi->getUsername()?>">
                            <button type="submit" name="suivre" class="btn btn-sm btn-secondary rounded-pill">Ne plus suivre</button>
              </form>
              <!--<td>< //$suivi->getLastname()  </td>
              <td> //$suivi->getFirstname() </td>-->
        </div>
      <?php endforeach; ?>
      
    
              </div>
    </div>

  </div>
  ﻿</body>
</html>