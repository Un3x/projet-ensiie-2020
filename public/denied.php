<?php
include_once "../src/Utils/autoloader.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>VocasIItE | Non autorisé</title>
	<link rel="icon" type="image/png" href="/img/logo.png">
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/lib/bulma.css">
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<style>
		.message p {
			margin-bottom: 1em;
		}
	</style>
</head>

<body>
	<?php include_once '../src/View/navbar.php';
    ?>
	<section class="section">
		<div class="container">
			<h3 id="title" class="title is-3">Vous n'avez pas les droits pour accéder à cette page.</h3>
			<?php if (!isAuthenticated()): ?>
			<article class="message is-info">
        <div class="message-body">
          <p>Connectez-vous, ça règlera sans doute le problème !</p>
					<form action="/OAuth.php" method="post">
						<input id="ariseIn" name="login" type="submit" value="Connexion AriseID" class="button is-info">
					</form>
        </div>
      </article>
			<?php endif; ?>
			<a class="button is-link" href="<?php
            if (isset($_GET["lastpage"])) {
                echo($_GET["lastpage"]);
            } else {
                echo("/");
            }
            ?>">Revenir à la page précédente</a>
		</div>
	</section>

</body>
</html>
