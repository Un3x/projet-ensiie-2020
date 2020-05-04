<?php
#phpinfo();
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Asso.php';
include '../src/AssoRepository.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);

session_start();
$assoRepository = new \Asso\AssoRepository($dbAdaper);
$asso = $assoRepository->fetch_Assos($_SESSION['username']);
?>


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
                <a class="nav-link" href="/profil.php"><span>Home</span></a>
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

<script type="text/javascript">
function Hide (addr) { document.getElementById(addr).style.visibility = "hidden"; }
function Show (addr) { document.getElementById(addr).style.visibility = "visible";  }

function swipe(Id)
{
  if (document.getElementById(Id).style.visibility == "hidden") { 
    Show(Id); 
  }
  else{ 
    Hide(Id); 
  }
}

window.onload = function () { Hide("formMDP");Hide("ListAsso")  };
//window.onload = function () { Hide("ListAsso");  };

</script>

<h1>Mon profil</h1>

<h2>Edition du profil</h2>
<ul>
  <li ><a href='deleteUser.php'> Suppression du compte </a></li>
  <li onclick = "swipe('formMDP');"><a href="#" >Changement de mot de passe</a></li>
</ul>
  <div id="formMDP">
  <form action='modifMDP.php'  method="post">
    Nouveau mot de passe: </br>
  <input type="text" name="newP">
  <input type="submit" name="Valider" value="Valider" id ='bouton_envoi' align="center">
  </form>
  </div>

<h2>Informations du profil</h2>
<ul>
    <li onclick = "swipe('ListAsso');"><a href="#" >Voir mes associations</a></li>
    <div class="col-sm-12" id="ListAsso">
            <table class="table">
                <tr>
                    <th>Associations:</th>
                </tr>
                <?php foreach($asso as $Asso): ?>
                    <tr>
                        <td><?= $asso->getNomAssoc() ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
    </div>
</ul>