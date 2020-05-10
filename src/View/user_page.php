<?php if (! isset($_SESSION['id'])){
    header('location: login.php');
}
?>

<h1>Bienvenue sur votre page personnelle <?php echo $_SESSION['username']?> !</h1>
<br/>

<h3>Changer de nom d'utilisateur :</h3>
<form method="post" action=server.php>
    <label for="new_name">Nouveau nom d'utilisateur :</label></br>
    <input type="text" name="new_name"/></br>
    <label for="pwd">Entrez votre mot de passe pour confirmer le changement :</label></br>
    <input type="password" name="pwd"/></br>
    <button type="submit" class="btn btn-primary" name="change_username">Changer !</button>
</form>

<h3>Changer de mot de passe :</h3>
<form method="post" action=server.php>
    <label for="old">Ancien mot de passe</label></br>
    <input type="password" name="old"/></br>
    <label for="new">Nouveau mot de passe</label></br>
    <input type="password" name="new"/></br>
    <label for="conf">Confirmer le nouveau mot de passe</label></br>
    <input type="password" name="conf"/></br>
    <button type="submit" class="btn btn-primary" name="change_pwd">Changer !</button>
</form>

<p>Vous pouvez également supprimer votre compte :
    <form method="post" action="deleteUser.php" onsubmit="return areYouSure();">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'] ?>" />
        <button type=submit name="delete_account" class="btn btn-danger">/!\ SUPPRIMER MON COMPTE /!\</button>
    </form>
</p>