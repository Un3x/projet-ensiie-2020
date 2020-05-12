<!DOCTYPE html>
<?php
include '../src/User.php';
include '../src/UserRepository.php';
  
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
session_start();

//Si l'utilisateur est connecté
if(isset($_SESSION['id']))
{
	$user = $userRepository->fetchUser($_SESSION['id']);
	
	if(isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND $_POST['newprenom'] != $user->getPrenom())
	{
		$newprenom = $_POST['newprenom'];
		$user->setPrenom($newprenom);
	}
	
	if(isset($_POST['newnom']) AND !empty($_POST['newnom']) AND $_POST['newnom'] != $user->getNom())
	{
		$newnom = $_POST['newnom'];
		$user->setNom($newnom);
	}
	
	if(isset($_POST['newemail']) AND !empty($_POST['newemail']) AND $_POST['newemail'] != $user->getEmail())
	{
		$newemail = $_POST['newemail'];
		$user->setEmail($newemail);
	}
	
	if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2']))
	{
		$newmdp1 = $_POST['newmdp1'];
		$newmdp2 = $_POST['newmdp2'];
		if($newmdp1 == $newmdp2)
		{
			$user->setPassword($newmdp1);
		}
}
//Si l'utilisateur n'est pas connecté
if(!empty($_POST)):
$userRepository->updateUser($user);
header("Location: userprofile.php?id={$user->getId()}");
endif;
?>

<html>
<head>
	<title>Edition de profil</title>
	<meta charset="utf-8">
	<?php include "css_head.html" ?>
	<style>
		#ecrire {color : #26272B; text-align : center; font-weight : bold; font-size : 50px;}
		label {color : #FFFACD; font-weight : bold; margin-left : 550px;}
		.yellow {background-color : #BECFBD; border : thin solid #26272B;}
		#bouton {font-weight : bold; color : #FFFFFF;  background-color : #26272B; border : none;}


		.colorgraph {
		height: 5px;
		border-top: 0;
		background: #26272b;
		border-radius: 5px;
		.form-group {width:100pw;}
	</style>
</head>
<body style="background-color:#677179">
  <?php include "header.html" ?><br /><br /><br /><br /><br />
  
	<div align="center">
		<h2 id="ecrire">Édition du profil utilisateur</h2><br /><br />

		<!-- Formulaire pour éditer son profil -->
			<form role="form" method="POST" action="">
		  <hr class="colorgraph">
			  <div class="row">
			    <div class="col-xs-12 col-sm-6 col-md-6">
			      <!-- Nom -->
			      <div class="form-group">
				<input type="text" name="newprenom" id="first_name" class="form-control input-lg" placeholder="Prénom" tabindex="1">
			      </div>
			      </div><div class="col-xs-12 col-sm-6 col-md-6">
			      <!-- Prenom -->
			      <div class="form-group">
				<input type="text" name="newnom" id="last_name" class="form-control input-lg" placeholder="Nom" tabindex="2">
			      </div>
			    </div>
			  </div>
			  <!-- Email -->
			  <div class="form-group">
			    <input type="email" name="newemail" id="email" class="form-control input-lg" placeholder="E-mail" tabindex="4">
			  </div>
			  <div class="row">
			    <div class="col-xs-12 col-sm-6 col-md-6">
			      <!-- Mot de passe -->
			      <div class="form-group">
				<input type="password" name="newmdp1" id="password" class="form-control input-lg" placeholder="Mot de passe" tabindex="5">
			      </div>
			    </div>
			    <div class="col-xs-12 col-sm-6 col-md-6">
			      <!-- Mot de passe de confirmation-->
			      <div class="form-group">
				<input type="password" name="newmdp2" id="password_confirmation" class="form-control input-lg" placeholder="Confirmez votre mot de passe" tabindex="6">
			      </div>
			    </div>
			  </div>
			  <hr class="colorgraph">
			    
			  <input id="bouton" type="submit" value="Enregistrer" />

			</form>
			
		
		
<?php if(isset($msg)) { echo $msg; } ?>
	</div>
	</div><br /><br /><br /><br /><br />
<?php include "footer.html" ?>
</body>
</html>
<?php
}
else
{
	header("Location: page_connexion.php");
}
?>
