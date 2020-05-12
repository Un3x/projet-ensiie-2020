<?php
// Connexion à la base de données
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
session_start();
// Insertion de l'objet a vendre
$req1 = $bdd->prepare('INSERT INTO objet (nom, texte ,categorie,prix) VALUES(:nom, :texte,:categorie,:prix)');
$req1->execute(array(
'nom'=>htmlspecialchars($_POST['nom']), 
'texte'=>htmlspecialchars($_POST['description']),
'categorie'=>$_POST['categorie'],
'prix'=>$_POST['prix']
));


$req3= $bdd->prepare('SELECT ID_objet FROM objet WHERE nom = ? ORDER BY ID_objet DESC');
$req3->execute(array($_POST['nom']));
$res=$req3->fetch();

$req4= $bdd -> prepare('SELECT ID_personne from personne where adresse_mail=?');
$req4->execute(array($_SESSION['adresse_mail']));
$res4 = $req4 -> fetch();

$req2 = $bdd->prepare('INSERT INTO vendeur (date_vente, ID_personne,ID_objet) VALUES(:date_vente, :ID_personne,:ID_objet)');
$req2-> execute(array(
'date_vente'=>date("Y-m-d H:i:s"),
'ID_personne'=>$res4['ID_personne'], 
'ID_objet'=>$res['ID_objet']));

// Redirection du visiteur vers la page d'acceuil
header("Status: 301 Moved Permanently", false, 301);
header('Location: /coroshop/index.php');

?>
