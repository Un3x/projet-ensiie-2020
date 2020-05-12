<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Création perso</title>
	<link rel="stylesheet" href="../form/style.css" />
	<link rel="icon" href="photo/image.ico" />

    </head>
    <body>
    <?php include("../src/header.php"); ?>
    <form action="../src/creation_perso.php" method="post">
    
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" autofocus required/><br />

    <label for="prenom">Prenom :</label>
    <input type="text" name="prenom" id="prenom" required/><br />
    
    <label for="adresse_mail">Adresse mail :</label>
    <input type="text" name="adresse_mail" id="adresse_mail"required/>
    <?php
    if (isset($_GET['a'])){
?>
        <p id='a'>L'adresse mail est déjà utilisé</p><br />
<?php
    }
?>
    <br />
    
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password"required/>
    <br />

    <label for="password2">Vérification mot de passe :</label>
    <input type="password" name="password2" id="password2"required/>
<?php
    if (isset($_GET['p'])){
?>
        <p id='false'>Vos 2 mots de passe sont différents</p><br />
<?php
    }
?><br />
    <label for="date_de_naissance">Date de naissance :</label>
    <input type="date" name="date_de_naissance" id="date_de_naissance"required/><br />

    <label for="numero_de_telephone">Numéro de telephone :</label>
    <input type="tel" name="numero_de_telephone" id="numero_de_telephone"required/><br />
    

    <label for="adresse_postal">Adresse postal :</label>
    <input type="text" name="adresse_postal" id="adresse_postal"required/><br />

    <label for="connexion">Rester connecté :</label>
    <input type="checkbox" name="connexion" checked /><br />

    <input type="submit" value="valider"/><br />
<a href="formulaire_connexion.php">j'ai deja un compte</a>
<?php include("../src/footer.php"); ?>
</body>
</html>
