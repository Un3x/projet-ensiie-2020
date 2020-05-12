<?php 
//il faut verrifier que get ID objet existe
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$req1 = $bdd->prepare('SELECT  nom , texte , photo , prix FROM objet WHERE ID_objet = ?');
$req2 = $bdd->prepare('SELECT  nom , prenom , adresse_mail , numero_de_telephone FROM vendeur,personne WHERE vendeur.ID_objet = ? and vendeur.ID_personne=personne.ID_personne');
$req1->execute(array($_SESSION['ID_objet']));
$req2->execute(array($_SESSION['ID_objet']));
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <title>coroshope recherche un objet</title>
    </head>
    

<?php 
$resultat1 = $req1->fetch();
$resultat2 = $req2->fetch();

$nomO = $resultat1['nom']; 
$descriptionO = $resultat1['texte']; 
$photoO = $resultat1['photo']; 
$prixO = $resultat1['prix']; 
$nomP = $resultat2['nom'];
$prenomP= $resultat2['prenom'];
$adresse_mailP= $resultat2['adresse_mail'];
$numero_de_telephoneP= $resultat2['numero_de_telephone'];
echo '<h1 id= "nom_objet">' .htmlspecialchars($nomO).'</h1></br><img scr="imagesobjet/'.htmlspecialchars($photoO).'.png alt = "photo objet"/> <p id = "description">'
.htmlspecialchars($descriptionO).'</p></br><h2>Prix:</h2><p>'.htmlspecialchars($prixO).'</p></br>';
echo '<h2 id="contacter">Contacter moi:</h2></br>'.$prenomP.$nomP.'</br>'.$adresse_mailP.'</br>'.$numero_de_telephoneP;
if (isset($_SESSION['adresse_mail'])){
    echo '<form action="/coroshop/src/achat.php" method="post">
    <input type="submit" value="acheter">
    </form>';


}
else{
    echo'<p>vous ne pouvez pas acheter car vous n\'etes pas connecté</p>';
}
?>

</html>
