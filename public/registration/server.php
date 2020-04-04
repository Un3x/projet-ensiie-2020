<?php
//sudo systemctl start postgresql
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost:8080', 'php', '', 'ensiie');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['mail']);
  $password_1 = mysqli_real_escape_string($db, $_POST['passwd']);
  $password_2 = mysqli_real_escape_string($db, $_POST['confpasswd']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Nom d'utilisateur nécessaire"); }
  if (empty($email)) { array_push($errors, "Email requis"); }
  if (empty($password_1)) { array_push($errors, "Mot de passe requis"); }
  if ($password_1 != $password_2) {
	array_push($errors, "Les deux mots de passe ne concordent pas");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM User WHERE userName='$username' OR mail='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['userName'] === $username) {
      array_push($errors, "Cet utilisateur existe déjà !");
    }

    if ($user['mail'] === $email) {
      array_push($errors, "Cet email est déjà utilisé !");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (userName, mail, pwd) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['userName'] = $username;
  	$_SESSION['success'] = "Vous êtes connectés !";
  	header('location: index.php');
  }
}


// LOGIN USER
if (isset($_POST['log_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['passwd']);
  
    if (empty($username)) {
        array_push($errors, "Nom d'utilisateur requis (sinon on peut pas savoir qui vous êtes !)");
    }
    if (empty($password)) {
        array_push($errors, "Mot de passe requis");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM User WHERE userName='$username' AND pwd='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['userName'] = $username;
          $_SESSION['success'] = "Vous êtes connecté !";
          header('location: index.php');
        }else {
            array_push($errors, "Le mot de passe ne correspond pas à l'utilisateur.");
        }
    }
  }
  
  ?>