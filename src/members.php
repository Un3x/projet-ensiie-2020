<?php require 'header.php'?>
<h1>Nos membres</h1>
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

$stmt = $pdo->prepare("SELECT pseudo, nom, prenom, email FROM users ORDER BY pseudo ");

$stmt->execute();

$row = $stmt->rowCount();

if( $row  != 0 ) {
	echo "<table style='border: solid 1px black;border-collapse: collapse;' id='event'>";

	echo "<tr style='background-color:#4CAF50;'><th>Pseudo</th><th>Nom</th><th>Prénom</th><th>Email</th></tr>";

    	$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    	foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        	echo $v;
    	}

	echo "</table>";
} else{
	echo "Aucun inscrit";
}
?>
<?php require 'footer.php'?>
