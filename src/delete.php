<?php
	$bid = $_GET["bid"];

	$conn = pg_connect("host=localhost port=5432 dbname=ProjetWeb user=postgres password=qwer1234"); 
	$sql = "delete from bateau where bid='$bid'";
	$ret=pg_query($conn, $sql);
	if($ret){
		header("Location:user.php?status_user=1");
	}
?>