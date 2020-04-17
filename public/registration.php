<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="scripts.js"></script>
</head>
<body>
<!-- cette page permet de creer un compte -->

<!--creer un compte -->
<h1>Inserez vos identifiants:</h1>
<form name= "formAddUser" action="addUser.php" onsubmit="return validationFormulaire();" method="post">
<label for="username"> Nom de compte :</label></br>
	<?php
	  if (isset($_GET['username'])){
		  $username=$_GET['username'];
		  echo '<input type="text" name="username" placeholder="username" value="'.$username.'"></br>';
	  }
	  else {
		  echo '<input type="text" name="username" placeholder="username"></br>';
	  }
	?>
<label for="email">votre adresse mail:</label></br>
	<?php
	  if (isset($_GET['email'])){
		  $email=$_GET['email'];
		  echo '<input type="text" name="email" placeholder="email adress" value="'.$email.'"></br>';
	  }
	  else {
		  echo '<input type="text" name="email" placeholder="email adress"></br>';
	  }
	?>
<button type="submit">Creer un compte</button>

<?php
  $fullUrl= "http;//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  if (strpos($fullUrl, "errs=noUsername")){
  	echo "<p>ERROR, no username given</p></br>";
  }
  elseif (strpos($fullUrl, "errs=usedUsername")){
  	echo "<p>ERROR, username already taken</p></br>";
  }
  elseif (strpos($fullUrl, "errs=invalidEmail")){
  	echo "<p>ERROR, invalid email adress</p></br>";
  }
  elseif (strpos($fullUrl, "errs=usedEmail")){
  	echo "<p>ERROR, email already taken</p></br>";
  }
  
?>
</body>
</html>
