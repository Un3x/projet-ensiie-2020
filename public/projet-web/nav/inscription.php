<?php

require "../header.php";

?>
<script type="text/javascript" src="../js/formulaire.js"></script>
<main>
<link rel="stylesheet" href="/projet-web/style/inscription.css">

	<div class="wrapperC">
	<form action="/projet-web/includes/inscription.inc.php" method="POST" onsubmit="return verifForm(this)" enctype="multipart/form-data">
                <h1>Inscription</h1>
                <label><b>Photo de Profile</b></label>
                <input type="file" name="profil"/>
                <label><b>Nom</b></label>
                <input type="text" 
                <?php if(isset($_GET['nom']) and !empty($_GET['nom'])){ echo "value ='".$_GET['nom']."'";}?> placeholder="Nom" name="nom" onBlur="verifPseudo(this)" required >

                <label><b>Prénom</b></label>
                <input type="text" 
                <?php if(isset($_GET['prenom']) and !empty($_GET['prenom'])){ echo "value ='".$_GET['prenom']."'";}?> placeholder="Prénom" name="prenom" onBlur="verifPseudo(this)" required>

                <label><b>Adresse mail</b></label>
                <input type="text" <?php if(isset($_GET['mail']) and !empty($_GET['mail'])){ echo "value ='".$_GET['mail']."'";}?> placeholder="Mail" name="mailuid" onBlur="verifMail(this)" required>

                <label><b>Numéro de téléphone</b></label>
                <input type="text" <?php if(isset($_GET['tel']) and !empty($_GET['tel'])){ echo "value ='".$_GET['tel']."'";}?>placeholder="Numéro de téléphone" name="tel" onBlur="verifTel(this)" required>

                <label><b>Mot de passe</b><i style="font-size: small;"> Minimum 8 caractères dont 1 chiffre</i></label>
                <input type="password" placeholder="Mot de passe" name="pwd" required>

                <label><b>Répétez votre mot de passe</b></label>
                <input type="password" placeholder="Mot de passe" name="pwd-repeat" required>

                <?php if (isset($_GET["error"])){
                        if($_GET['error'] === 'invalidmailnomprenom'){
                                echo "<span class='error'>Nom, Prénom et adresse mail invalides</span>";
                        }
                        if($_GET['error'] === 'invalidmail'){
                                echo "<span class='error'>Adresse mail invalide</span>";
                        }
                        if($_GET['error'] === 'invalidnom_ou_prenom'){
                                echo "<span class='error'>Nom ou prénom invalide</span>";
                        }
                        if($_GET['error'] === 'passwordcheckl'){
                                echo "<span class='error'>Les mots de passe ne correspondent pas</span>";
                        }
                        if($_GET['error'] === 'mailtaken'){
                                echo "<span class='error'>L'adresse mail est déjà enregistré</span>";
                        }
                }
                ?>

                <button type="submit" name="signup-submit">Je m'inscris</button>
        </form>
        <a href="connexion.php">J'ai déjà un compte</a>
	</div>
</main>

<?php
require "../footer.php"
?>
