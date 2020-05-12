<?php

	session_start();

	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	if (!empty($_POST)){
  		extract($_POST);
  		$valid=true;

	  	if (isset($_POST['ajout-oeuvre'])){
	      	$oeuvre  = (String) trim($oeuvre); 
	      	$synopsis = (String) trim($synopsis);
	      	$photo = (String) trim($photo);

	      	if(empty($oeuvre)){
	        	$valid = false;
	        	$er_oeuvre = "Il faut mettre un nom d'oeuvre";
		    }
		    elseif(empty($synopsis)){
	        	$valid = false;
	        	$er_synopsis = "Il faut mettre un synopsis";
		    }
		    elseif(empty($photo)){
	        	$valid = false;
	        	$er_photo = "Il faut mettre un lien vers une photo";
		    }

		    $oeuvre = htmlentities($oeuvre);
		    $synopsis = htmlentities($synopsis);
		    $photo = htmlentities($photo);
		 
		    if($valid){
		        $ajout = $dbAdapter->prepare("INSERT INTO Oeuvre(titre,lien_photo,synopsis) 
		        	VALUES(?, ?, ?, ?)");
		        $akout->execute(array($oeuvre,$photo,$synopsis)); 
		        header('Location: administration.php');
		        exit;
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
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="js/carousel.js"></script>
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
                      <button type="submit" class="btn btn-outline-success my-2 my-sm-0 rounded-pill">Rechercher</button>
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
<body>
	<?php
        /* S'il y a une erreur lors de l'ajout de l'oeuvre on l'affiche*/
        if (isset($er_oeuvre)){
        ?>
		
		<div class="er-msg"><?= $er_oeuvre ?></div>
		<?php   
        }
        if (isset($er_synopsis)){
        ?>
		
		<div class="er-msg"><?= $er_synopsis ?></div>
		<?php   
        }
    	if (isset($er_photo)){
        ?>
		
		<div class="er-msg"><?= $er_photo ?></div>
		<?php   
        }
    	?>
	<form method="post">
		<div class="form-group">
			<input type="text" name="oeuvre">
			<input type="text" name="synopsis">
			<input type="file" name="photo" accept="image/*">
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-outline-success my-2 my-sm-0 rounded-pill" name="ajout-oeuvre" onclick="">Ajouter l'oeuvre</button>
		</div>
	</form>
</body>
</html>