<h1>Parties sauvegardées</h1>

<?php
if ($data['saves']){
  foreach ($data['saves'] as $save) {
      echo '
      <div class="card" style="width:400px">
      <img class="card-img-top" src="'.$save->getStoryId().'.jpg" style="width:100%">
      <div class="card-body">
        <h4 class="card-title">'.$save->getStoryTitle().'</h4>
        <div class="row">
        <div class="col-sm-8">
        <form style="margin: 0px; width: 50%;" method="get" action="story.php">
        <input type="hidden" name="storyId" value="'.$save->getStoryId().'"/>
        <input type="hidden" name="pageId" value="'.$save->getPageId().'"/>
        <button type="submit" class="btn btn-primary">Reprendre</button>
        </form>
        </div>
        <div class="col-sm-4">
        <form style="margin: 0px; width: 50%;" method="post" action="saveManager.php" onsubmit="return areYourSure()">
        <input type="hidden" name="saveId" value="'.$save->getId().'"/>
        <button type="submit" class="btn btn-danger" name="deleteSave">Supprimer</button>
        </form>
        </div>
        </div>
      </div>
    </div>';
  }
}else{
  echo "<br/><h4>Vous n'avez pas de partie sauvegardée pour le moment</h4>";
}
?>