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
    <html>
      <head>
      <link rel="stylesheet" href="../style.css" />
      </head>
      <body id = "body1">
        <div class="sucess">
        <h1>Bienvenue <?php echo $_SESSION['username']; ?>!</h1>
        <p>C'est votre espace admin.</p>
        <a href="add_user.php">Add user</a> | 
        <a href="#">Update user</a> | 
        <a href="#">Delete user</a> | 
        <a href="../logout.php">Déconnexion</a>
        </ul>
        </div>
      </body>
    </html>
