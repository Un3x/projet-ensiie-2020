<?php

    session_start();
  
    include '../src/Factory/DbAdaperFactory.php';

    $dbAdapter = (new DbAdaperFactory())->createService();
 
    if (!isset($_SESSION['username'])){
        header('Location: index.php');
        exit;
    }
 
    // On récupère les informations de l'utilisateur connecté
    $afficher_profil = $dbAdapter->prepare("SELECT * FROM Utilisateur WHERE pseudo = ?");
    $afficher_profil->execute(array($_SESSION['username'])); 
    $profil=$afficher_profil->fetch();
 
    if(!empty($_POST)){
        extract($_POST);
        $valid = true;
 
        if (isset($_POST['modification'])){
            $nom = htmlentities(trim($nom));
            $prenom = htmlentities(trim($prenom));
            $mail = htmlentities(strtolower(trim($mail)));
 
            if(empty($nom)){
                $valid = false;
                $er_nom = "Il faut mettre un nom";
            }
 
            if(empty($prenom)){
                $valid = false;
                $er_prenom = "Il faut mettre un prénom";
            }
 
            if(empty($mail)){
                $valid = false;
                $er_mail = "Il faut mettre un mail";
 
            }

            elseif(!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail)){
                $valid = false;
                $er_mail = "Le mail n'est pas valide";
            }

            else{
                $req_mail = $dbAdapter->prepare("SELECT * FROM utilisateur WHERE mail = ? AND pseudo != ?");
                $req_mail->execute(array($mail,$_SESSION['username']));
 
                if (($result_mail['mail'] <> "" )&& ($result_mail = $req_mail->fetch())){
                    $valid = false;
                    $er_mail = "Ce mail existe déjà";
                }
            }
 
            if ($valid){
 
                $req = $dbAdapter->prepare("UPDATE Utilisateur SET prenom = ?, nom = ?, mail = ? WHERE pseudo = ?");
                $req->execute(array($prenom, $nom,$mail, $_SESSION['username']));
 
                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['mail'] = $mail;
 
                header('Location:  profil.php');
                exit;
            }   
        }
    }

?>


<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Medialiste - Modifier profil</title>
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
<div class="container" style="padding-top:3%;margin-top:10%; max-width:30%; background-color:#343a40">
  <h3 style="color:white">Modification</h3>
  <form method="post">
        <?php

      if (isset($er_nom)){

      ?>

          <div><?= $er_nom ?></div>

      <?php   
      }
      ?>

      <div class="form-group">
        <input type="text" placeholder="Votre nom" name="nom" value="<?php if(isset($nom)){ echo $nom; }else{ echo $profil['nom'];}?>" required>  
      </div>
      <?php

                if (isset($er_prenom)){

                ?>

                    <div><?= $er_prenom ?></div>

                <?php   
                }
            ?>
      <div class="form-group">
        <input type="text" placeholder="Votre prénom" name="prenom" value="<?php if(isset($prenom)){ echo $prenom; }else{ echo $profil['prenom'];}?>" required>  
      </div>
      <?php

                if (isset($er_mail)){

                ?>

                    <div><?= $er_mail ?></div>

                <?php   

                }

                ?>
      <div class="form-group">
        <input type="email" placeholder="Adresse mail" name="mail" value="<?php if(isset($mail)){ echo $mail; }else{ echo $profil['mail'];}?>" required> 
      </div>
      <button class="btn btn-outline-success my-2 my-sm-0 rounded-pill" type="submit" name="modification">Modifier</button>
  </form>
</div> 
</body>

</html>