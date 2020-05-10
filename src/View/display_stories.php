


<p>Voici la liste des histoires auxquelles vous pouvez jouer pour le moment !</p>


<?php

//title_story[0] correspond au titre de la story actuelle.
foreach ($data['stories'] as $story) {
	
	echo'
	<form method="get" action="story.php">
	<input type="hidden" name="storyId" value="'.$story->getId().'"/>
	<button type="submit" class="btn btn-link">'.$story->getTitle().'</button>
</form>';
}
?>
