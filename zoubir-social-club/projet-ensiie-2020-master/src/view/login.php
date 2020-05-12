<!DOCTYPE html>
<html lang="fr">
<div class="centrer">
<div class="titreConnexion">Page de Connexion:</div>
</div>
<form action="login.php" method="post" id="connexion">
<p class="part1">
<input class="input1" type="email" placeholder="Email" id="email" name="email"> <br>
<input class="input1" type="password" placeholder="Mot de passe" id="mdp" name="mdp">
</p>
<div class="erreur">
<?php
 if( ! empty($data))
 {
    echo $data['erreur'];
 }
?>
</div> 
<button type="submit" id="submit">Connexion</button>
</form>
</html>
