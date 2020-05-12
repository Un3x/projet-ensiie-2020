<?php 
if (isset($_COOKIE['adresse_mail'] ) && isset($_COOKIE['pass'] )){
header("Status: 301 Moved Permanently", false, 301);
header("Location: ../src/login.php");
}
else {
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Page de connexion</title>
	<link rel="stylesheet" href="../form/style.css" />
	<link rel="icon" href="photo/image.ico" />

    </head>
    
   <?php 
   include("../src/header.php");
if (isset($_GET['p'])){
?>
<p>Mauvais mot de passe ou adresse mail</p>
<?php
}
 ?> <form action="/coroshop/src/login.php" method="post">
    <label for="adresse_mail">Adresse mail :</label>
    <input type="text" name="adresse_mail" id="adresse_mail"required/><br />
    
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password"required/>
    <br />

    <label for="connexion">Rester connecté :</label>
    <input type="checkbox" name="connexion" checked />

    <input type="submit" value="valider"/><br />
    <a href="formulaire_creation_perso.php">Je n'ai pas de compte</a>
</html>
<?php
};
include("../src/footer.php");
?>
