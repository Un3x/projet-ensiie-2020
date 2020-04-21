<html>
<body>
    <p>
    Cette page sera la page d'acceuil destinée à la redirection après s'être login
    </p>
    <?php session_start(); echo("Welcome " .$_SESSION["username"]); ?>
    <form method="POST" action="/Logout.php">
        <button type="submit">Logout</button>
    </form>
</body>
</html>