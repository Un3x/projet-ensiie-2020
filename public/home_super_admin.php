
<?php

include '../src/User.php';
include '../src/UserRepository.php';

include '../src/Demande_admin.php';
include '../src/DemandeAdminRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$demande_adminRepository = new \Demande\DemandeRepository($dbAdaper);
$Demandes = $demande_adminRepository->fetch_Demandes_Admin();

//include("../src/UserRepository.php");
$bla = new \User\UserRepository($dbAdaper);

?>

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
    <link rel="stylesheet" href="../style.css" />
</head>

<body>
<header>
    <!-- <link rel="stylesheet" href="style.css" media="screen" type="text/css" /> -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Projet Web Ensiie 2020</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/agenda.php"><span>Home</span></a>
                </li>
                    <a href='home_super_admin.php' class="nav-link"><span>Gestion</span></a> 
                    <a href='profil.php' class="nav-link"><span>Profil</span></a> 
                    <a href='OrgaReu.php' class="nav-link"><span>Réunions</span></a> 
		                <a href='userlist.php?deconnexion=true' class="nav-link"><span>Déconnexion</span></a>	

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
                   	 echo "<div class='connection_id nav-link'>";
                  	 echo "$user";
                  	 echo "</div>";
               	    }
                ?>
            </ul>
        </div>
    </nav>
</header>
<body id="body1">
<h1>Bienvenue <?php echo $_SESSION['username']; ?>!</h1>
<h3>Vous êtes le super administrateur.</h3>
                 
<nav>
    <ol>
      <li>
        <a class="nav-link" href="./userlist.php">Liste des utilisateurs </a>
      </li>
      <li>
        <a class="nav-link" href="./AdminListe.php">Liste des administrateurs </a>
      </li>
    </ol>
</nav>
<p> Voici les demandes des utilisateurs qui souhaitent devenir administrateur d'une association. </p>
        
        <table class="table" id="table1" >
                <tr>
                    <th id ="td1"> Nom de l'utilisateur   </th>
                    <th id ="td1"> Souhaite devenir administrateur de :   </th>
                </tr>
               
                <?php foreach($Demandes as $Demande): ?>
                    <tr>
                        <td id ="td1" align="center"><?= $Demande->getUsername() ?></td>
                        <td id ="td1" align="center"><?= $Demande->getNom_assoc() ?></td>
                        <td align="center">
                            <form method="POST" action="./accept_admin.php"  id ="id1">
                                <input name="username" type="hidden" value="<?= $Demande->getUsername() ?>">
                                <button  type="submit" id="but1"> Accepter la demande </button>
                            </form> </td>
                         <td align="center">
                            <form method="POST" action="./refuse_admin.php" id ="id1">
                                <input name="username2" type="hidden" value="<?= $Demande->getUsername() ?>">
                                <button type="submit" id="but1">Refuser la demande </button>
                            </form>
                        </td> 
                    </tr>
                <?php endforeach; ?> 
        </table>
      </body>
</html>
  