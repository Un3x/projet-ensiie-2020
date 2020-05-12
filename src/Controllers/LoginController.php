<?php

namespace Controller;
require_once 'Controller.php';

session_start();

class LoginController extends Controller
{	
	public function get($params)
	{	
		// If User connected, redirect to home
		if((isset($_SESSION["loggedin"]) == true )&& ($_SESSION["loggedin"] == true )){
            header("location: /");
        }
		else{
			// Define variables and initialize with empty values
			$username = $password = "";
			$username_err = $password_err = "";

			$_SESSION["username"] = $username;
			$_SESSION["username_err"] = $username_err;
			$_SESSION["password_err"] = $password_err;

			$viewPath = __VIEWROOT__.'/html';
			
			include_once $viewPath.'/login.php';
        }	
	}

	// Processing form data when form is submitted
	public function post($params){
		// If User connected, redirect to home
		if((isset($_SESSION["loggedin"]) == true )&& ($_SESSION["loggedin"] == true )){
            header("location: /");
        }
		else {
			// Define variables and initialize with empty values
			$username = $password = "";
			$username_err = $password_err = "";
			
			// Check if username is empty
			if(empty(trim($_POST["username"]))){
				$username_err = "Veuillez entrer votre pseudo";
			} else{
				$username = trim($_POST["username"]);
			}
		
			// Check if password is empty
			if(empty(trim($_POST["password"]))){
				$password_err = "Veuillez entrer votre mot de passe";
			} else{
				$password = trim($_POST["password"]);
			}
			
			//Connection to the MainRepository
			$mainRepository = $this->getMainRepository();
			//Connection to the UserRepository
			$userRepository = $mainRepository->getUserRepository();

			// Validate credentials
			if(empty($username_err) && empty($password_err)){
				// Set parameters for bindParam 
				$param_username = trim($_POST["username"]);
				if($userRepository->Validate_login($param_username,$password) == 1){
					// Password is correct, so start a new session
					session_start();
									
					// Store data in session variables
					$_SESSION["loggedin"] = true;
					$_SESSION["username"] = $username;
					$_SESSION["admin"] = $userRepository->Check_Admin($username);

					$this->socket->prepareLoggingOnInfo();
					if (!$this->socket->sendData())
						$this->socket->printError();
					
					// Redirect user to welcome page
					header("location: /");
					exit;
				}
			
				
				else if($userRepository->Validate_login($param_username,$password) == 2){
					// Display an error message if password is not valid
					$password_err = "Le mot de passe que vous avez entré n'est pas valide";
					$_SESSION["username"] = $username;
					$_SESSION["username_err"] = $username_err;
					$_SESSION["password_err"] = $password_err;
				}
				else {
					// Display an error message if username doesn't exist
					$username_err = "Aucun compte existant ne correspond à ce pseudo";
					$_SESSION["username"] = $username;
					$_SESSION["username_err"] = $username_err;
					$_SESSION["password_err"] = $password_err;
				}
			}
		}
			
			//Formulaire
			$viewPath = __VIEWROOT__.'/html';
			include_once $viewPath.'/login.php';
		}
}

?>
