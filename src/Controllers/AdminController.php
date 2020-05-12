<?php

namespace Controller;
require_once 'Controller.php';

class AdminController extends Controller
{
	public function get($params)
	{   
		//Connection to the MainRepository
        $mainRepository = $this->getMainRepository();
        //Connection to the UserRepository
        $userRepository = $mainRepository->getUserRepository();
		
		//Get current User
		$current_user = $userRepository->getByKey($_SESSION["username_tmp"]);

		// Define variables and initialize with empty values
		$username_err = $confirm_password_err = "";

        $viewPath = __VIEWROOT__.'/html';
		include $viewPath.'/adminmodify.php';
	}

	public function post($params){
		
            // Define variables and initialize with empty values
            $new_username = $new_password = $confirm_password = $new_email = $admin = "";
            $username_err = $confirm_password_err = "";
    
            //Connection to the MainRepository
            $mainRepository = $this->getMainRepository();
            //Connection to the UserRepository
            $userRepository = $mainRepository->getUserRepository();
             
            //Get current User and its username
            $current_user = $userRepository->getByKey($_SESSION["username_tmp"]);
            $last_username = trim($current_user->getPseudo());
            // Set parameters
            $param_username = trim($_POST["username"]);
    
            if ($userRepository->Verify_username ($param_username) == true ||  
					($param_username == $last_username)){
                $new_username = trim($_POST["username"]); 
            }
            else {
                $username_err = "Ce pseudo est déjà pris";
            }
             
    
            $new_email = trim($_POST["email"]);

            //Admin
            if($_POST["admin"]=="Oui"){
                $admin=true;
            }
            else if ($_POST["admin"]=="Non"){
                $admin=false; 
            }


			$new_password = trim($_POST["newpassword"]);
            
            // Validate confirm password
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($new_password != $confirm_password)){
                $confirm_password_err = "Ce mot de passe ne correspond au premier entré";
			}
			
            
            // Check input errors before inserting in database
            if(empty($username_err) && empty($confirm_password_err)){
                // Set parameters
                // Creates a password hash
                $userRepository->Modify_Pseudo($last_username,$new_username);
                $userRepository->Modify_Email($last_username,$new_email);
                $userRepository->Modify_Admin($last_username,$admin);
                if (!(empty($new_password)) && !(empty($confirm_password))){
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $userRepository->Modify_Password($last_username,$hashed_password);
                }   
                unset($_SESSION["username_tmp"]);
                // Redirect to Profil page
                header("location: /profiles");
    
            }
    
            // Include La page html (le formulaire)
            $viewPath = __VIEWROOT__.'/html';
            include_once $viewPath.'/adminmodify.php';
	}
}

?>
