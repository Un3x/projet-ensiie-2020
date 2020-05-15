<?php
	$username = isset($_POST['name']) ? $_POST['name'] : "";
	$password = isset($_POST['pwd']) ? $_POST['pwd'] : "";
	$confirm = isset($_POST['repwd']) ? $_POST['repwd'] : "";
	$email = isset($_POST['email']) ? $_POST['email'] : "";
	$address = isset($_POST['address']) ? $_POST['address'] : "";


	if (!empty($username)&&!empty($password)&&!empty($confirm))
	{
	if ($password == $confirm) {
		$conn = pg_connect("host=localhost port=5432 dbname=ProjetWeb user=postgres password=qwer1234");
		$sql = "select name from member where name = '$username'";
		$result = pg_query($sql);
		$num = pg_num_rows($result);
		if ($num) {
			echo "<script>alert('Le surnom déja existe!');history.go(-1);</script>";
		}
		else {
		$sql_id = "select name from member";
		$result_id = pg_query($sql_id);
		$num_id = pg_num_rows($result_id)+1;
			$sql_insert = "insert into member (id,name,pwd,email,address) values('$num_id','$username','$password','$email','$address')";
			$ret_insert = pg_query($conn,$sql_insert);
			echo "<script>alert('Votre compte a été bien créé!')</script>";
			header("Location:login.php?status_login=3");
			pg_close($conn);
		}
	}
	else {
		echo "<script>alert('Vos mots de passes ne correspondent pas !');history.go(-1);</script>";
	}
	

}
else {
	echo "<script>alert('Complétez les information obligatoires!');history.go(-1);</script>";
}

?>