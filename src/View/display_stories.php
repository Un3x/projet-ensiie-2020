


<p>Voici la liste des histoires auxquelles vous pouvez jouer pour le moment !</p>


<?php

//connexion à la db
$db = (new DbAdaperFactory())->createService();


$query = $db->query("SELECT title FROM story");


$title = $query->fetchAll();

//title_story[0] correspond au titre de la story actuelle.
foreach($title as $title_story) {
	echo "Commencer l'histoire '$title_story[0]' en cliquant ";
	echo '<a href="../../cite_des_voleurs.php"><strong>ici</strong></a>'; 
	echo "<br />";
}
?>

<form method="get" action="story.php">
	<input type="hidden" name="storyId" value="1"/>
	<button type="submit" class="btn btn-link">La Cité des Voleurs</button>
</form>