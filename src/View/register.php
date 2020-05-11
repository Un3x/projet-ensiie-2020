<h1>Création de votre compte</h1>
<p>Pour profiter de toutes les fonctionnalités de 
Tales of Webseria, comme sauvegarder ou commenter, vous devez créer
un compte. Vous pouvez tout de même jouer sans créer de compte.
Promis on ne vendra pas vos informations à d'autres entreprises.
</p>
<form autocomplete="off" method="post" action="server.php" onsubmit="return checkRegisterForm();">
    <div>
      <label for="username">Nom d'utilisateur</label>
      <input type="text" name="username" size="20" required/>
    </div>
    <div>
      <label for="email">Adresse Em@il</label>
      <input type="email" name="email" required/>
    </div>
    <div>
      <label for="passwd">Mot de passe</label>
      <input type="password" name="passwd" required/><br/>
      <label for="confpasswd">Confirmer votre mdp</label>
      <input type="password" name="confpasswd" required/>
    </div>
    <button type="submit" name="reg_user" class="btn btn-primary">Créer mon compte</button>
    <button type="reset" class="btn btn-danger">Annuler</button>
</form>
<div>
<br/>
  Vous avez déjà un compte ?
  <a href=login.php><button type="button" class="btn btn-link">Se connecter</button></a>
</div>
