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

$id = $_SESSION["id"];
$var1 = htmlspecialchars($_POST["relation_rechercher"]);
$var2 = htmlspecialchars($_POST["situation_amoureuse"]);
$var3 = htmlspecialchars($_POST["osexe"]);

if (!empty(htmlspecialchars($_POST["situation_amoureuse"])) || !empty(htmlspecialchars($_POST["relation_rechercher"])) || !empty(htmlspecialchars($_POST["osexe"]))) {

	$req = pg_query ($bdd, 'SELECT id FROM relation WHERE id = \''.$id.'\'');
	$data = pg_fetch_row($req);
	if ($data == $id) {
		pg_query($bdd, 
			"UPDATE relation SET
			relation_recherchée = $var1,
			situation_actuelle = $var2, 
			attirance_sexuelle = $var3
			WHERE id = $id ");
	}
	else {
		pg_query($bdd, 
			'INSERT INTO relation(id, relation_recherchée, situation_actuelle, attirance_sexuelle)
			VALUES (\''.$id.'\'
					, \''.htmlspecialchars($_POST["relation_rechercher"]).'\'
					, \''.htmlspecialchars($_POST["situation_amoureuse"]).'\'
					,\''.htmlspecialchars($_POST["osexe"]).'\')');
	}
	echo "<script type = 'text/javascript'> alert('Enregistrement réussi');
                                                    document.location.href = '../Profil.php';</script>";
}
echo "<script type = 'text/javascript'> alert('Les données fournies n'étaient pas concluantes, réessayez);
                                                    document.location.href = '../Profil.php';</script>";





?>
