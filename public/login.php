<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>Créer un compte</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function checkForm()
    {
      if (! document.login.username.value){
        alert("Veuillez spécifier un nom d'utilisateur.")
        return false
      }
      if (! document.login.passwd.value){
        alert("Veuillez spécifier un mot de passe.")
        return false
      }
      return true
    }
    </script>
</head>
<body>
    <h1>Se connecter</h1>
    <form method="post" name="login" action="server.php" onsubmit="return checkForm()">
    <div>
      <label for="username">Nom d'utilisateur</label>
      <input type="username" name="username"/>
    </div>
    <div>
      <label for="passwd">Mot de passe</label>
      <input type="password" name="passwd"/>
    </div>
        <button type="submit" name="log_user">Se connecter</button>
        <button type="reset">Annuler</button>
    </form>
    <div>
    <br/>
      Vous n'avez pas de compte ?
      <a href=register.php><button type="button">En créer un</a>
    </div>
</body>
</html>