<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="scripts.js"></script>
</head>
<body>
<!-- cette page permet à l'utilisateur de se connecter, il faudra peut être changer la maniere dont l'utilisateur se login-->
<?php
  $fullUrl= "http;//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  if (strpos($fullUrl,"signup=success")){
	echo '<p>Compte créé avec succés!</p></br>';
  }
?>
<p> Inserez vos identifiants: </p>
<form name= "formLoginUser" action="loginUser.php" onsubmit="return validationFormulaire();" method="post">
<label for="username"> Nom du compte :</label></br>
	<?php
	  if (isset($_GET['username'])){
		  $username=$_GET['username'];
		  echo '<input type="text" name="username" placeholder="username" value="'.$username.'"></br>';
	  }
	  else {
		  echo '<input type="text" name="username" placeholder="username"></br>';
  		  $fullUrl= "http;//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  		  if (strpos($fullUrl, "errs=noUsername")){
  			  echo "<p>ERROR, no username given</p></br>";
  	    	  }
  		  elseif (strpos($fullUrl, "login=userUnknown")){
  			  echo "<p>ERROR, username is unknown</p></br>";
  		  }	
	  }
	?>
<label for="email">votre adresse mail:</label></br>
	<?php
	  if (isset($_GET['email'])){
		  $email=$_GET['email'];
		  echo '<input type="text" name="email" placeholder="email adress" value="'.$email.'"></br>';
	  }
	  else {
  		  $fullUrl= "http;//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		  echo '<input type="text" name="email" placeholder="email adress"></br>';
  		  if (strpos($fullUrl, "errs=invalidEmail")){
  			  echo "<p>ERROR, invalid email adress</p></br>";
  		  }
  		  elseif (strpos($fullUrl, "login=emailUnknown")){
  			  echo "<p>ERROR, email is unknown</p></br>";
  		  }
	  }
	?>
<button type="submit">Se connecter</button>

<?php
  $fullUrl= "http;//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  if (strpos($fullUrl, "login=failed")){
  	echo "<p> email and username do not match! Try again </p>";
  }
?>
</body>
</html>

