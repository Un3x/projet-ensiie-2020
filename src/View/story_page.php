<h1> <?php echo $data['story']->getTitle(); ?></h1>

<p><b>Auteur :</b> <?php echo $data['story']->getAuthor(); ?></p>

<p><b>Summary</b></p>

<p> <?php echo $data['story']->getSummary(); ?></p>

<form method="get" action="story.php">
	<input type="hidden" name="storyId" value="<?php echo $data['story']->getId(); ?>"/>
	<button type="submit" class="btn btn-primary">Commencer</button>
</form>


 <!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<span class="heading">User Rating</span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star"></span>
<p> <?php echo $data['avg_rate'] ?> en moyenne, basé sur <?php echo $data['count'] ?> notes.</p>
<hr style="border:3px solid #f1f1f1">

<p>Notez cette histoire !</p>
<form method="post" action="rate&comment.php">
<input type="radio" value=1 name="rate"/>
<input type="radio" value=2 name="rate"/>
<input type="radio" value=3 name="rate"/>
<input type="radio" value=4 name="rate"/>
<input type="radio" value=5 name="rate"/>
</form>

<div class="row">
  <div class="side">
    <div>5 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-5"></div>
    </div>
  </div>
  <div class="side right">
    <div><?php echo $data['star5'] ?></div>
  </div>
  <div class="side">
    <div>4 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-4"></div>
    </div>
  </div>
  <div class="side right">
    <div><?php echo $data['star4'] ?></div>
  </div>
  <div class="side">
    <div>3 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-3"></div>
    </div>
  </div>
  <div class="side right">
    <div><?php echo $data['star3'] ?></div>
  </div>
  <div class="side">
    <div>2 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-2"></div>
    </div>
  </div>
  <div class="side right">
    <div><?php echo $data['star2'] ?></div>
  </div>
  <div class="side">
    <div>1 star</div>
  </div>
  <div class="middle">
    <div class="bar-container">
      <div class="bar-1"></div>
    </div>
  </div>
  <div class="side right">
    <div><?php echo $data['star1'] ?></div>
  </div>
</div> 
