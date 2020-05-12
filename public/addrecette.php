<?php

include '../src/Recette.php';
include '../src/RecetteRepository.php';
include '../src/Factory/DbAdaperFactory.php';
session_start();

$dbAdaper = (new DbAdaperFactory())->createService();
$recetteRepository = new \Recette\RecetteRepository($dbAdaper);

if(!isset($_SESSION['id'])):
{
	header('Location: page_connexion.php?erreur=notConnected');
}
endif;

$idrecette = $recetteRepository->addRecette($_POST); //Ajout de la recette dans la bdd
?>

<html>
<head>
	<title>EpicEvry</title>
	<meta charset="utf-8">
</head>
<body>
//Script javascript pour transmettre les informations via un POST à la page suivante automatiquement
<form name="transitData" method=POST action="legumeedition.php">
    <input type="hidden" name="last_recette" value=<?= $idrecette ?> />
</form>

<script type="text/javascript">
    document.transitData.submit();
</script>
</body>
</html>