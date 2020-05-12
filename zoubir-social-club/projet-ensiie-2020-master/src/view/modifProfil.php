<!DOCTYPE html>
<html lang="fr">
<div class="centrer">
<div class="titreInscription">Modification du profil de <?php echo $_SESSION['prenom']; ?></div>
</div>
<form action="gestionModification.php" method="post" id="inscription">
<p class="part1">
Champs avec 20 caractères au maximum.
<br>
<input class="input1" type="text" size="20" maxlength="18" id="nom"  placeholder="<?php echo $_SESSION['nom']?>" name="nom">
<br>
<input class="input1" type="text" size="20" maxlength="18" id="prenom"  placeholder="<?php echo $_SESSION['prenom']?>" name="prenom">
<br>
<input class="input1" type="text" size="20" maxlength="18" id="pseudo" placeholder="<?php echo $_SESSION['pseudo']?>" name="pseudo">
<br>
</p>
<p class="part2">
<input type="password" placeholder="Nouveau mot de passe" class="input1" id="mdp1" name="mdp">
<br>
<input type="password" placeholder="Nouveaut mot de passe" class="input1" id="mdp2">
<br>
</p>
<div id="erreurMdp"></div>
<div id="erreurEmail"></div>
<p class="part3"> 
Pays : (Ancien pays : "<?php echo $_SESSION['pays']?>")
<br>
<select class="input1" name="pays" >
    <option value=”Alsace”>Alsace</option>
    <option value=”France”>France</option>
    <option value=”Allemagne”>Allemagne</option>
    <option value=”Chine”>Chine</option>
</select>
<br>
Date d'anniversaire : (Ancienne date d'anniversaire: "<?php echo $_SESSION['birth']?>")
<br>
<input class="input1" type="date" name="anniversaire">
</p>
<div id="erreurPasComplet"></div>
<button type="submit" id="submit">Modification de profile</button>
</form>
<script src="signup.js"></script>
</html>