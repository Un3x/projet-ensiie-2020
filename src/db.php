<?php

$servername = "localhost";

$username = "root";

$password = "";

try {
	$pdo = new PDO("mysql:host=$servername;dbname=DB", $username, $password);

	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    	echo "Connection failed: " . $e->getMessage();
}

$sql = "DELETE FROM events WHERE date_event < NOW()";

$pdo->exec($sql);

$sql = "DELETE FROM projects WHERE echeance < NOW()";

$pdo->exec($sql);
?> 
