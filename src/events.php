<?php require 'header.php';?>

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

if(!empty($_POST)){
	if(empty($_POST['participate'])){
		$_SESSION['flash']['danger']="Aucun nom d'événement saisi";

		header('Location:events.php');

		exit();
	}

	$stmt = $pdo->prepare('SELECT * FROM events WHERE nom_event = ?');

	$stmt->execute([$_POST['participate']]);

	$row = $stmt->rowCount();

	if( $row  == 0 ) {
		$_SESSION['flash']['danger'] = "Cet événement n'existe pas";

		header('Location: events.php');

		exit();	
	}

	$res = $stmt->fetch(\PDO::FETCH_OBJ);

	$stmt = $pdo->prepare('SELECT * FROM incomers WHERE id_event = ? AND id = ?');

	$stmt->execute([$res->id_event,$_SESSION['auth']['id']]);

	$row = $stmt->rowCount();

	if( $row  != 0 ) {
		$_SESSION['flash']['danger'] = "Vous participez déjà à cet événement";

		header('Location: events.php');

		exit();	
	}	

	$stmt = $pdo->prepare('INSERT INTO incomers(id,id_event) VALUES (?,?)');

	$stmt->execute([$_SESSION['auth']['id'],$res->id_event]);

	$_SESSION['flash']['success'] = "Participation enregistrée";

	header('Location: events.php');

	exit();		
}
?>

<h1>Événements à venir</h1>

<?php if(isset($_SESSION['auth'])): ?>

<form action="" method="post">

	<div class="form-group">
		<input class="form-control" type="text" name="participate" placeholder="Nom de l'événement"/>
	</div>

	<button class="btn btn-primary">Participer à l'événement</button>

</form>
<br>
<?php endif; ?>

<?php 

$stmt = $pdo->prepare("SELECT nom_event, lieu_event, date_event, pseudo ,email FROM events INNER JOIN users ON id=respo_event ORDER BY date_event");

$stmt->execute();

$row = $stmt->rowCount();

if( $row  != 0 ) {
	echo "<table style='border: solid 1px black;border-collapse: collapse;' id='event'>";

	echo "<tr style='background-color:#4CAF50;'><th>Nom</th><th>Lieu</th><th>Date</th><th>Responsable</th><th>Email</th></tr>";

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
