<?php
session_start();
$token = md5(rand(0,99999999));
$_SESSION['post.token']=$token;
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="scripts.js"></script>
</head>
<body>
<!-- cette page permet de creer un compte 
envoie les informations à inc/addUser
-->

<!--creer un compte -->
<h1>Inserez vos identifiants:</h1>
<form name= "formAddUser" action="inc/addUser.php" onsubmit="return validationFormulaire();" method="POST">
<label for="username"> Nom de compte :</label></br>
	<?php
	  if (isset($_GET['username'])){
		  $username=$_GET['username'];
		  echo '<input type="text" name="username" placeholder="username" maxlength="20" value="'.$username.'"></br>';
	  }
	  else {
		  echo '<input type="text" name="username" placeholder="username" maxlength="20" ></br>';
  		  $fullUrl= "http;//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  		  if (strpos($fullUrl, "errs=noUsername")){
  			  echo "<p>ERROR, no username given</p></br>";
  	    	  }
  		  elseif (strpos($fullUrl, "errs=usedUsername")){
  			  echo "<p>ERROR, username already taken</p></br>";
  		  }	
	  }
	?>
<label for="email">votre adresse mail:</label></br>
	<?php
	  if (isset($_GET['email'])){
		  $email=$_GET['email'];
		  echo '<input type="text" name="email" placeholder="email adress" maxlength="50" value="'.$email.'"></br>';
	  }
	  else {
  		  $fullUrl= "http;//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		  echo '<input type="text" name="email" placeholder="email adress" maxlength="50" ></br>';
  		  if (strpos($fullUrl, "errs=invalidEmail")){
  			  echo "<p>ERROR, invalid email adress</p></br>";
  		  }
  		  elseif (strpos($fullUrl, "errs=usedEmail")){
  			  echo "<p>ERROR, email already taken</p></br>";
  		  }
	  }
	?>
<label for="password"> votre mot de passe: </label></br>
	<input type="password" name="password" placeholder="Enter password" minlength="8" ></br>
	<?php
  		  $fullUrl= "http;//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  		  if (strpos($fullUrl, "errs=noMatchPsw")){
  			  echo "<p>ERROR, passwords do not match</p></br>";
  		  }
  		  elseif (strpos($fullUrl, "errs=shortPsw")){
  			  echo "<p>ERROR, your password must be at least 8 characters long</p></br>";
  		  } 
	?>
 
<label for="checkPassword"> votre mot de passe: </label></br>
	<input type="password" name="checkPassword" placeholder="Enter password" minlength="8" ></br>
  
	

<input type="hidden" id="post.token" name="post.token" value="{$token}" /> 
<button type="submit">Creer un compte</button>
</br>
<a href="login.php">déjà inscrit? connecte toi!</a>

<?php
	 /*
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
	  */
?>
</body>
</html>
