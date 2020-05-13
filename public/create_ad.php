<html lang="fr">
<?php

session_start();
if (!isset($_SESSION['id'])) {
  header ('Location: index.php');
	exit();
}
?>
<head>
<?php include_once '../src/view/head.php' ?>
<link rel="stylesheet" href="./css/create_ad.css">
</head>

<body>
    <?php include_once '../src/view/header.php' ?>
  <br />
  <p1>Créez votre annonce:</p1><br />
  <br />
  <br />
  <br />
  <br />

	<form method="post" action="/ajoutAd.php">

	<p>Titre (*) </p><input type="text" name="title" size="25" required></p>

  <br />
	<p>Description de l'annonce (*) <textarea class="form-control" type="text" name="description" size="600"  rows="10"  required></textarea> (maximum 600 caractères)</p>

  <br />
	<p>Choisissez des mots-clés (min. 1, max. 3) pour donner de la visibilité à votre annonce: (mot_clé 1; mot_clé 2; ...)</p>
		<input type="text" name="keyWords" size="50" required >
		


	<p> <input name="ad_id" type="submit" value="Valider"> </p>
	</form>
    <?php include_once '../src/view/footer.php' ?>
</body>
</html>
