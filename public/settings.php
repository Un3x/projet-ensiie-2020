<?php

include '../src/Model/User/User.php';
include '../src/Model/User/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Model/Friendship/Friendship.php';
include '../src/Model/Friendship/FriendshipRepository.php';

include "./screen/printlayout.php";
$dbAdaper = (new DbAdaperFactory())->createService();

$userRepository = new \User\UserRepository($dbAdaper);
$friendshipRepository = new \Friendship\FriendshipRepository($dbAdaper);

$users = $userRepository->fetchAll();
$friends = $friendshipRepository->fetchAll();

if (isset($_GET['changes']))
    $changes = $_GET['changes'];
else
    $changes = 0;

session_start();
?>





<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FacebIIkE</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Mathias DURAND">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" type="image/png" href="./images/icon-chevre.png" />

</head>

<body>
    <div class="flex-container">
        <?php printNav($friends,$userRepository,'settings.php'); ?>
        <div class="main">
            <div class="container">
                <div class="titleincenter">
                    <h1>Paramètres utilisateur</h1>
                
                <?php if (isset($_SESSION['id']) && isset($_SESSION['pseudo']) && isset($_SESSION['email'])) {
                    echo " pour "; echo $_SESSION['pseudo']; echo"</div>";
                    echo "<div class=\"col-sm-12\">
                    <div class=\"borderpost\">
                    <div class=\"settingsmain\">";
                    echo "Modification de votre profil <br/><br/>";
                    echo "<form action=\"UpdateUser.php?changetype=4\" method='POST'><label for=\"newslogan\">Mon slogan : </label> <input type=\"text\" size=\"32\" id=\"newslogan\" name=\"sloganchange\" placeholder='";
                    echo  $_SESSION['slogan'];
                    echo "' required/> <input id = 'modifslogan' type=\"submit\" value=\"Modifier\" />
                                </form><br>";
                    echo "<form action=\"UpdateUser.php?changetype=5\" method='POST'><label for=\"newdescript\">Ma description : </label> <input type=\"text\" size=\"32\" id=\"newdescript\" name=\"descriptchange\" placeholder='";
                    echo  $_SESSION['descript'];
                    echo "' required/> <input id = 'modifdescript' type=\"submit\" value=\"Modifier\" />
                                </form><br>";
                    if ($changes == 4) {
                        echo "<span style=\"color:green;\">Modification du slogan réussie</span>";
                    }
                    else if ($changes == 5) {
                        echo "<span style=\"color:green;\">Modification de la description réussie</span>";
                    }
                    echo "<br/><hr> Modification de votre compte<br/><br/>";
                    echo "<form action=\"UpdateUser.php?changetype=1\" method='POST'><label for=\"newuser\">Nom d'utilisateur : </label> <input type=\"text\" size=\"32\" id=\"newuser\" name=\"usernamechange\" placeholder='";
                    echo  $_SESSION['pseudo'];
                    echo "' required/> <input id = 'modifpseudo' type=\"submit\" value=\"Modifier\" />
                                </form>
                                    <br>
                                    <form action=\"UpdateUser.php?changetype=2\" method='POST'><label for=\"newmail\">Email : </label> <input type=\"text\" size=\"32\" id=\"newmail\" name=\"emailchange\" placeholder='";
                    echo $_SESSION['email'];
                    echo "' required/> <input id='modifpass' type=\"submit\" value=\"Modifier\" />
                                        </form>
                                        <br>";
                                echo"<form action=\"UpdateUser.php?changetype=3\" method='POST'><label for=\"newpass\">Mot de passe : </label> <input type=\"password\" size=\"32\" id=\"newpass\" name=\"passchange\" placeholder='•••••••••' required/> <input id='modifpass' type=\"submit\" value=\"Modifier\" />
                                        </form>
                                        <br>";
                                        if ($changes == 1) {
                                            echo "<span style=\"color:green;\">Modification du nom d'utilisateur réussie</span>";
                                        }
                                        else if ($changes == 2) {
                                                echo "<span style=\"color:green;\">Modification de l'addresse email réussie</span>";
                                        }
                                        else if($changes == 3){
                                            echo "<span style=\"color:green;\">Modification du mot de passe réussie</span>";
                                        }
                                        else{
                                            echo"";
                                        }
                                        echo "<br>";
                                        if($_SESSION['inactive']==0):
                                            echo"<hr>
                                            <form action=\"DeactivateAccount.php\" method='POST'>
                                                <input type='hidden' name='disconnectid' value='";echo $_SESSION['id']; echo"'/>
                                                <input style=\"color :red;\" type='submit' name=\"deactivateaccount\" value=\"Désactiver mon compte\"/>
                                            </form>
                                            <br>
                                            <span>En désactivant un compte, une déconnexion s'opère et  tous les posts et leurs commentaires associés à cet utilisateur seront rendus invisibles. Les commentaires sous les autres posts seront marqués comme \"Inconnu\"</span>
                                            <br>
                                            <span>Il suffit de cliquer sur \"Réactiver mon compte\" sur la page d'accueil afin de réactiver son compte.</span>";
                                        elseif ($_SESSION['inactive']==1) :
                                            echo "<form action=\"ReactivateAccount.php\" method='POST'>
                                                <input type='hidden' name='reactivateid' value='";echo $_SESSION['id']; echo "'/>
                                                <input style=\"color :blue; type='submit' name=\"reactivateaccount\" value=\"Réactiver mon compte\"/>
                                            </form>
                                            <br>
                                            <span>En réactivant votre compte, tous vos posts seront de nouveau visibles</span>
                                            <br>
                                            <br>";
                                        endif;
                                            
                        echo "</div>
                    </div>
                </div>";
                } else {
                    echo "</div><div class=\"col-sm-12\">
                    <div class=\"borderpost\">
                        <div class=\"settingsmain\"><h1>Veuillez vous connecter pour accéder aux paramètres utilisateur</h1><br><hr><br><form action=\"./index.php\"><input type='submit'value='Se connecter'/></form></div>
                    </div>
                </div>";
                } ?>
            </div>
        </div>


</body>

</html>