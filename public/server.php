<?php
//sudo systemctl start postgresql

use User\UserRepository;

include '../src/Entity/User.php';
include '../src/Repository/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array();

// connect to the database (attention, db est un dbAdapter)
$db = (new DbAdaperFactory())->createService();
$urep = new UserRepository($db);


// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = htmlspecialchars($_POST['username']);
  $email = htmlspecialchars($_POST['email']);
  $password_1 = htmlspecialchars($_POST['passwd']);
  $password_2 = htmlspecialchars($_POST['confpasswd']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Nom d'utilisateur nécessaire"); } //
  if (empty($email)) { array_push($errors, "Email requis"); }                    //plus nécessaires grâce aux required dans le formulaire
  if (empty($password_1)) { array_push($errors, "Mot de passe requis"); }        //
  if ($password_1 != $password_2) {
  array_push($errors, "Les deux mots de passe ne concordent pas");
  $_SESSION['errors'] = "Les deux mots de passe ne concordent pas.";
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  
  if ($urep->alreadyUser($username, $email)){
    array_push($errors, "Ce nom d'utilisateur ou cette adresse mail est déjà utilisé.e");
    $_SESSION['errors'] = "Ce nom d'utilisateur ou cette adresse mail est déjà utilisé.e.";
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$urep->addUser($username, $email, $password_1);
    $_SESSION['id'] = $urep->get_UserID($username);
    $_SESSION['username'] = $username;
  	$_SESSION['success'] = "Compte créé avec succès !";
  	header('location: index.php');
  }
  header('Location: register.php');
}

// LOGIN USER
if (isset($_POST['log_user'])) {
    $username = $_POST['username'];
    $password = $_POST['passwd'];
  
    if (empty($username)) {
        array_push($errors, "Nom d'utilisateur requis (sinon on ne peut pas savoir qui vous êtes !)");
    }
    if (empty($password)) {
        array_push($errors, "Mot de passe requis");
    }
  
    if (count($errors) == 0) {
        $result = $urep->fetchUserConnection($username, $password);
        $nbRow = $result->rowCount();
        if ($nbRow == 1) {
          $_SESSION['id'] = intval($urep->get_UserID($username));
          $_SESSION['username'] = $username;
          if ($urep->isAdmin($username)){
            $_SESSION['admin'] = true;
          }
          $_SESSION['success'] = "Vous êtes connecté !";
          header('location: index.php');
        }else {
            array_push($errors, "Le mot de passe ne correspond pas à l'utilisateur.");
            $_SESSION['errors'] = "Le mot de passe et le nom d'utilisateur ne correspondent pas.";
            header('Location: login.php');
        }
    }
  }


//DISCONNECT
if (isset($_POST['disconnect'])){
  unset($_SESSION['id']);
  unset($_SESSION['username']);
  unset($_SESSION['admin']);
  $_SESSION['success'] = "Déconnexion réussie";
  header('location: index.php');
}

//CHANGE USERNAME
if (isset($_POST['change_username'])){
    $username = $_SESSION['username'];
    $password = $_POST['pwd'];
    $newname = $_POST['new_name'];

    if (empty($username)) {
        array_push($errors, "Nom d'utilisateur requis (sinon on ne peut pas savoir qui vous êtes !)");
    }
    if (empty($password)) {
        array_push($errors, "Mot de passe requis");
    }

    if ($urep->nameAlreadyUsed($newname)){
      array_push($errors, "Ce nom d'utilisateur est déjà utilisé");
    }
  
    if (count($errors) == 0) {
      $result = $urep->fetchUserConnection($username, $password);
        $nbRow = $result->rowCount();
        if ($nbRow == 1) {
          $urep->changeUsername($username, $newname);
          $_SESSION['username'] = $newname;
          $_SESSION['success'] = "Nom d'utilisateur changé avec succès";
          header('Location: user_page.php');
        }else {
          array_push($errors, "Le mot de passe ne correspond pas à l'utilisateur.");
          $_SESSION['errors'] = "Le mot de passe et le nom d'utilisateur ne correspondent pas.";
          header('Location: user_page.php');
        }
      }
}

//CHANGE PASSWORD
if (isset($_POST['change_pwd'])){
  $username = $_SESSION['username'];
  $old = $_POST['old'];
  $new = $_POST['new'];
  $conf = $_POST['conf'];

    if (empty($username)) {
      array_push($errors, "Nom d'utilisateur requis (sinon on ne peut pas savoir qui vous êtes !)");
    }
    if (empty($old)) {
      array_push($errors, "Mot de passe requis");
    }

    if ($new != $conf){
      array_push($errors, "Le mot de passe et sa confirmation ne sont pas identiques.");
    }

    if (count($errors) == 0) {
      $result = $urep->fetchUserConnection($username, $old); //vérification que l'ancien mot de passe est bon.
        $nbRow = $result->rowCount();
        if ($nbRow == 1) {
          $urep->changePassword($username, $new);
          $_SESSION['success'] = "Mot de passe changé avec succès";
          header('Location: user_page.php');
        }
        else {
          array_push($errors, "Le mot de passe ne correspond pas à l'utilisateur.");
          $_SESSION['errors'] = "Le mot de passe et le nom d'utilisateur ne correspondent pas.";
          header('Location: user_page.php');
        }
      }
      include 'errors.php';
}


  ?>
