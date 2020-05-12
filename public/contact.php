<?php
include_once "../src/Utils/autoloader.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>VocasIItE | Contact</title>
	<link rel="icon" type="image/png" href="/img/logo.png">
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/lib/bulma.css">
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>

<body>
	<?php include_once '../src/View/navbar.php'; ?>
	<section class="section">
		<div class="container">
			<h3 id="title" class="title is-3">Nous contacter</h3>
      <article class="message">
        <div class="message-header">
          <p>Créateurs du site web</p>
        </div>
        <ul class="list is-hoverable">
          <li class="list-item">
						<div class="level">
							<span class="level-left">Pierre-Marie "PM" Lefrançois</span>
							<div class="level-right">
								<a class="icon level-item" href="mailto:pm@lefra.ovh">
									<i class="fas fa-envelope"></i>
								</a>
							</div>
						</div>
          </li>
          <li class="list-item">
            <span>François "Fluff" Lefoulon</span>
          </li>
          <li class="list-item">
            <span>Valentin "Krokro" Dubromer</span>
          </li>
          <li class="list-item">
            <span>Rathea "Rathea" Uth</span>
          </li>
        </ul>
      </article>
		</div>
	</section>
</body>

</html>
