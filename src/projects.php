<?php require 'header.php'?>
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
?>
<h1>Projets en cours</h1>

<form action="project.php" method="post">

	<div class="form-group">
		<input class="form-control" type="text" name="searching_project" placeholder="Nom du projet"/>
	</div>

	<button class="btn btn-primary">Rechercher</button>

</form>

<br>
<?php

$stmt = $pdo->prepare("SELECT  nom_projet, nom_client, echeance,nom_chef_de_projet, email FROM projects INNER JOIN users ON nom_chef_de_projet=pseudo ORDER BY echeance ASC");

$stmt->execute();

$row = $stmt->rowCount();

if( $row  != 0 ) {
	echo "<table style='border: solid 1px black;border-collapse: collapse;' id='event'>";
	
	echo "<tr style='background-color:#4CAF50;'><th>Projet</th><th>Client</th><th>Échéance</th><th>Chef de projet</th><th>Email</th></tr>";

	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    	foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        	echo $v;
    	}

	echo "</table>";
} else{
	echo "Aucun projet en cours";
}
?>

<?php require 'footer.php'?>
