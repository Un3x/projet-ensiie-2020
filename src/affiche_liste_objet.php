<?php

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
if  (isset($_POST['categorie'])){
        $categorie=$_POST['categorie'];
}
else{
        if (isset($_GET['categorie'])){
                $categorie=$_GET['categorie'];
        }
}
if (isset($_POST['prix'])){
        $prix=$_POST['prix'];
}
else{
        if (isset($_GET['prix'])){
                $prix=  $_GET['prix'];
        }
}

if (isset($categorie)){
        if (isset($prix)){
                
                        $req = $bdd->prepare('SELECT  objet.ID_objet , objet.nom , objet.photo , objet.prix FROM objet JOIN vendeur on objet.ID_objet=vendeur.ID_objet  WHERE objet.categorie=? AND objet.prix<? ORDER BY vendeur.date_vente DESC ');
                        $req->execute(array(htmlspecialchars($categorie), htmlspecialchars($prix)));
        }
        else{
               
                        $req = $bdd->prepare('SELECT  ID_objet , nom , photo ,prix FROM objet ,vendeur  WHERE objet.ID_objet=vendeur.ID_objet ,objet.categorie=?  ORDER BY vendeur.date_vente DESC');
                        $req->execute(array(htmlspecialchars($categorie)));
        }
}
else{
        if (isset($prix)){
                
                        
               
                        $req = $bdd->prepare('SELECT  ID_objet , nom , photo ,prix FROM objet ,vendeur  WHERE objet.ID_objet=vendeur.ID_objet ,objet.prix<=?  ORDER BY vendeur.date_vente DESC');
                        $req->execute(array( htmlspecialchars($prix)));
        }
        else{
                
                
                        $req = $bdd->prepare('SELECT  ID_objet , nom , photo ,prix FROM objet ,vendeur  WHERE objet.ID_objet=vendeur.ID_objet   ORDER BY vendeur.date_vente DESC');
                        $req->execute(array());
        }
}
if (!isset($_SESSION['page'])){
        $i=1;
}
else{
        $i = $_SESSION['page'];
}
$j=0;
while ($donnees = $req->fetch())
{
     $voila = $bdd->prepare('SELECT ID_acheteur FROM acheteur where ID_objet=? ');
     $voila->execute(array($donnees['ID_objet']));
     if (!$troubl=$voila->fetch()){
?><div><?php
        if ($j==($i-1)*10){
                echo'<ul>
                        <li>
                                '.$donnees["nom"]. ' 
                                '.$donnees["prix"].'€';
                        
                                echo '<a href="../public/achat_page_complette.php?ID_objet='.$donnees['ID_objet'].'">Aller voir</a>
                        </li>';
                        $j=$j+1;
        }
        elseif ($j<($i-1)*10){
                $j=$j+1;
        }
        elseif ($j<$i*10-1){
                echo '<li>
                '.$donnees["nom"].'  
                '.$donnees["prix"].'€ ';
                
                echo ' <a href="../public/achat_page_complette.php?ID_objet='.$donnees['ID_objet'].'">Aller voir</a>
                </li>';
                $j=$j+1;
        }
        elseif ($j==$i*10-1){
                echo '<li>
                '.$donnees["nom"].' 
                '.$donnees["prix"].'€';
                
                echo ' <a href="../public/achat_page_complette.php?ID_objet='.$donnees['ID_objet'].'">Aller voir</a>
                </li>
                </ul>';
                $j=$j+1;
        }
        else {
                $j=$j+1;
        } 
     }
}
?></div ><?php
if ($j<$i*10){
        if ($j==0){
                ?>
                <p>Il n'y a pas d'objet qui corresponde à votre description</p>
                <?php
        }
        else{
                echo'</ul>';
                ?>
                <p>Il n'y a plus d'objet qui corresponde à votre description</p>
                <?php
        }
}

$page_max=intdiv($j,10)+1;
echo'<p>Vous êtes à la page '.$i.'/'.$page_max.'
<form action="../public/trouver_objet_page_complette.php?categorie='.$categorie.'&amp;prix='.$prix.'" method="post">
<label for="page">A quelle page voulez-vous aller?</label>
<input type="number" min="1" max="'.$page_max.'" name="page" id="page" required />
<input type="submit" value="rechercher"/>
</form>'



?>
