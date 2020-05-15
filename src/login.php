<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>Location de bateau d'aviron--Connexion</title>
    <style>
        .main {
            margin: 60px 180px 0px 180px;
        }

        .content {
            display: inline-block;
            width: 1150px;
            height: 200px;
            background-color: #e1eefa;
            border-radius: 10px;
        }

        form {
            border: 1px solid #737373;
            z-index: 2;
            width: 300px;
            position: fixed;
            top: 100px;
            left: 1000px;
            background-color: rgb(255, 255, 255);
            padding: 2px 30px 2px 15px;
        }

            form p {
                padding: 0px 0px;
            }

            form span {
                display: inline-block;
                font-size: 13px;
                font-weight: 300;
                width: 30%;
            }

            form .text {
                width: 60%;
            }

            form .butt {
                width: 75px;
                height: 32px;
                font-weight: 500;
                background-color: rgba(242, 240, 255, 0.49);
                border-radius: 5px;
                border: 1px solid rgba(108, 150, 255, 0.56);
            }

            form h2 {
                background: url("images/arrow_down.gif") no-repeat;
                background-position: 120px 20px;
                margin: 10px 0px;
                color: #0099cc;
            }
    </style>
</head>
<body>
    <div class="main">
        <div style="margin-bottom: 20px">&nbsp;</div>
        <div class="content">
            <img src="images/help.png">
            <div style="display: inline-block;position: relative;left: 20px;bottom: 100px;color: black">
                <strong style="font-size:30px;font-family:'Times New Roman', Times, serif">Site de la Location de bateau d'aviron</strong>

                <p style="font-size: 20px;font-style:italic;padding-left: 20px">Trouvez votre bateau ici!</p>
            </div>
        </div>
        <form method="post" action="loginaction.php">
            <h2>Connexion au compte</h2>
            <hr />
            <p><span>Surnom</span><input class="text" type="text" name="name"></p>

            <p><span>Mot de passe</span><input class="text" type="password" name="pwd"></p>
            <p>
                <span></span><input class="butt" type="submit" value="Connecter">&nbsp;<input onclick='document.location="regs.php"' class="butt" value="s'inscrire"
                                                                                         type="button">
            </p>
                    
        </form>
    </div>
    <div style="text-align: center;padding-top: 10px;border-top: 1px solid rgba(89, 139, 217, 0.8);color: #919090;">
        <img src="images/end.png" width="27px" style="margin: 0px 10px">©<?php echo date("d-m-y");?>
    </div>
    <?php
            $status_login = isset($_GET["status_login"]) ? $_GET["status_login"] : "";
            switch ($status_login) {
            case 1:
                echo "<script>alert('Surnom ou Mot de passe incorrect!');</script>";
                break;

            case 2:
                echo "<script>alert('Tous les champs doivent être complétés!');</script>";
                break;
            case 3:
                echo "<script>alert('Votre compte a été bien créé!');</script>";
                break;
            case 4:
                echo "<script>alert('Vous avez bien modifié vos informations, reconnectez-vous SVP!')</script>";
            }?> 
</body>
</html>