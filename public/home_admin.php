<!-- Si l'utilisateur est administrateur, il sera redigiré vers cette page-->

<!-- seul un admin peut creer un autre admin-->

<?php
      // on initialise la session
      session_start();
      // on verifie si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
      if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit(); 
      }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Projet web Ensiie</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Thomas COMES">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css?v=1.0">
</head>

<body>
<header>
    <!-- <link rel="stylesheet" href="style.css" media="screen" type="text/css" /> -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Projet Web Ensiie 2020</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                <a class="nav-link" href="/profil.php"><span>Mon profil</span></a>
                </li>
		<a href='userlist.php?deconnexion=true'><span>Déconnexion</span></a>	
                <?php session_start();
		    if(isset($_GET['deconnexion'])) { 
                       if($_GET['deconnexion']==true) {  
                  	    session_unset();
                  	    header("location:index.php");
                       }
             	    }
		    if($_SESSION['username'] !== ""){
                         $user = $_SESSION['username'];
                   	 // afficher un message
                   	 echo "<div class='connection_id' id='idco'>";
                  	 echo "$user";
                  	 echo "</div>";
               	    }
                ?>
            </ul>
        </div>
    </nav>
</header>
<h1>Bienvenue <?php echo $_SESSION['username']; ?>!</h1>
<p>C'est votre espace admin.</p>

<script src="js/scripts.js"></script>
</body>
</html>
