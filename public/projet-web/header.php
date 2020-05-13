<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head><title>Allez-Retour</title>
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700,800,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/projet-web/style/header.css">
  <title>Document</title>
	
</head>
<body>

  <header>

  <div class="navWrapper">
  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #0f4c5c;">
  <a class="navbar-brand" href="/projet-web/index.php"><span class="txt">Allez-Retour</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    
    <ul class="navbar-nav mr-auto">

      <?php if(isset($_SESSION["userId"])){ ?>
      <li class="nav-item active">
        <a class ="nav-link" href="/projet-web/nav/proposerTrajet.php"><span class="txt"> Proposer Trajet</span></a>
      </li>

      <li class="nav-item active">
        <a class ="nav-link" href="/projet-web/nav/demanderTrajet.php"><span class="txt">Demander un trajet</span></a>
      
      </li>

      <li class="nav-item active">
        <a class ="nav-link txt" href="/projet-web/nav/afficherTrajets.php"><span class="txt">Voir les trajets</span></a>
      
      </li>
      <?php } ?>

    </ul>
    
    <?php if(!isset($_SESSION["userId"])){ ?>
    
    <span class="navbar-text">
      <a class ="nav-link" href="/projet-web/nav/inscription.php"><span class="txt">Inscription</span></a>
    </span>
    
    <span class="navbar-text">
      <a class ="nav-link" href="/projet-web/nav/connexion.php"><span class="txt">Connexion</span></a>
    </span>
    <?php }else{ ?>



    <span class="navbar-text">
      <a class ="nav-link" href="/projet-web/nav/monCompte.php"><span class="txt">Mon compte</span></a>
    </span>
    <span class="navbar-text">
    <a class ="nav-link" href="/projet-web/includes/deconnexion.inc.php"><span class="txt">Déconnexion</span></a>
    </span>
    <?php }?>

  </div>
</nav>

  </div>
  
  </header>