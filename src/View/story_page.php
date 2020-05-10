<h1> <?php echo $data['story']->getTitle(); ?></h1>

<p><b>Auteur :</b> <?php echo $data['story']->getAuthor(); ?></p>

<p><b>Summary</b></p>

<p> <?php echo $data['story']->getSummary(); ?></p>

<form method="get" action="story.php">
	<input type="hidden" name="storyId" value="<?php echo $data['story']->getId(); ?>"/>
	<button type="submit" class="btn btn-primary">Commencer</button>
</form>






<h2>Comments</h2>
<div class="comments">
<?php
foreach ($data['comments'] as $comment) {
	echo '
	<div class="media border p-3">
  		<div class="media-body">
    		<h4>'.$comment->getUser().' <small><i>Aventurier débutant</i></small></h4>
    		<p>'.$comment->getText().'</p>
  		</div>
	</div>';
} ?>
</div>