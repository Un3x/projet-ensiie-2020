<?php
#phpinfo();
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';



?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Parions retard</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Thomas COMES">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css?v=1.0">
    <link rel="stylesheet" href="style.css"/>
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Parions retard</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                </li>
            </ul>
        </div>
    </nav>
    <center> <h1 id ="h1css"> Agenda des associations </h1> </center>
</header>
       <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
    <body>
        <div id="container">
            <!-- zone de connexion -->
            
            <form action="verification.php" method="POST">
               <h1 align = "center">Connexion</h1>
                
                <label><b>Nom d'utilisateur</b></label>
                <input type="text" placeholder="Entrer le nom d'utilisateur" name="username" required>

                <label><b>Mot de passe</b></label>
                <input type="password" placeholder="Entrer le mot de passe" name="password" required>

                <input type="submit" id='submit' value='LOGIN' >
                <?php
                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($errr=3)
                        echo "<p> $username </p>";
                    if($err==1 || $err==2)
                        echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
                }
                ?>
            </form>
            <a class="nav-link" href="./inscription.php" id="inscri">Si vous n'êtes pas inscrit</a>
        </div>
    </body>
<script src="js/scripts.js"></script>
</body>
</html>
