<?php


session_start();

try {
/*$conn_string = "host=localhost port=5432 dbname=ipw user=cao_caroline password=123";*/
$conn_string = "host=localhost port=5432 dbname=projet_web user=lauriane password=lauriane";
$bdd = pg_connect($conn_string);
}

catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

if ($_POST["categorie"] == 'demande'){
	$query = 'INSERT INTO demande_ami(id1, id2, statut) 
		VALUES ( \''.htmlspecialchars($_POST["id1"]).'\',
		\''.htmlspecialchars($_POST["id2"]).'\', 
		\''.htmlspecialchars($_POST["statut"]).'\')';  /*requete*/

	$data = pg_query($bdd, $query); /*execution requete*/

	if ($data == false) {
		print_r(pg_last_error());	
	}
	echo "<script type = 'text/javascript'> alert('Demande effectuée !');
                                                    document.location.href = '../4_Page_2.php';</script>";

}

if ($_POST["categorie"] == 'accepter'){
	$query ='INSERT INTO amis(id1, id2, annee_connaissance) 
			VALUES  ( \''.htmlspecialchars($_POST["id1"]).'\',
		\''.htmlspecialchars($_POST["id2"]).'\', 
		\''.htmlspecialchars($_POST["annee"]).'\')';

	$data = pg_query($bdd, $query);

	if ($data == false) {
		print_r(pg_last_error());	
	}

	$query1 = 'INSERT INTO amis(id1, id2, annee_connaissance) 
			VALUES  ( \''.htmlspecialchars($_POST["id2"]).'\',
		\''.htmlspecialchars($_POST["id1"]).'\', 
		\''.htmlspecialchars($_POST["annee"]).'\')';

	$data1 = pg_query($bdd, $query1);
	if ($data1 == false) {
		print_r(pg_last_error());	
	}

	$query2 = 'DELETE FROM demande_ami WHERE 
			id1 = \''.htmlspecialchars($_POST["id1"]).'\' 
			AND
			id2 = \''.htmlspecialchars($_POST["id2"]).'\'
			';
	$data2 = pg_query($bdd, $query2);

	if ($data2 == false) {
		print_r(pg_last_error());	
	}

	echo "<script type = 'text/javascript'> alert('Demande acceptée !');
                                                    document.location.href = '../Profil.php';</script>";

}

if ($_POST["categorie"] == 'refuser'){
	$data = pg_query($bdd, 
			'UPDATE demande_ami SET 
			statut = \''.htmlspecialchars($_POST["statut"]).'\'
			WHERE id1 = \''.htmlspecialchars($_POST["id1"]).'\' 
			AND
			id2 = \''.htmlspecialchars($_POST["id2"]).'\'
			');

	if ($data == false) {
		print_r(pg_last_error());	
	}
	echo "<script type = 'text/javascript'> alert('Demande refusée');
                                                    document.location.href = '../Profil.php';</script>";
}

?>