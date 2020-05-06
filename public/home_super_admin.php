
<?php
#phpinfo();
include '../src/Demande_admin.php';
include '../src/DemandeAdminRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$demande_adminRepository = new \Demande\DemandeRepository($dbAdaper);
$Demandes = $demande_adminRepository->fetch_Demandes_Admin();

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
        <div class="sucess">
            <h1>Bienvenue <?php echo $_SESSION['username']; ?>!</h1>
            <h3>Vous êtes le super admin.</h3>
        </div>
        <a class="nav-link" href="./userlist.php">Liste des utilisateurs </a>
      </head>
      <body id="body1">
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
                            <form method="POST" action="/accept_demande_admin.php" id = "id1">
                                <button type="submit" id="but1">Accepter la demande </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?> 
        </table>
      </body>
    </html>
