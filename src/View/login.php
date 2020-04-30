<h1>Se connecter</h1>
<form method="post" action="server.php">
<div>
  <label for="username">Nom d'utilisateur</label>
  <input type="username" name="username"/>
</div>
<div>
  <label for="passwd">Mot de passe</label>
  <input type="password" name="passwd"/>
</div>
    <button type="submit" name="log_user" class="btn btn-primary">Se connecter</button>
    <button type="reset" class="btn btn-danger">Annuler</button>
</form>
<div>
<br/>
  Vous n'avez pas de compte ?
  <a href=register.php><button type="button" class="btn">En créer un</a>
</div>
