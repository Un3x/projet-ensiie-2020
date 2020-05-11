<h1>Se connecter</h1>
<form autocomplete="off" method="post" action="server.php" onsubmit="return checkLoginForm();">
<div>
  <label for="username">Nom d'utilisateur</label>
  <input type="username" name="username" required/>
</div>
<div>
  <label for="passwd">Mot de passe</label>
  <input type="password" name="passwd" required/>
</div>
    <button type="submit" name="log_user" class="btn btn-primary">Se connecter</button>
    <button type="reset" class="btn btn-danger">Annuler</button>
</form>
<div>
<br/>
  Vous n'avez pas de compte ?
  <a href=register.php><button type="button" class="btn btn-link">En créer un</button></a>
</div>
