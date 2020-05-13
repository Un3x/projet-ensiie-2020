<html lang="fr">
<?php
?>
<head>
    <?php
include_once '../src/view/head.php';

?>
    <link rel="stylesheet" href="./css/create_ad.css">
</head>

<body>
    <?php include_once '../src/view/header.php' ?>
	<p1>Modifiez Votre annonce</p1><br /><br /><br/>
    <?php
    $adId = $_POST['ad_id'];
    include '../src/Factory/DbAdaperFactory.php';
    $connexion = (new DbAdaperFactory())->createService();
    $req=$connexion->prepare('SELECT title,description, keyWords FROM "ad" WHERE id=:adId');
    $req->bindParam(":adId",$adId);
    $req->execute();
    $req=$req->fetch();
    print_r($req['description']);
    ?>
	<form method="post" action="/modiftable.php">

	<p>Titre (*)</p> <input type="text" name="title" size="25" value="<?=$req['title']; ?>" required>


	<p>Description de l'annonce (*) <textarea class="form-control" type="text" name="description" size="600" rows="10" required><?= $req['description']; ?></textarea> (maximum 600 caractères)</p>


	<p>Choisissez des mots-clés (min. 1, max. 3) pour donner de la visibilité à votre annonce: (mot_clé 1; mot_clé 2; ...)
		<input type="text" name="keyWords" size="50"  value="<?= $req['keywords']; ?>" required> </p>
		
    <input name="adId" type="hidden" value="<?= $adId; ?>">
	<p> <input name="validation" type="submit" value="Confirmer les changements"> </p>
	</form>
    <?php include_once '../src/view/footer.php' ?>
</body>
</html>
