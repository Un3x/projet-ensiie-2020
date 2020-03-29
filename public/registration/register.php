<?php include('server.php') ?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>Créer un compte</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Création de votre compte</h1>
    <p>Pour profiter de toutes les fonctionnalités de 
    Tales of Webseria, comme sauvegarder ou commenter, vous devez créer
    un compte. Vous pouvez tout de même jouer sans créer de compte.
    Promis on ne vendra pas vos informations à d'autres entreprises.
    </p>
    <form method="post" action="register.php">
        <div>
          <label for="username">Nom d'utilisateur</label>
          <input type="text" name="username" size="20"/>
        </div>
        <div>
          <label for="mail">Adresse Em@il</label>
          <input type="email" name="mail"/>
        </div>
        <div>
          <label for="passwd">Mot de passe</label>
          <input type="password" name="passwd"/>
          <label for="confpasswd">Confirmer votre mdp</label><br/>
          <input type="password" name="confpasswd"/>
        </div>
        <button type="submit" name="reg_user">Créer mon compte</button>
        <button type="reset">Annuler</button>
    </form>
    <div>
    <br/>
      Vous avez déjà un compte ?
      <a href=login.php><button type="button">Se connecter</a>
    </div>
</body>
</html>