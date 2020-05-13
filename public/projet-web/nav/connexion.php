<?php

require "../header.php";

?>

<main>
<link rel="stylesheet" href="/projet-web/style/connexion.css">

	<div class="wrapperC">
		<form action="/projet-web/includes/connexion.inc.php" method="POST">
				<h1>Connexion</h1>
                <label><b>Adresse mail</b></label>
                <input type="text" placeholder="Entrer votre adresse mail" name="mailuid" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer votre mot de passe" name="pwd" required>

                <?php

                if (isset($_GET["error"])){
                        if($_GET['error'] === 'wrongpwd'){
                                echo "<span class='error'>Mot de passe incorrect </span>";
                        }
                        if($_GET['error'] === 'wrongmail'){
                                echo "<span class='error'>Adresse mail incorrect </span>";
                        }
                }if (isset($_GET["pwd"])){
                        if($_GET["pwd"] === 'changed'){
                                echo "<p class='success'>Mot de passe changé avec succès</p>";
                        }
                }
                
                ?>

                <button type="submit" name='login-submit'>Connexion</button>
        </form>
        <a href="inscription.php">Créer un compte</a>
        -
        <a href="reset-password.php">Mot de passe oublié ?</a>
	</div>
</main>

<?php
require "../footer.php"
?>
