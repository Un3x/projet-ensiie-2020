<?php
  session_start();

  include '../src/User.php';
  include '../src/UserRepository.php';
  include '../src/Factory/DbAdaperFactory.php';

  //Permet de créer une liste automatique des favoris
  include '../src/Liste.php';
	
	include '../src/ListeRepository.php';

  if(isset($_SESSION['id'])){
    header('Location: index.php'); 
    exit;
  }

  $dbAdapter = (new DbAdaperFactory())->createService();
  $userRepository = new \User\UserRepository($dbAdapter);
  $user = new  \User\User();

  if(!empty($_POST)){
    extract($_POST);
    $valid = true;
    if(isset($_POST['inscription'])){
      $nom = htmlentities(trim($lastname));
      $prenom = htmlentities(trim($firstname));
      $mail = htmlentities(trim($mail));
      $pseudo = htmlentities(trim($username));
      $mdp = trim($password);
      $confmdp = trim($password2);

      if(empty($pseudo)){
        $valid = false;
        $er_pseudo = "Le pseudo ne peut pas être vide";
      }
      else{
        $req_pseudo = $dbAdapter->prepare('SELECT pseudo FROM Utilisateur WHERE pseudo = ?');
        $req_pseudo->execute(array($pseudo));
        $req_pseudo = $req_pseudo->fetch();
        if ($req_pseudo['pseudo']){
          $valid = false;
          $er_mail = "Ce pseudo existe déjà";
        }
      }

      if(empty($nom)){
        $valid = false;
        $er_nom = "Le nom ne peut pas être vide";
      }
      if(empty($prenom)){
        $valid=false;
        $er_prenom = "Le prénom ne peut pas être vide";
      }
      if(empty($mail)){
        $valid=false;
        $er_mail = "Le mail ne peut pas être vide";
      }
      elseif(!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail)){
        $valid = false;
        $er_mail = "Le mail n'est pas valide";
      }
      else{
        $req_mail = $dbAdapter->prepare('SELECT mail FROM Utilisateur WHERE mail = ?');
        $req_mail->execute(array($mail));
        $req_mail = $req_mail->fetch();
        if ($req_mail['mail'] <> ""){
          $valid = false;
          $er_mail = "Ce mail existe déjà";
        }
      }
      if(empty($mdp)){
        $valid=false;
        $er_mdp = "Le mot de passe ne peut pas être vide";
      }
      elseif($mdp != $password2){
        $valid = false;
        $er_mdp = "Vous avez entré deux mots de passe différents";
      }
      if($valid){
        $UserRepository = new \User\UserRepository($dbAdapter);
        $UserRepository->insert($username,$lastname,$firstname,$password,$mail,'false','false');
        //Création automatique de la liste Favoris de l'utilisateur
        $nomListe = "Favoris";
        $ListeRepository = new \Liste\ListeRepository($dbAdapter);
    	  $ListeRepository->add($pseudo,$nomListe);

        header('Location: signIn.php');
        exit;
      }
    }
  }

?>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>S'inscrire à Medialiste</title>
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
                      <li class="nav-item active" style="float:right">                                 
                        <a class="nav-link" class="nav-button" href="/signUp.php">S'inscrire</a>
                      </li>
                      </ul>
                      <?php
                  }
                  ?>          
            
        </div>
      </nav>        
</header>


<div class="container " style="padding-top:3%;margin-top:5%; max-width:30%; background-color:#343a40">
  <h3 style="color:white;font-weight:bold">S'inscrire</h3>
  <form method="post" onsubmit="return verifForm(this)" style="padding-top:3%">
    <div class="form-group">
        <input name="username" id="pseudo" type="text" placeholder="Votre pseudo" onblur="verifPseudo(this)"/>
        <small class="form-text text-muted">Votre pseudo doit faire entre 2 et 20 caractères
        </small>
    </div>
    <div class="form-group">
        <input name="lastname" id="nom" type="text" placeholder="Votre nom" onblur="verifLastname(this)"/>
    </div>
    <div class="form-group">
        <input name="firstname" id="prenom" type="text" placeholder="Votre prénom" onblur="verifFirstname(this)"/>
    </div>
    <div class="form-group">
        <input name="mail" id="mail" type="text" placeholder="Votre mail" onblur="verifMail(this)">
        <small id="emailHelp" class="form-text text-muted">Nous ne partagerons pas votre email.</small>
    </div>
    <div class="form-group">
        <input name="password" id="mdp" type="password" placeholder="Votre mot de passe" onblur="verifMdp(this)">
        <small class="form-text text-muted">Votre mot de passe doit faire entre 4 et 20 caractères.
      </small>
    </div>
    <div class="form-group">
      <input name="password2" id="mdp" type="password" placeholder="Confirmez votre mot de passe" onblur="verifMdp(this)">
    </div>
    <button type="submit" class="btn btn-outline-success my-2 my-sm-0 rounded-pill" name="inscription">S'inscrire</button>
  </form>
</div>
</body>
</html>
