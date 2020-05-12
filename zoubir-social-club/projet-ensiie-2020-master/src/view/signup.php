<!DOCTYPE html>
<html lang="fr">
<div class="centrer">
<div class="titreInscription">Page d'inscription :</div>
</div>
<form action="gestionInscription.php" method="post" id="inscription">
<p class="part1">
Champs avec 20 caractères au maximum.
<br>
<input class="input1" type="text" size="20" maxlength="18" id="nom"  placeholder="Nom" name="nom">
<br>
<input class="input1" type="text" size="20" maxlength="18" id="prenom"  placeholder="Prénom" name="prenom">
<br>
<input class="input1" type="text" size="20" maxlength="18" id="pseudo" placeholder="Pseudo" name="pseudo">
<br>
</p>
<p class="part2">
<input class="input1" type="email" id="email" placeholder="E-mail" name="mail">
<br>
<input type="password" placeholder="Mot de passe" class="input1" id="mdp1" name="mdp">
<br>
<input type="password" placeholder="Vérification mot de passe" class="input1" id="mdp2">
<br>
</p>
<div id="erreurMdp"></div>
<div id="erreurEmail"></div>
<p class="part3"> 
Pays
<select class="input1" name="pays" >
    <option value=”Alsace”>Alsace</option>
    <option value=”France”>France</option>
    <option value=”Allemagne”>Allemagne</option>
    <option value=”Chine”>Chine</option>
</select>
<br>
Date d'anniversaire<input class="input1" type="date" name="anniversaire">
</p>
<div id="erreurPasComplet"></div>
<button type="submit" id="submit">S'incrire</button>
</form>
<script src="signup.js"></script>
</html>
