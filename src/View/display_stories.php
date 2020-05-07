


<p>Voici la liste des histoires auquelles vous pouvez jouer pour le moment !</p>


<?php

//connection à la db
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























