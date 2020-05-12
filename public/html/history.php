<html lang="fr">
	<?php
		$style_file = "/css/".basename(__FILE__, ".php").".css";
		include_once 'head.php'
	?>
	<body>
		<?php include_once 'header.php' ?>
		
		<section class="body-light">
			<div class="content-light">
				<h1>Historique des parties</h1>
				<?php
					echo "<ul class=\"game-list\">";
					foreach ($games as $game)
					{
						echo "<li class=\"game-element\">";
						echo "<p>".date_format($game->getPlayedAt(), 'd-m-Y H:i:s')."</p>";
						echo ($game->getWinner() === 'oui' ? "<p class=\"won\">Gagné</p>" :
								($game->getWinner() === 'non' ? "<p class=\"lost\">Perdu</p>" :
									"<p class=\"draw\">Nul</p>"))."</li>";
					}
					echo "</ul>";
				?>
			</div>
		</section>
		
		<?php include_once 'footer.php' ?>
	</body>
</html>
