<?php
	// Connect to database
	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getplayer($nom,$prenom,$att,$def,$tech)
	{
		global $bdd;

		$query = "SELECT * FROM joueurs";

		if($nom==null){
			$query.=" WHERE nom like '%'" ;
		}
		else{
			$query.=" WHERE nom='".$nom."'";
		}
		if($prenom==null){
			$query.=" AND prenom like '%'" ;
		}
		else{
			$query.=" AND prenom='".$prenom."'";
		}

		if($att=="att_tout"){
			$query.=" AND attaque >= 0";
		}
		else if($att=="att_inf10"){
			$query.="AND attaque <= 10";
		}
		else if($att=="att_entre_10_15"){
			$query.="AND attaque <= 15 AND attaque >= 10";
		}
		else if($att=="att_sup15"){
			$query.=" AND attaque >= 15";
		}

		if($def=="def_tout"){
			$query.=" AND defense >= 0";
		}
		else if($def=="def_inf10"){
			$query.=" AND defense <= 10";
		}
		else if($def=="def_entre_10_15"){
			$query.=" AND defense <= 15 AND defense >= 10";
		}
		else if($def=="def_sup15"){
			$query.=" AND defense >= 15";
		}

		if($tech=="tech_tout"){
			$query.=" AND technique >= 0";
		}
		else if($tech=="tech_inf10"){
			$query.=" AND technique <= 10";
		}
		else if($tech=="tech_entre_10_15"){
			$query.=" AND technique <= 15 AND technique >= 10";
		}
		else if($tech=="tech_sup15"){
			$query.=" AND technique >= 15";
		}


		$response = array();
		$result = $bdd->query($query);
		while($row = $result->fetch())
		{
			$response[] = $row;
		}
		return $response;
	}
	
	
	?>