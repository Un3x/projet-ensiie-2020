<h1> <?php echo $data['story']->getTitle(); ?></h1>

<p><b>Auteur :</b> <?php echo $data['story']->getAuthor(); ?></p>

<p><b>Summary</b></p>

<p> <?php echo $data['story']->getSummary(); ?></p>

<form method="get" action="story.php">
	<input type="hidden" name="storyId" value="<?php echo $data['story']->getId(); ?>"/>
	<button type="submit" class="btn btn-primary">Commencer</button>
</form>

<br/><br/>

<!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php if ($data['canRate'])
{ ?>
<p>Notez cette histoire !</p>

<form method="post" action="rateManager.php">
<input type="radio" value=1 name="rate"/>
<label for="e1">1</label>
<input type="radio" value=2 name="rate"/>
<label for="e2">2</label>
<input type="radio" value=3 name="rate"/>
<label for="e3">3</label>
<input type="radio" value=4 name="rate"/>
<label for="e4">4</label>
<input type="radio" value=5 name="rate" checked/>
<label for="e5">5</label>
<input type="hidden" name="storyId" value=<?php echo $data['story']->getId(); ?> />
<button type="submit" name="rate_story" class="btn btn-primary">Noter !</button>
</form>

<?php } elseif ($data['alreadyRated']) { ?>
	<p>Vous avez déjà voté !</p>
<?php } else { ?>
	<p>Vous devez vous connecter pour voter.</p>
<?php } ?>

<div id="rating">
<!--affichage des etoiles -->
<?php 
if ($data['avg_rate']<1) {
	echo '
	<span class="fa fa-star"></span>
	<span class="fa fa-star"></span>
	<span class="fa fa-star"></span>
	<span class="fa fa-star"></span>
	<span class="fa fa-star"></span>';
	}
if ($data['avg_rate']>=1 && $data['avg_rate']<2) {
	echo '
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star"></span>
	<span class="fa fa-star"></span>
	<span class="fa fa-star"></span>
	<span class="fa fa-star"></span>';
	}
if ($data['avg_rate']>=2 && $data['avg_rate']<3) {
	echo '
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star"></span>
	<span class="fa fa-star"></span>
	<span class="fa fa-star"></span>';
	}
if ($data['avg_rate']>=3 && $data['avg_rate']<4) {
	echo '
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star"></span>
	<span class="fa fa-star"></span>';
	}
if ($data['avg_rate']>=4 && $data['avg_rate']<5) {
	echo '
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star"></span>';
	}
if ($data['avg_rate']==5) {
	echo '
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star checked"></span>';
	}
?>
<p> <?php echo $data['avg_rate'] ?> en moyenne, basé sur <?php echo $data['count'] ?> notes.</p>
<hr style="border:3px solid #f1f1f1">

<div class="row">
  <div class="side">
    <div>5 star</div>
  </div>
  <div class="middle">

      <div class="bar-5"></div>

  </div>
  <div class="side right">
    <div><?php echo $data['star5'] ?></div>
  </div>
  <div class="side">
    <div>4 star</div>
  </div>
  <div class="middle">

      <div class="bar-4"></div>

  </div>
  <div class="side right">
    <div><?php echo $data['star4'] ?></div>
  </div>
  <div class="side">
    <div>3 star</div>
  </div>
  <div class="middle">

      <div class="bar-3"></div>

  </div>
  <div class="side right">
    <div><?php echo $data['star3'] ?></div>
  </div>
  <div class="side">
    <div>2 star</div>
  </div>
  <div class="middle">

      <div class="bar-2"></div>

  </div>
  <div class="side right">
    <div><?php echo $data['star2'] ?></div>
  </div>
  <div class="side">
    <div>1 star</div>
  </div>
  <div class="middle">

      <div class="bar-1"></div>

  </div>
  <div class="side right">
    <div><?php echo $data['star1'] ?></div>
  </div>
</div>
</div>

<br/><br/>

<h2>Comments</h2>

<?php if (isset($_SESSION['id'])) { ?>
<form method="post" action="commentManager.php">
	<input type="hidden" name="storyId" value="<?php echo $data['story']->getId(); ?>"/>
	<textarea name="text"></textarea><br/><br/>
	<div class="text-right">
	<button type="submit" class="btn btn-primary" name="newComment">Commenter</button>
	</div>
</form>
<?php } else { ?>
	<p>Vous devez être connecté pour commenter une histoire</p>
<?php }?>

<div class="comments">
<?php
foreach ($data['comments'] as $comment) {
	echo '
	<div class="media border p-3">
  		<div class="media-body">
    		<h4>'.$comment->getUser().' <small><i>Aventurier débutant</i></small></h4>
    		<p>'.$comment->getText().'</p>
		</div>';
		if (isset($_SESSION['admin'])){
			echo '
			<form method="post" action="commentManager.php" onsubmit="return areYouSure()">
			<input type="hidden" name="commentId" value='.$comment->getId().' />
			<button type="submit" name="delCom" class="btn btn-danger">Supprimer</button>
			</form>';
		}
	echo '</div>';
} ?>
</div>

