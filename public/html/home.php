<html lang="fr">
	<?php
		$style_file = "/css/".basename(__FILE__, ".php").".css";
		include_once 'head.php'
	?>
	<body>
		<?php include_once 'header.php' ?>
		
		<section class="body-light">
			<div class="content-light">
				<center>
				<p>Bienvenue sur le site Morpiien ! 
				</center>
				Regardez les utilisateurs connectés, et laissez-vous tenter par une partie de morpion !
				</p>
				<h1>Utilisateurs connectés</h1>
				<?php
					if ($connected_users && isset($connected_users['connected_users']))
					{
						echo '<ol class="user-list">';
						foreach ($connected_users['connected_users'] as $user => $status)
						{
							echo "<li class=\"user-element\"><p>$user";
							if ($user == $_SESSION["username"]) echo " (vous)</p></li>\n";
							else echo "</p><p>$status</p><p class=\"challenge\">Défier</p></li>\n";
						}
						echo "</ol>";
					}
				?>
			</div>
		</section>
		
		<?php include_once 'footer.php' ?>
	</body>
</html>
