<?php
include_once '../src/Controllers/RegisterController.php';
$username_err = $_SESSION["username_err"];
$confirm_password_err = $_SESSION["confirm_password_err"];
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>S'inscrire</h2>
        <p>Veuillez remplir ce formulaire pour créer un compte</p>
        <form method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Nom d'utilisateur</label>
                <input type="text" name="username" class="form-control" required>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group ">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group ">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirmez le mot de passe</label>
                <input type="password" name="confirm_password" class="form-control" required>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="S'inscrire">
                <input type="reset" class="btn btn-default" value="Réinitialiser">
            </div>
            <p>Vous avez déjà un compte ? <a href="login">Identifiez-vous</a></p>
        </form>
    </div>    
</body>
</html>