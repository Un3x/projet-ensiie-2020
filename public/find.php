<?php
session_start();
if(isset($_POST['Matière']))
{
  $matiere = $_POST['Matière'];
  $filiere = $_POST['filiere'];
  $annee = $_POST['annee'];
  $concours = $_POST['concours'];
  $themeP = $_POST['themeP'];
  $themeM = $_POST['themeM'];
  $themeI = $_POST['themeI'];

    // connexion à la base de données
    $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
           or die('Erreur de connexion  la base de données');
    echo $matiere;
    echo $annee;
    if ($matiere == "Choisir Matière"){
       $matiere="";
    }
    if ($annee == "Choisir Année"){
       $annee="";
    }
    
    if(($matiere !== "") || ($annee !== "") || (!empty($filiere)) || (!empty($concours)))
    {
	$select = "SELECT DISTINCT nom,id FROM sujet WHERE TRUE ";
	if ($matiere !== ""){
	   $select="".$select."AND matiere = '$matiere' ";
	}
	if ($annee !== ""){
	   $select="".$select."AND annee = '$annee' ";
	}
	if (!empty($filiere)){
	   $select="".$select."AND filiere IN ('".implode("','",$filiere)."')";
	}
	if (!empty($concours)){
	   $select="".$select."AND concours IN ('".implode("','",$concours)."')";
	}
	if (!empty($themeM)){
	   $select="".$select."AND themes IN ('".implode("','",$themeM)."')";
	}
	$select="".$select.";";
	$exec_requete = pg_query($select)
		      or die('Erreur commande générale');
	if(pg_num_rows($exec_requete) > 0)
        {
	   $items = array();

	   while($row = pg_fetch_array($exec_requete)) {
    	   	      $items[] = [$row['nom'],$row['id']];
	   }
           $_SESSION['nom'] = $items;
           header('Location: resultat.php');
        }
        else
        {
           header('Location: recherche.php?erreur=1');
        }
    }
    else
    {
       header('Location: recherche.php?erreur=2'); 
    }
}
else
{
   header('Location: recherche.php');
}
pg_close($db); 
?>