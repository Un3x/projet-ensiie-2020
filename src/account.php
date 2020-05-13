<?php

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width:250px;border:1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
    }
}


require_once'functions.php';

logged_only();

require 'header.php';


if(!empty($_POST)){	
	if(empty($_POST['mot_de_passe']) || $_POST['mot_de_passe'] != $_POST['mot_de_passe_confirme']){

		$_SESSION['flash']['danger'] = "Les mots de passe ne sont pas identiques";

		header('Location: account.php');

		exit();	
	} else{
		$user_id=$_SESSION['auth']['id'];

		echo $_POST['mot_de_passe'];

		$pwd = password_hash($_POST['mot_de_passe'],PASSWORD_BCRYPT);

		$req=$pdo->prepare('UPDATE users SET mot_de_passe = ? WHERE id = ?');

		$req->execute([$pwd, "$user_id"]);

		$_SESSION['flash']['success'] = "Votre mot de passe a été mis à jour";

		header('Location: account.php');

		exit();
	}
}
?>


<h1>Mon compte</h1>

<h2>Mes informations</h2>

<ul id="acc_info">

	<li >Identifiant: <?php echo $_SESSION['auth']['id'];?></li>

	<li>Pseudo: <?php echo $_SESSION['auth']['pseudo'];?></li>

	<li>Nom: <?php echo $_SESSION['auth']['nom'];?></li>

	<li>Prénom: <?php echo $_SESSION['auth']['prenom'];?></li>

	<li>Email: <?php echo $_SESSION['auth']['email'];?></li>

	<li>Téléphone: <?php echo $_SESSION['auth']['telephone'];?></li>

	<li>Date d'inscription: <?php echo $_SESSION['auth']['date_inscription'];?></li>

	<li>Admin: <?php echo $_SESSION['auth']['admin'];?></li>

</ul>

<form action ="" method="post">

	<div class="form-group">
		<input class="form-control" type="password" name="mot_de_passe" placeholder="Changer de mot de passe"/>
	</div>

	<div class="form-group">
		<input class="form-control" type="password" name="mot_de_passe_confirme" placeholder="Confirmation du mot de passe"/>
	</div>

	<button class="btn btn-primary">Changer mon mot de passe</button>

</form>

<h2>Mes projets</h2>

<h4>En tant que chef de projet</h4>

<?php 

$stmt = $pdo->prepare("SELECT nom_projet, nom_client, echeance FROM projects WHERE nom_chef_de_projet = ? ORDER BY echeance");

$stmt->execute([$_SESSION['auth']['pseudo']]);

$row = $stmt->rowCount();

if( $row  != 0 ) {
	echo "<table style='border: solid 1px black;border-collapse: collapse;' id='event'>";

	echo "<tr style='background-color:#4CAF50;'><th>Projet</th><th>Client</th><th>Échéance</th></tr>";

	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	
	foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        	echo $v;
	}

	echo "</table>";
} else {
	echo "Aucun projet en cours";
}
?>

<h4>En tant qu'intervenant</h4>

<?php 

$stmt = $pdo->prepare("SELECT nom_projet, nom_client, echeance FROM projects as pr JOIN participants as pa ON pa.id_projet = pr.id_projet  WHERE pa.id = ? ORDER BY echeance");

$stmt->execute([$_SESSION['auth']['id']]);

$row = $stmt->rowCount();

if( $row  != 0 ) {
	echo "<table style='border: solid 1px black;border-collapse: collapse;' id='event'>";

	echo "<tr style='background-color:#4CAF50;'><th>Projet</th><th>Client</th><th>Échéance</th></tr>";
	
	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
	
	foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
		echo $v;
	}

	echo "</table>";
} else{
	echo "Aucun projet en cours";
}
?>

<h2>Mes événements</h2>

<h4>En tant que responsable</h4>

<?php 

$stmt = $pdo->prepare("SELECT nom_event, lieu_event, date_event FROM events WHERE respo_event = ? ORDER BY respo_event");

$stmt->execute([$_SESSION['auth']['id']]);

$row = $stmt->rowCount();

if( $row  != 0 ) {
	echo "<table style='border: solid 1px black;border-collapse: collapse;' id='event'>";

	echo "<tr style='background-color:#4CAF50;'><th>Nom</th><th>Lieu</th><th>Date</th></tr>";

	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

	foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
	        echo $v;
   	}
	
	echo "</table>";
} else{
	echo "Aucun événement à venir";
}
?>

<h4>En tant que participant</h4>

<?php 

$stmt = $pdo->prepare("SELECT nom_event, lieu_event, date_event FROM (events as eve JOIN incomers as inc ON inc.id_event = eve.id_event) WHERE inc.id = ? ORDER BY date_event");

$stmt->execute([$_SESSION['auth']['id']]);

$row = $stmt->rowCount();

if( $row  != 0 ) {
	echo "<table style='border: solid 1px black;border-collapse: collapse;' id='event'>";

	echo "<tr style='background-color:#4CAF50;'><th>Nom</th><th>Lieu</th><th>Date</th></tr>";

    	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

   	foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        	echo $v;
    	}

	echo "</table>";
} else{
	echo "Aucun événement à venir";
}

?>

<?php require 'footer.php'?>
