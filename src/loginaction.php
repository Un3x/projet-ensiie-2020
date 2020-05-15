<?php
session_start();
$username = isset($_POST['name']) ? $_POST['name'] : "";
$password = isset($_POST['pwd']) ? $_POST['pwd'] : "";
if (!empty($username) && !empty($password)) { 
    $conn = pg_connect("host=localhost port=5432 dbname=ProjetWeb user=postgres password=qwer1234"); 
    $sql = <<<EOF
    SELECT * FROM member WHERE name = '$username' AND pwd = '$password';
EOF;

    $ret = pg_query($conn, $sql);
    $row = pg_fetch_row($ret);
    if ($username == $row[1] && $password == $row[2]) 
    { 
        $_SESSION["user"] = $username;
        $_SESSION["pwd"] = $password;
        $_SESSION["email"] = $row[3];
        $_SESSION["address"] = $row[4];
       header("Location:accueil.php");
        pg_close($conn);
    }
    else{ 
       header("Location:login.php?status_login=1");
   }
}   else{
    header("Location:login.php?status_login=2");
    } 
?>
