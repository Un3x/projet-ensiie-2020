<?php require 'header.php'?>

<?php

if(!empty($_POST)){
	$errors = array();

	if(empty($_POST['nom']) || !preg_match('/^[a-zA-Z\-]+$/',$_POST['nom'])){
		$errors['nom'] = "Nom invalide (alphanumérique)";
	}

	if(empty($_POST['prenom']) || !preg_match('/^[a-zA-Z\-]+$/',$_POST['prenom'])){
		$errors['prenom'] = "Prénom invalide (alphanumérique)";
	}

	if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$errors['email'] = "Email invalide";
	} else {
		$req = $pdo->prepare('SELECT id FROM users WHERE email = ?');

		$req->execute([$_POST['email']]);

		$user = $req->fetch();

		if($user){
			$errors['email'] = "Cet email est déjà utilisé";
		}
	}

	if(empty($_POST['telephone']) || !preg_match('/^[0-9]+$/',$_POST['telephone'])){
		$errors['telephone'] = "Téléphone invalide";
	}

	if(empty($_POST['pseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/',$_POST['pseudo'])){
		$errors['pseudo'] = "Pseudo invalide (alphanumérique)";
	} else {
		$req = $pdo->prepare('SELECT id FROM users WHERE pseudo = ?');

		$req->execute([$_POST['pseudo']]);

		$user = $req->fetch();

		if($user){
			$errors['pseudo'] = "Ce pseudo est déjà pris";
		}
	}

	if(empty($_POST['mot_de_passe']) || $_POST['mot_de_passe'] != $_POST['mot_de_passe_confirme']){
		$errors['mot_de_passe'] = "Mot de passe invalide";
	}

	if(empty($errors)){
		$req = $pdo->prepare("INSERT INTO users SET nom = ?, prenom = ?, email = ?, telephone = ?, pseudo = ?, mot_de_passe = ?");

		$mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);

		$req->execute([$_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['telephone'],$_POST['pseudo'],$mot_de_passe]);

		$_SESSION['flash']['success'] ="Votre compte a bien été créé";

		header('Location: login.php');

		exit();	
	}
}
?>


<h1>S'inscrire</h1>

<?php if(!empty($errors)): ?>

<div class="alert alert-danger">
	<p>Vous n'avez pas rempli le formulaire correctement</p>
	<ul>
		<?php foreach($errors as $error): ?>
			<li><?= $error; ?></li>
		<?php endforeach; ?>
	</ul>
</div>

<?php endif;?>
<form action="" method="POST">

	<div class="form-group">
		<label for="">Nom</label>
		<input type="text" name="nom" class="form-control" required/>	
	</div>

	<div class="form-group">
		<label for="">Prénom</label>
		<input type="text" name="prenom" class="form-control" required/>	
	</div>

	<div class="form-group">
		<label for="">Email</label>
		<input type="email" name="email" class="form-control" required/>	
	</div>

	<div class="form-group">
		<label for="">Téléphone</label>
		<input type="text" name="telephone" class="form-control" required/>	
	</div>

	<div class="form-group">
		<label for="">Pseudo</label>
		<input type="text" name="pseudo" class="form-control" required/>	
	</div>

	<div class="form-group">
		<label for="">Mot de passe</label>
		<input type="password" name="mot_de_passe" class="form-control" required/>	
	</div>

	<div class="form-group">
		<label for="">Confirmez votre mot de passe</label>
		<input type="password" name="mot_de_passe_confirme" class="form-control" required/>	
	</div>

	<button type="submit" class="btn btn-primary">M'inscrire</button>

</form>
<?php require 'footer.php'?>
