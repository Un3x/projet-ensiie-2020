<?php 
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Asso.php';
include '../src/AssoRepository.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$AssoRepository = new \Asso\AssoRepository($dbAdaper);

session_start();
$userid=$_SESSION['user']->getId();
$assoAll = $AssoRepository->fetch_all_Assos_for_Admin($userid);

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Projet web Ensiie</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Thomas COMES">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css?v=1.0">
    <link rel="stylesheet" href="style.css"/>
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
            </ul>
        </div>

                <?php session_start();
                        if($_SESSION['username'] !== ""){
                         $user = $_SESSION['username'];
                     // afficher un message
                     echo "<div class='connection_id nav-link' >";
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
                    <a href='userlist.php?deconnexion=true' class="nav-link" style="align-text:right;"><span><FONT color="black">Déconnexion</FONT></span></a> 

    </nav>
</header>


<?php 
if($userRepository->IsAdmin($userid)){ 
   echo " <fieldset >";
   echo "<legend id='leg1' align='center' > Créer une réunion </legend> <br />";
   echo "<form name='FormReu' action='creaReu.php' method='post' >";

    echo "Nom de l'association :";
    echo "<select name='nomAsso' id ='nomAsso' size='1'>";
        foreach($assoAll as $element){
            echo '<option>'.$element->getNomAssoc();
        }
    echo "</option>";
    echo "</select> <br />";

    echo "Debut de la reunion <em id='em1' >*</em> :";
    echo   '<input type="datetime-local" name="debut" value=""  id ="debut">  <br />';

    echo "Fin de la reunion <em id='em1' >*</em> :";
    echo   '<input type="datetime-local" name="fin" value=""  id ="fin">  <br />';

    echo "Descriptif de la reunion  :";
    echo  "<input type='text' name='descriptif' value='' id ='descriptif' >  <br />";

    echo " </fieldset>";

    echo '<input type="submit" name="newReu" value="Créer" id ="bouton_envoi" align="center">';

    echo '</form>';
}
else{
	echo "<h1>";
  echo "<div align='center' style= 'position:absolute;top:40%;left:20%;''>";
	echo "Vous devez être administrateur d'une association";
  echo "</div>";
  echo "<div align='center' style= 'position:absolute;top:50%;left:32%;''>";
  echo " pour avoir accès à cette partie";
  echo "</div>";
	echo "</h1>";

  echo "<h3>";
  echo "<div align='center' style= 'position:absolute;top:65%;left:27%;''>";
  echo "<a class='nav-link' href='/Form_demande_admin.php'><FONT color='white'> Cliquez ici pour demander à devenir administrateur</FONT></a>";
  echo "</div>";
  echo "</h3>";


}

?>

