<?php

require_once'functions.php';

logged_only();

require 'header.php';

if( $_SESSION['auth']['admin'] == 0 ){
	$_SESSION['flash']['danger']="Vous n'avez pas les droits administrateurs";

	header('Location: account.php');

	exit();
}

if(!empty($_POST)){
	if(!empty($_POST['delete_user'])){
		$req = $pdo->prepare("SELECT * FROM users WHERE pseudo = ?");

		$req->execute([$_POST['delete_user']]);

		$row = $req->rowCount();

		if($row==0){
			$_SESSION['flash']['danger'] ="Ce membre n'existe pas";

			header('Location: admin.php');

			exit();	
		}else{
			$req = $pdo->prepare("DELETE FROM users WHERE pseudo = ?");

			$req->execute([$_POST['delete_user']]);

			$_SESSION['flash']['success'] ="Membre supprimé avec succès";

			header('Location: admin.php');

			exit();
		}	
	}
	if(!(empty($_POST['name_project']) || empty($_POST['name_client']) || empty($_POST['name_head']) || empty($_POST['deadline']))){
		$req = $pdo->prepare("SELECT * FROM projects WHERE nom_projet= ?");

		$req->execute([$_POST['name_project']]);

		$row = $req->rowCount();

		if($row>0){
			$_SESSION['flash']['danger'] ="Ce nom de projet existe déja";

			header('Location: admin.php');

			exit();	
		}

		$req = $pdo->prepare("SELECT * FROM users WHERE pseudo= ?");

		$req->execute([$_POST['name_head']]);

		$row = $req->rowCount();

		if($row==0){
			$_SESSION['flash']['danger'] ="Le chef de projet mentionné n'est pas enrgistré";

			header('Location: admin.php');

			exit();		
		}else{
			$req = $pdo->prepare("INSERT INTO projects (nom_projet,nom_client,nom_chef_de_projet,echeance) VALUES (?,?,?,?)");

			$req->execute([$_POST['name_project'],$_POST['name_client'],$_POST['name_head'],$_POST['deadline']]);

			$_SESSION['flash']['success'] ="Projet créé avec succès";

			header('Location: admin.php');

			exit();
		}	
	}
	if(!(empty($_POST['name_event']) || empty($_POST['place_event']) || empty($_POST['date_event']) || empty($_POST['respo_event']))){
		$req = $pdo->prepare("SELECT * FROM events WHERE nom_event= ?");

		$req->execute([$_POST['name_event']]);

		$row = $req->rowCount();

		if($row>0){
			$_SESSION['flash']['danger'] ="Ce nom d'événement existe déja";

			header('Location: admin.php');

			exit();	
		}

		$req = $pdo->prepare("SELECT * FROM users WHERE pseudo = ?");

		$req->execute([$_POST['respo_event']]);

		$row = $req->rowCount();

		if($row==0){
			$_SESSION['flash']['danger'] ="Le responsable mentionné n'est pas enrgistré";

			header('Location: admin.php');

			exit();		
		} else{
			$stmt = $pdo->prepare('SELECT id FROM users WHERE pseudo = ?');

			$stmt->execute([$_POST['respo_event']]);

			$res = $stmt->fetch(\PDO::FETCH_OBJ);

			$req = $pdo->prepare("INSERT INTO events (nom_event,lieu_event,date_event,respo_event) VALUES (?,?,?,?)");

			$req->execute([$_POST['name_event'],$_POST['place_event'],$_POST['date_event'],$res->id]);

			$_SESSION['flash']['success'] ="Événement créé avec succès";

			header('Location: admin.php');

			exit();
		}	
	}
	if(!(empty($_POST['pa_name']) || empty($_POST['pr_name']))){
		$stmt = $pdo->prepare('SELECT id FROM users WHERE pseudo = ?');

		$stmt->execute([$_POST['pa_name']]);

		$res1 = $stmt->fetch(\PDO::FETCH_OBJ);

		$stmt = $pdo->prepare('SELECT id_projet FROM projects WHERE nom_projet = ?');

		$stmt->execute([$_POST['pr_name']]);

		$res2 = $stmt->fetch(\PDO::FETCH_OBJ);

		$req = $pdo->prepare("SELECT * FROM users WHERE pseudo = ?");

		$req->execute([$_POST['pa_name']]);

		$row = $req->rowCount();

		if($row==0){
			$_SESSION['flash']['danger'] ="Le membre mentionné n'est pas enrgistré";

			header('Location: admin.php');

			exit();		
		}

		$req = $pdo->prepare("SELECT * FROM projects WHERE nom_projet = ?");

		$req->execute([$_POST['pr_name']]);

		$row = $req->rowCount();

		if($row==0){
			$_SESSION['flash']['danger'] ="Le projet mentionné n'existe pas";

			header('Location: admin.php');

			exit();		
		}

		$req = $pdo->prepare("SELECT * FROM participants WHERE id = ? AND id_projet = ?");

		$req->execute([$res1->id,$res2->id_projet]); 

		$row = $req->rowCount();

		if($row>0){		
			$_SESSION['flash']['error'] ="Ce membre intervient déjà sur ce projet";

			header('Location: admin.php');

			exit();		
		} else{
			$req = $pdo->prepare("INSERT INTO participants (id,id_projet) VALUES (?,?)");

			$req->execute([$res1->id,$res2->id_projet]);

			$_SESSION['flash']['success'] ="Intervenant ajouté avec succès";

			header('Location: admin.php');

			exit();
		}
	}
	$_SESSION['flash']['danger'] ="Informations incomplètes";

	header('Location: admin.php');

	exit();		
}

?>
<h1>Espace administration</h1>

<h2>Supprimer un membre</h2>

<form action ="" method="post">

	<div class="form-group">
		<input class="form-control" type="text" name="delete_user" placeholder="Pseudo du membre"/>
	</div>

	<button class="btn btn-primary">Supprimer le membre</button>

</form>

<h2>Ajouter un projet</h2>

<form action ="" method="post">

	<div class="form-group">
		<input class="form-control" type="text" name="name_project" placeholder="Nom du projet"/>
	</div>

	<div class="form-group">
		<input class="form-control" type="text" name="name_client" placeholder="Nom du client"/>
	</div>

	<div class="form-group">
		<input class="form-control" type="text" name="name_head" placeholder="Pseudo du chef de projet"/>
	</div>

	<div class="form-group">
		<input class="form-control" type="text" name="deadline" placeholder="Échéance du projet"/>
	</div>

	<button class="btn btn-primary">Ajouter le projet</button>

</form>

<h2>Ajouter un événement</h2>

<form action ="" method="post">

	<div class="form-group">
		<input class="form-control" type="text" name="name_event" placeholder="Nom de l'événement"/>
	</div>

	<div class="form-group">
		<input class="form-control" type="text" name="place_event" placeholder="Lieu de l'événement"/>
	</div>

	<div class="form-group">
		<input class="form-control" type="text" name="date_event" placeholder="Date de l'événement"/>
	</div>

	<div class="form-group">
		<input class="form-control" type="text" name="respo_event" placeholder="Nom du responsable"/>
	</div>

	<button class="btn btn-primary">Ajouter l'événement</button>

</form>

<h2>Ajouter un intervenant</h2>

<form action ="" method="post">

	<div class="form-group">
		<input class="form-control" type="text" name="pa_name" placeholder="Pseudo de l'intervenant"/>
	</div>

	<div class="form-group">
		<input class="form-control" type="text" name="pr_name" placeholder="Nom du projet"/>
	</div>

	<button class="btn btn-primary">Ajouter l'intervenant</button>

</form>

<?php require 'footer.php';?>


