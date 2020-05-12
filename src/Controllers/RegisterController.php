<?php

namespace Controller;
require_once 'Controller.php';

class RegisterController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		//session_start();
	}
	
	public function get($params)
	{   
        // If User connected, redirect to home
		if((isset($_SESSION["loggedin"]) == true )&& ($_SESSION["loggedin"] == true )){
            header("location: /");
        }
        else{
            // Define variables and initialize with empty values
            $username_err = $confirm_password_err = "";

            $_SESSION["username_err"] = $username_err;
            $_SESSION["confirm_password_err"] = $confirm_password_err;

            $viewPath = __VIEWROOT__.'/html';
            
            include_once $viewPath.'/register.php';
        }
	}
    
    // Processing form data when form is submitted
	public function post($params){
        
        // If User connected, redirect to home
		if((isset($_SESSION["loggedin"]) == true )&& ($_SESSION["loggedin"] == true )){
            header("location: /");
        }
        else{ 
            // Define variables and initialize with empty values
            $username = $password = $confirm_password = $email = "";
            $username_err = $confirm_password_err = "";
    
            //Connection to the MainRepository
            $mainRepository = $this->getMainRepository();
            //Connection to the UserRepository
            $userRepository = $mainRepository->getUserRepository();
             
            
            // Set parameters
            $param_username = trim($_POST["username"]);
    
            if ($userRepository->Verify_username ($param_username) == true){
                $username = trim($_POST["username"]); 
                $_SESSION["username_err"] = $username_err;
            }
            else {
                $username_err = "Ce pseudo est déjà pris";
                $_SESSION["username_err"] = $username_err;
                $_SESSION["confirm_password_err"] = $confirm_password_err;
            }
             
    
            $email = trim($_POST["email"]);
    
    
            // Validate password
            /*if(empty(trim($_POST["password"]))){
                $password_err = "Please enter a password.";  
            } */
            /*
            Option pour vérifier que le passeword dépasse 6 caractères
            elseif(strlen(trim($_POST["password"])) < 6){
                $password_err = "Password must have atleast 6 characters.";
            }*/ 
            //else{
                $password = trim($_POST["password"]);
            //}
            
            // Validate confirm password
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Ce mot de passe ne correspond pas au premier entré";
                $_SESSION["confirm_password_err"] = $confirm_password_err;
            }
            
            // Check input errors before inserting in database
            if(empty($username_err) && empty($confirm_password_err)){
                // Set parameters
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $userRepository->Register ($username,$param_password,$email);
                
                header("location: /login");
    
            }
    
            // Include La page html (le formulaire)
            $viewPath = __VIEWROOT__.'/html';
            include_once $viewPath.'/register.php';
        }
       
    }
}

?>
