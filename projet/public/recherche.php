<?php
	
	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	header('Content-type: text/plain');

	$titre = $_GET['titre'];

	$requete = $dbAdapter->prepare('SELECT titre FROM Oeuvre WHERE UPPER(titre) LIKE UPPER(:titre) LIMIT 10');
	$requete->execute(array('titre' => $titre.'%'));

	$array = array();

	while($donnee = $requete->fetch())
	{
		array_push($array, $donnee['titre']);
	}
	
	for ($i = 0; $i < count($array); $i++) {
    	echo nl2br($array[$i]."\n");
	}

?>