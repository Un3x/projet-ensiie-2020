<?php require 'header.php'
?>
<?php
if(!empty($_POST) && !empty($_POST['pseudo']) && !empty($_POST['mot_de_passe'])){
	$req = $pdo->prepare('SELECT * FROM users WHERE pseudo = ?');

	$req->execute([$_POST['pseudo']]);

	$res = $req->fetch();

	if(!$res){
		$_SESSION['flash']['danger']= 'Pseudo ou mot de passe incorrect';

		header('Location: login.php');

		exit();	
	} else{
		if(password_verify($_POST['mot_de_passe'],$res['mot_de_passe'])){
			session_start();

			$_SESSION['auth'] = $res;

			$_SESSION['flash']['success']="Vous êtes maintenant connecté";

			header('Location: account.php');

			exit();
		} else {
			$_SESSION['flash']['danger']= 'Pseudo ou mot de passe incorrect';

			header('Location: login.php');

			exit();	
		}
	}
}

?>
<h1>Se connecter</h1>

<form action="" method="POST">
	<div class="form-group">
		<label for="">Pseudo</label>
		<input type="text" name="pseudo" class="form-control"/>	
	</div>

	<div class="form-group">
		<label for="">Mot de passe</label>
		<input type="password" name="mot_de_passe" class="form-control"/>	
	</div>

	<button type="submit" class="btn btn-primary">Me connecter</button>
</form>

<?php require 'footer.php'?>
