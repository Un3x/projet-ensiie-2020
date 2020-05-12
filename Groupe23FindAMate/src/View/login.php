<html>
    <head>
        <title> Connexion FindAMate</title>
        <meta charset ="utf-8">



    </head>
    <body>
        <div align="center"><h2> Connexion </h2>
        <p> Si vous n'avez pas encore de compte, allez d'abord sur la page <a href="signup.php">Signup</a><p>
        <form action="verification.php" method="post">
            <div>
                <label for = "email">Email :</label>
                <input type ="email" name="email" placeholder="Entrez votre adresse mail" required>
            </div>
            <div>
                <label for ="password">Password :</label>
                <input type="password" placeholder="Entrez votre mot de passe" name="password" required>
            </div>
            <div>
                <input type = "submit" name="Login" value="Se connecter">
            </div>
            </form>
            <?php if(isset($_GET['erreur']))
{
                    $err = $_GET['erreur'];
                    if($err==1)
                        echo "<p style='color:red'>Email ou mot de passe incorrect</p>";
                    if ($err==2)
                    echo "<p style='color:red'>Il n'y a aucun compte associé à cet email</p>";
                }
?>
        </div>
    </body>
</html>

