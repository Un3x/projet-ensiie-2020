<?php
session_start();
$ID_o=$_SESSION['ID_objet'];
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$per = $bdd -> prepare('SELECT ID_personne FROM personne WHERE adresse_mail=?');
$per->execute(array(
    $_SESSION['adresse_mail']
));
$rep=$per->fetch();
$req=$bdd->prepare('INSERT INTO acheteur (ID_objet , ID_personne ,date_achat)VALUES(:ID_objet ,:ID_personne ,:date_achat)');
$req->execute(array(
    'ID_objet'=>$ID_o ,
    'ID_personne'=>$rep['ID_personne'],
    'date_achat'=>date("Y-m-d H:i:s")));
    header("Status: 301 Moved Permanently", false, 301);	
    header("Location: /coroshop/index.php");
?>