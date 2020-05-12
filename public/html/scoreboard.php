<html lang="fr">
	<?php
		$style_file = "/css/".basename(__FILE__, ".php").".css";
		include_once 'head.php'
	?>
	<body>
		<?php include_once 'header.php' ?>
		
		<section class="body-light">
			<div class="content-light">
				<h1>Tableau des scores</h1>
				<?php
					echo "<ul class=\"game-list\">";
					foreach ($players as $player => $perf)
					{
						echo "<li class=\"game-element\">";
						echo "<p>$player</p>";
						echo "<p class=\"won\">Victoires : ${perf[0]}</p>";
						echo "<p class=\"lost\">Défaites : ${perf[1]}</p>";
						echo "<p class=\"draw\">Nuls : ${perf[2]}</p>";
						echo "<p class=\"ratio\">Ratio : ${perf[3]}</p></li>";
					}
					echo "</ul>";
				?>
			</div>
		</section>
		
		<?php include_once 'footer.php' ?>
	</body>
</html>
