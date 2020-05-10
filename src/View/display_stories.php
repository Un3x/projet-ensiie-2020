<h1>Il est l'heure de jouer aux héros !</h1>
</br>
<p>Voici la liste des histoires auxquelles vous pouvez jouer pour le moment !</p>


<?php

//title_story[0] correspond au titre de la story actuelle.
foreach ($data['stories'] as $story) {
	
	echo'
	<form method="get" action="story_page.php">
	<input type="hidden" name="storyId" value="'.$story->getId().'"/>
	<button type="submit" class="btn btn-link">'.$story->getTitle().'</button>
</form>';
}
?>
