<?php

require "../header.php";

?>

<main>
<link rel="stylesheet" href="/projet-web/style/connexion.css">

	<div class="wrapperC">

        <?php
        
        $selector = $_GET["selector"];
        $validator = $_GET["validator"];

        if(empty($selector) || empty($validator)){
                echo "Votre requête a échoué";
        }else{
                if(ctype_xdigit($selector)!==false && ctype_xdigit($validator) !== false){
                        ?>
                <form action="/projet-web/includes/reset-password.inc.php" method="POST">
                        <h2>Nouveau mot de passe</h2>
                        <input type="hidden" name="selector" value="<?php echo $selector;?>"> <!-- On récupére les tokens du lien dans un formulaire invisible pour les envoyer à reset-password.inc.php-->
                        <input type="hidden" name="validator" value="<?php echo $validator;?>">
                        <label><b>Nouveau mot de passe</b></label>
                        <input type="password" placeholder="Entrer votre nouveau mot de passe" name="new-password" required>

                        <label><b>Recopier le mot de passe</b></label>
                        <input type="password" placeholder="Répéter votre nouveau mot de passe" name="new-password-repeat" required>

                        <?php 
                        if (isset($_GET['error'])){
                                if($_GET['error']==='empty'){
                                        echo "<p class='error'>Remplissez tous les champs</p>";
                                }
                                if($_GET['error']==='pwdnotsame'){
                                        echo "<p class='error'>Les mots de passe de correspondent pas</p>";
                                }
                        }
                        
                        ?>
                        <button type="submit" name='reset-password-submit'>Changer le mot de passe</button>
                 </form>
                        <?php

                }
        }

        ?>

	</div>
</main>

<?php
require "../footer.php"
?>