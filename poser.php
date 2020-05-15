<?php
	
	$object = isset($_POST['gender']) ? $_POST['gender'] : "";
	$description = isset($_POST['description']) ? $_POST['description'] : "";
	$owner = isset($_POST['owner']) ? $_POST['owner'] : "";
	$email = isset($_POST['email']) ? $_POST['email'] : "";
	$address = isset($_POST['address']) ? $_POST['address'] : "";
	$date = date("d-m-y");

	$conn = pg_connect("host=localhost port=5432 dbname=ProjetWeb user=postgres password=qwer1234");
	$sql = "insert into bateau (objet,description,owner,email,address,date) values('$object','$description','$owner','$email','$address','$date')";
	$ret = pg_query($conn, $sql);
	if($ret){
		
		header("Location:add.php?status_add=1");
	}
	else{
		header("Location:add.php?status_add=2");
	}
	pg_close($conn);
?>