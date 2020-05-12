<?php
include_once "../src/Utils/autoloader.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>VocasIItE | Accueil</title>
	<link rel="icon" type="image/png" href="/img/logo.png">
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/index.css">
	<link rel="stylesheet" href="/css/lib/bulma.css">
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>

<body>
	<?php include_once '../src/View/navbar.php'; ?>
	<section class="section">
		<div class="container">
			<h3 id="title" class="title is-3">Accueil de VocasIItE</h3>
			<div class="box content">
				<h4 class="is-4">
					Bienvenue sur VocasIItE, le site de l'association VocalIIsE.
				</h4>
				<p>
					<br>
					<?php
          if (isAuthenticated()) {
              $disp = $_SESSION["Pseudo"] ?? $_SESSION["Prenom"];
              echo "⭐&emsp;Coucou " . $disp . ", tu es bien connecté.";
          } else {
              echo "🔒&emsp;Vous pouvez vous connecter via AriseID, ou bien en tant qu'admin avec le bouton qui contient un cadenas.";
          } ?>
					<br>
					<br>Ici, vous trouverez tout ce que vous avez besoin de savoir sur chaque chanson enregistrée ou sur les soirées passées et à venir.
					<br>🎵&emsp;Si vous en avez la permission, vous pourrez même créer de nouvelles chansons, ajouter ses paroles et des URL pour les écouter.
					<br>🖊️&emsp;Il est toujours possible de modifier une chanson créée par vos soins.
					<br>🎉&emsp;De même, avec les bonnes permissions au sein de l'association, vous pourrez créer ou modifier des soirées (par exemple les rendre visible ou non aux non-membres !)
					<br>🎤&emsp;Si vous êtes un chanteur, vous devriez vous inscrire sur les chansons que vous voulez chanter dans la page de visualisation d'une soirée.
					<br>
					<br>🤠&emsp;Bonne visite ici !
				</p>
			</div>
		</div>
	</section>
</body>

</html>
