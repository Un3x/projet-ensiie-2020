<?php

require "../header.php";

?>

<main>
<link rel="stylesheet" href="/projet-web/style/connexion.css">

	<div class="wrapperC">
		<form action="/projet-web/includes/reset-request.inc.php" method="POST">
				<h2>Mot de passe oublié</h2>
                <label><b>Adresse mail</b></label>
                <input type="text" placeholder="Entrer votre adresse mail" name="mailuid" required>
                <p>Un lien vous sera envoyé par mail pour changer votre mot de passe.</p>
                <button type="submit" name='reset-request-submit'>Réinitialiser le mot de passe</button>
        </form>
        <?php 
        if(isset($_GET["reset"])){
                if($_GET["reset"]=="success"){
                        echo "<p class='success'>email envoyé !</p>";
                }
        }
        ?>
	</div>
</main>

<?php
require "../footer.php"
?>