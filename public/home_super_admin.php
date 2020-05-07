
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
    <html>
      <head>
        <link rel="stylesheet" href="../style.css" />
      </head>
      <body id="body1">
    <header id = "header1">
      <center> <h1>Bienvenue <?php echo $_SESSION['username']; ?>!</h1></center>
      <div class="sucess">
            <h3>Vous êtes le super admin.</h3>
        </div>
    </header>
  <nav>
    <ol>
      <li>
        <a class="nav-link" href="./userlist.php">Liste des utilisateurs </a>
      </li>
      <li>
        <a class="nav-link" href="./AdminListe.php">Liste des administrateurs </a>
      </li>
      <li>
      <a href='userlist.php?deconnexion=true'><span>Déconnexion</span></a>	
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
  