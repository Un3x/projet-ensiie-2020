<?php
$servername = "localhost";
$dBUsername= "root";
$dBPassword = "root";
$dBName="underground";

$conn =mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
if(!$conn){
    die("Connexion failed: ".mysqli_connect_error());
}

?>