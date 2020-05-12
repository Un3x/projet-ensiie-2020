<?php

include '../src/Utilisateur.php';
include '../src/PplOnline.php';
include '../src/UtilisateurRepository.php';
include '../src/PplOnlineRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$pplonlineRepository = new PplOnline\PplOnlineRepository($dbAdaper);
$utilisateurRepository = new \Utilisateur\UtilisateurRepository($dbAdaper);
$pplonlines = $pplonlineRepository->fetchAll();
$utilisateurs = $utilisateurRepository->fetchAll();

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>La Ligue des Deglingos</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Theau FERNANDEZ / Quentin JURY / Gabriel Meziere">
    <link rel="stylesheet" href="style.css?v=1.0">
</head>

<body>

<?php
    session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == True) echo("Welcome " .$_SESSION['username']);
    else echo("Vous pouvez vous connecter en appuyant sur le bouton Jouer !");
?>

<p>
    <?php
        echo("Online : ");
        echo($pplonlineRepository->update());
    ?>
    </br>
</p>

<div class="toalign">
<button type="button" id="playbutton" onclick=" document.getElementById('hide').style.display='block';">Jouer</button>
<form method="POST" style="display:none" id="hide" action="/Login.php" onsubmit="return login_validation()" name="login">
  <label for="name">Pseudo:</label>
  <input type="text" id="name" name="nom_utilisateur" placeholder="Votre pseudo. .">
  <br>
  <label for="mdp">Mot de passe :</label>
  <input type="password" id="mdp" name="mdp_utilisateur" placeholder="Votre mot de passe. .">
  <br>
  <button id="newaccbutton" type="submit"> Se connecter</button>
  <p id="hide" style="display:none">No account ? Signup now ! </p>
  <button id="newaccbutton" type="button" onclick=" document.getElementById('hide2').style.display='block';document.getElementById('hide').style.display='none';">Créer un  compte</button>
</form>
<form method="POST" style="display:none" id="hide2" action="/createUtilisateur.php" onsubmit="return signin_validation()" name="signin">
  <label for="name">Pseudo:</label>
  <input type="text" id="name" name="nom_utilisateur">
  <br>
  <label for="mdp">Mail :</label>
  <input type="text" id="mail" name="mail_utilisateur">
  <br>
  <label for="mdp">Mot de passe :</label>
  <input type="password" id="mdp" name="mdp_utilisateur">
  <br>
  <button id="newaccbutton" type="submit"> S'inscrire</button>
</form>
</div>

<script src="scripts.js"></script>
</body>
</html>
