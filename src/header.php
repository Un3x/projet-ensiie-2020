<?php 
require "db.php";

if (session_status()==PHP_SESSION_NONE){
	session_start();
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Projet Web - Home</title>

	<meta charset="UTF-8">

	<link rel="stylesheet" href="styles.css">
</head>
<body>
<div id="top">
	<a href="home.php" id="home">
		<img src="diese.png" alt="Logo de Dièse" id="logo_diese">
	</a>
</div>

<div id="nav">

<ul id="nav_tool">
  	<li><a href="home.php">Accueil</a></li>

  	<li><a href="members.php">Membres</a></li>

 	<li><a href="projects.php">Projets</a></li>

 	<li><a href="events.php">Événements</a></li>

 	<li><a href="account.php">Compte</a></li>

 	<li><a href="admin.php">Admin</a></li>

  	<?php if(isset($_SESSION['auth'])): ?>
		<li style="float:right"><a class="active" href="logout.php">Se déconnecter</a></li>
  	<?php else: ?>
		<li style="float:right"><a class="active" href="login.php">Se connecter</a></li>
	
	  	<li style="float:right"><a class="active" href="register.php">S'inscrire</a></li>
  	<?php endif; ?>
</ul>
</div>

<div>
  	<?php if(isset($_SESSION['flash'])): ?>
		<?php foreach($_SESSION['flash'] as $type => $message): ?>
			<div class="alert alert-<?= $type; ?>">
				<?= $message; ?>
			</div>
		<?php endforeach; ?>
		<?php unset($_SESSION['flash']); ?>
  	<?php endif; ?>
</div>

