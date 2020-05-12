<?php
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Recette.php';
include '../src/RecetteRepository.php';
include '../src/Aliment.php';
include '../src/AlimentRepository.php';
include '../src/Factory/DbAdaperFactory.php';
session_start();

$dbAdaper = (new DbAdaperFactory())->createService();
$recetteRepository = new \Recette\RecetteRepository($dbAdaper);
$alimentRepository =  new \Aliment\AlimentRepository($dbAdaper);

//On vérifie que l'utilisateur est connecté
if(!isset($_SESSION['id'])):
{
	header('Location: page_connexion.php?erreur=notConnected');
}
endif;

//On récupère l'identifiant du légume et l'ajoute à la relation légume recette
$id_leg = $alimentRepository->fetchLegId($_POST['nom_legume']);
$idrecette = $recetteRepository->addLegumeToRecette($id_leg[0], $_POST['qte'], $_POST['id_recette']);

?>

<html>
<head>
	<title>EpicEvry</title>
	<meta charset="utf-8">
</head>
<body>
//FOrmulaire qui envoie automatiuqmeent les infos sur la recette à la page legumeediton.php automatiquement
<form name="transitData" method=POST action="legumeedition.php">
    <input type="hidden" name="last_recette" value=<?= $_POST['id_recette'] ?> />
</form>

<script type="text/javascript">
    document.transitData.submit();
</script>
</body>
</html>