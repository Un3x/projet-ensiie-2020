<?php
require "header.php";

?>

<link rel="stylesheet" href="style/index.css">


<main>


<body>
	<div class = "containertitre">	
	<div class="row">
		<div class="col">
		<div class="titre">
		<h1>Nailly</h1>
		<p>Partagez vos trajets avec les habitants de Nailly</p>
		<p style="font-size: 20px; text-align: center;">Nous croyons en la solidarité au sein du village. C'est pour améliorer l'attraction de Nailly que nous avons créé cette plateforme web. Proposer ou demander des trajets pour aller faire les courses, aller voir votre famille, aller chez le médecin ou encore rentrer de boîte de nuit... Rendons la vie à Nailly meilleure en étant solidaire.</p>
		</div>
		</div>
		<div class="col">
		<img class="photoNailly" src="./img/nailly.jpeg">
		</div>
	</div>
</div>
	<br>
	
	<div class="row">
				<div class="col-4"><div class="vertical-center"><a href="nav/proposerTrajet.php" ><button class="indexButton">Proposer un Trajet</button></a></div></div>
				<div class="col-4"><div class="vertical-center"><a href="nav/demanderTrajet.php" ><button class="indexButton">Demander un Trajet</button></a></div></div>
				<div class="col-4">
					<div class="vertical-center">
						<a href="nav/afficherTrajets.php" ><button class="indexButton">Voir les Trajet</button></a>
					</div>
				</div>
	</div>
<br><br><br>
	<div class="row">
		<div style="text-align: center; margin: auto; width: 200px;font-size: 20px" class="col">
		<p>Gagnez des points en prenant des passagers et achetez des cartes essences, des places de théâtres, des places de cinéma...</p>
		</div>
	</div>



<br><br><br>
	<div class="row">
		<div class=containerproposer>
			<iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d85079.23065841179!2d3.1821486487711983!3d48.211894179779826!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e3!4m5!1s0x47ef054f58ae1e21%3A0x409ce34b30d5730!2sSens!3m2!1d48.200649999999996!2d3.28268!4m5!1s0x47ef118c46f5517f%3A0x409ce34b30d5da0!2s89100%20Nailly!3m2!1d48.223180899999996!2d3.2216969!5e0!3m2!1sfr!2sfr!4v1587483007543!5m2!1sfr!2sfr" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
		</div>
</div>

		</div>
		</div>

		</div>

	</div>
</main>



<?php
require "footer.php";
?>
