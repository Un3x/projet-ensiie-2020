<!DOCTYPE html>
<html lang="fr">
<div class="centrer">
<div class="titreInscription">Profil de <?php echo $_SESSION['prenom']; ?></div>
</div>
<div class="profile">
<div class="separation"></div>
Nom : <?php echo $_SESSION['nom']; ?>
<br>
<div class="separation"></div>
Prénom : <?php echo $_SESSION['prenom']; ?>
<br>
<div class="separation"></div>
Pseudo : <?php echo $_SESSION['pseudo']; ?>
<br>
<div class="separation"></div>
E-mail : <?php echo $_SESSION['mail']; ?>
<br>
<div class="separation"></div>
Date de naissance : <?php echo $_SESSION['birth']; ?>
<br>
<div class="separation"></div>
Pays : <?php echo $_SESSION['pays']; ?>
</div>
<form action="modifProfil.php" method="post">
<button type="submit">Modifier son profil ?</button>
</form>
</html>