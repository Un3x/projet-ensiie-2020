<?php
	session_start();

	$username = isset($_POST['name']) ? $_POST['name'] : "";
	$password = isset($_POST['pwd']) ? $_POST['pwd'] : "";
	$email = isset($_POST['email']) ? $_POST['email'] : "";
	$address = isset($_POST['address']) ? $_POST['address'] : "";
	$index = $_SESSION["user"];

	$conn = pg_connect("host=localhost port=5432 dbname=ProjetWeb user=postgres password=qwer1234");

	if(!empty($username)&&!empty($password)&&!empty($email)&&!empty($address)){
		$sql_name = "update member set name = '$username',pwd = '$password',email='$email',address= '$address' where name = '$index'";
		pg_query($conn,$sql_name);
		$sql_bateau = "update bateau set owner = '$username',email='$email',address='$address' where owner = '$index'";
		pg_query($conn, $sql_bateau);
		header("Location:login.php?status_login=4");
	}
	else {
		echo "<script>alert('ERREUR: les informations ne sont pas compl¨¦t¨¦es !');history.go(-1);</script>";
		header("Location:update.php");
	}

?>