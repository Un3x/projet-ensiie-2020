<h1>Bienvenue sur votre page personnelle <?php echo $_SESSION['username']?> !</h1>
<p>Bientôt, vous pourrez consulter vos Achievements !</p>

<h3>Changer de nom d'utilisateur :</h3>
<form method="post" action=#>
    <label for="new_name">Changez de nom d'utilisateur :</label>
    <input type="text" name="new_name"/>
    <label for="pwd">Entrez votre mot de passe pour confirmer le changement :</label>
    <input type="password" name="pwd"/>
    <button type="submit" class="btn btn-primary">Changer !</button>
</form>

<h3>Changer de mot de passe :</h3>
<form method="post" action=#>
    <label for="old">Ancien mot de passe</label>
    <input type="password" name="old"/>
    <label for="new">Nouveau mot de passe</label>
    <input type="password" name="new"/>
    <label for="conf">Confirmer le nouveau mot de passe</label>
    <input type="password" name="conf"/>
    <button type="submit" class="btn btn-primary">Changer !</button>
</form>

<p>Vous pouvez également supprimer votre compte :
    <form method="post" action="deleteUser.php" onsubmit="return areYouSure();">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'] ?>" />
        <button type=submit name="delete_account" class="btn btn-danger">/!\ SUPPRIMER MON COMPTE /!\</button>
    </form>
</p>