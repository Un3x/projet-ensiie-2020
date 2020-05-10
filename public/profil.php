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
$name=$_SESSION['username'];
$asso = $assoRepository->fetch_Assos($_SESSION['user']->getId());
$assoAll=$assoRepository->fetch_all_Assos();
$_SESSION['user']=$userRepository->getUser($_SESSION['username']);
$userid = $_SESSION['user']->getId();
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
        <a class="navbar-brand" href="#">Parions Retard</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                </li>
                    <a href='agenda.php' class="nav-link"><span>Agenda</span></a> 
                    <a href='profil.php' class="nav-link"><span>Profil</span></a> 
                    <a href='OrgaReu.php' class="nav-link"><span>Réunions</span></a>
                    <a href='bet.php' class="nav-link"><span>Paris</span></a>
                    <?php session_start();
                    if($_SESSION['username'] !== ""){
                    $points = $_SESSION['user']->getPoints();
                    echo "<div class='nav-link'>$points \$ </div>";
                    }
                    ?>
                    <?php if($userRepository->IsSuperAdmin($_SESSION['user']->getId()))
                      echo "<a href='home_super_admin.php' class='nav-link'><span>Gestion</span></a>";
                      ?>

                <?php session_start();
                        if($_SESSION['username'] !== ""){
                         $user = $_SESSION['username'];
                     // afficher un message
                     echo "<div class='connection_id nav-link' id='idco' >";
                     echo "$user";
                     echo "</div>";
		                  if(isset($_GET['deconnexion'])) { 
                       if($_GET['deconnexion']==true) {  
                  	    session_unset();
                  	    header("location:index.php");
                       }
             	    }

               	    }
                ?>
                    <a href='userlist.php?deconnexion=true' class="nav-link" style="align-text:right;"><span>Déconnexion</span></a> 

            </ul>
        </div>
    </nav>
</header>

<script type="text/javascript">
function Hide (addr) { document.getElementById(addr).style.visibility = "hidden"; }
function Show (addr) { document.getElementById(addr).style.visibility = "visible";  }

function swipe(Id,Id2,Id3)
{
  if (document.getElementById(Id).style.visibility == "hidden") { 
    Show(Id); 
    if (document.getElementById(Id).style.visibility == "visible") {
      Hide(Id2)
    }
  }
  else{ 
    Hide(Id); 
  }
  if(document.getElementById(Id3).style.visibility == "visible"){
    Hide(Id3);
  }
}

function swipe2(Id,Id2,id3)
{
  if (document.getElementById(Id).style.visibility == "visible") { 
    Hide(Id); 
    if (document.getElementById(Id2).style.visibility == "visible") {
      Hide(Id2);
    }
    if(document.getElementById(Id3).style.visibility == "visible"){
      Hide(Id3);
    }
  }
  else{ 
    Show(Id); 
    if (document.getElementById(Id2).style.visibility == "visible") {
      Hide(Id2);
    }
    if(document.getElementById(Id3).style.visibility == "visible"){
      Hide(Id3);
    }
  }
}

window.onload = function () { Hide("formMDP");Hide("ListAsso");Hide("formUsName");Hide("formDelete")  };
//window.onload = function () { Hide("ListAsso");  };

</script>

<h1>Mon profil</h1>

<h2>Edition du profil</h2>
<ul>
  <li onclick = "swipe2('formDelete','formMDP','formUsName');"><a href="#" > Suppression du compte :</a> </li>

    <div id="formDelete" style= "position:absolute;top:22%;left:30%;">
    <form method="POST" action="/deleteUser.php">
        <button type="submit">Valider la suppression</button>
    </form>
   </div>
  <li onclick = "swipe('formMDP','formUsName','formDelete');"><a href="#" >Changement de mot de passe</a></li>
  <li onclick = "swipe('formUsName','formMDP','formDelete');"><a href="#" >Changement de nom d'utilisateur</a></li>
</ul>

  <div id="formMDP" style= "position:absolute;top:22%;left:30%;">
  <form action='modifMDP.php'  method="post">
    Nouveau mot de passe: </br>
  <input type="text" name="newP">
  <input type="submit" name="Valider" value="Valider" id ='bouton_envoi' align="center">
  </form>
  </div>
  <div id="formUsName" style= "position:absolute;top:26%;left:30%;">
  <form action='modifUsName.php'  method="post">
    Nouveau nom d'utilisateur: </br>
  <input type="text" name="newU">
  <input type="submit" name="Valider" value="Valider" id ='bouton_envoi' align="center">
  </form>
  </div>

<h2>Demande d'adhesion a une association</h2>

<?php
  echo "<form action='assoInscription.php' method='post'>";
  echo "<select name='nomAsso' size='1'>";
  foreach($assoAll as $element){
    $val=$element->getNomAssoc();
    if(!$assoRepository->appartient($val,$_SESSION['user']->getId())){
      echo "<option value='$val'>".$val;
      echo "</option>";
    }
  }
  echo "</select>";
  echo '<input type="submit" name="Valider" value="Valider" id ="bouton_envoi" align="center">';
  echo "</form>";
?>
  

<h2>Formulaire de demande afin de devenir administrateur pour une association</h2>
<a class="nav-link" href="./Form_demande_admin.php">Cliquez ici pour le formulaire</a>

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
                        <td><?php echo"".$Asso->getNomAssoc()?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
    </div>
</ul>