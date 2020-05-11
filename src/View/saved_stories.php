<h1>Parties sauvegadées</h1>

<?php
foreach ($data['saves'] as $save) {
    echo '
    <div class="card" style="width:400px">
    <img class="card-img-top" src="'.$save->getStoryId().'.jpg" style="width:100%">
    <div class="card-body">
      <h4 class="card-title">'.$save->getStoryTitle().'</h4>
      <form method="get" action="story.php">
	    <input type="hidden" name="storyId" value="'.$save->getStoryId().'"/>
	    <input type="hidden" name="pageId" value="'.$save->getPageId().'"/>
	    <button type="submit" class="btn btn-primary">Reprendre</button>
      </form>
    </div>
  </div>';
}
?>