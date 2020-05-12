<?php
include_once '../src/Controllers/LoginController.php';
$username = $_SESSION["username"];
$username_err = $_SESSION["username_err"];
$password_err = $_SESSION["password_err"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>S'identifier</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>S'identifier</h2>
        <p>Veuillez renseigner vos coordonnées pour vous identifier</p>
        <form method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Nom d'utilisateur</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>" >
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="S'identifier">
            </div>
            <p>Vous n'avez pas encore de compte ? <a href="register">Créez en un maintenant !</a></p>
        </form>
    </div>
</body>
</html>