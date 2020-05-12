<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['pseudo']) && isset($_SESSION['email'])) {
    header("location:home.php");
}

if (isset($_GET['newUserSaved']))
    $newUserSaved = $_GET['newUserSaved'];
else
    $newUserSaved = 0;

if (isset($_GET['issueconnect']))
    $issueconnect = $_GET['issueconnect'];
else
    $issueconnect = 0;




?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FacebIIkE</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Mathias DURAND">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styleindex.css">
    <link rel="shortcut icon" type="image/png" href="./images/icon-chevre.png" />

</head>

<body>

    <script type="text/javascript">
        function showCreate() {
            document.getElementById("createuser").style.display = "block";
            document.getElementById("homecreate").style.display = "none";
        }

        function showReactivate() {
            document.getElementById("reactivateform").style.display = "block";
            document.getElementById("reactivatebutton").style.display = "none";

            document.getElementById("connectform").style.display = "none";
            document.getElementById("connect2button").style.display = "block";
        }

        function showConnect() {
            document.getElementById("reactivateform").style.display = "none";
            document.getElementById("reactivatebutton").style.display = "block";

            document.getElementById("connectform").style.display = "block";
            document.getElementById("connect2button").style.display = "none";
        }

        function valider() {
            from = document.forms['createuserform'];
            pass1 = from.elements['pswrdc'].value;
            pass2 = from.elements['pswrdcverf'].value;
            
            if (pass1==""){
                alert("Le mot de passe ne peut pas être vide");
                return false;
            }

            else if (pass1.localeCompare(pass2)==0) {
                return true;
            } 
            else {
                alert("Les deux mots de passes doivent être identiques");
                return false;
            }
        }
    </script>

    <div class="titlehome">
        Bienvenue sur FacebIIkE
        <h1>"Le rézo social du turfu"</h1>

    </div>
    <br>
    <br>
    <div class="connectbox">
        <form action="./ConnectUser.php" method='POST' id="connectform">
            <input type="text" id="username" name="username" size="32" placeholder="Nom d'utilisateur" required>

            <input type="password" id="pswrd" name="pswrd" size="32" placeholder="Mot de passe" required>
            <br />
            <br />
            <input type="submit" id="connectbutton" name="connectbutton" value="Se connecter" />
            <br>
        </form>

        <br>
        <?php if ($issueconnect == 1) {
            echo "<br><span style=\"color:red;\">Mauvais identifiant ou mot de passe</span>";
        } else if ($issueconnect == 2) {
            echo "<br><span style=\"color:red;\">Compte désactivé</span>";
        } else if ($issueconnect == 3) {
            echo "<br><span style=\"color:red;\">Compte dejà actif ou mauvais mot de passe</span>";
        }

        ?>
        <hr>
        <br>
        <?php
        #Apres tentative de javascript et php, méthode "brute"

        if ($newUserSaved != 2 && $newUserSaved != 3) {
            echo '<button onclick="showCreate()" id="homecreate">Créer un compte</button>
        <div style="display:none;" class="createaccount" id="createuser">';
        } else {
            echo '<div style="display:block;" class="createaccount" id="createuser">';
        }
        ?>
        <form action="CreateUser.php" method='POST' id='createuserform' onsubmit="return valider()">
            <input type="text" id="emailcreate" name="emailc" size="32" placeholder="E-mail" required>
            <input type="text" id="usernamecreate" name="usernamec" size="32" placeholder="Nom d'utilisateur" required>

            <input type="password" id="pswrdc" name="pswrdc" size="32" placeholder="Mot de passe" required>
            <input type="password" id="pswrdcreatever" name="pswrdcverf" size="32" placeholder="Tapez de nouveau votre mdp" required>
            <br />
            <br />
            <input type="submit" id="createbutton" name="createbutton" value="Valider" />

        </form>

    </div><br>
    <?php
    #On pourrait utiliser une fonction javascript pour vérifier ces conditions
    if ($newUserSaved == 0) {
        echo "";
    } else if ($newUserSaved == 1) {
        echo "<span style=\"color:green;\">Compte créé</span>";
    } else if ($newUserSaved == 2) {
        echo "<span style=\"color:red;\">Ce nom d'utilisateur existe déjà</span>";
    } else if ($newUserSaved == 3) {
        echo "<span style=\"color:blue;\">Les deux mots de passe doivent être identiques</span>";
    }

    ?>

    </div>


</body>

</html>