<?php
function create_user($bd, $table, $username, $email, $pwd){
    $sql_add = "INSERT INTO $table (mail, pwd, userName)
                VALUES ($mail, $email, $pwd)";
    $bd->execute($sql_add);
}

$bd = connect();

if (isset($_POST["reg_user"])) {

    if ($_POST['passwd'] == $_POST['confpasswd']){
        create_user($bd, "User", $_POST['mail'], $_POST['passwd'], $_POST['username']);
    }
    else echo "Les mdp ne concordent pas";
}
