<?php

namespace Controller;
require_once 'Controller.php';

class ModifyController extends Controller
{
	public function get($params)
	{
		//Connection to the MainRepository
        $mainRepository = $this->getMainRepository();
        //Connection to the UserRepository
        $userRepository = $mainRepository->getUserRepository();
		
		//Get current User
		$current_user = $userRepository->getByKey($_SESSION["username"]);

		// Define variables and initialize with empty values
		$username_err = $last_password_err = $confirm_password_err = "";

		$viewPath = __VIEWROOT__.'/html';
		include $viewPath.'/profilemodify.php';
	}

	public function post($params){
		
            // Define variables and initialize with empty values
            $new_username = $last_password = $new_password = $confirm_password = $new_email = "";
            $username_err = $last_password_err = $confirm_password_err = "";
    
            //Connection to the MainRepository
            $mainRepository = $this->getMainRepository();
            //Connection to the UserRepository
            $userRepository = $mainRepository->getUserRepository();
             
            //Get current User and its username
            $current_user = $userRepository->getByKey($_SESSION["username"]);
            $last_username = trim($current_user->getPseudo());
            // Set parameters
            $param_username = trim($_POST["username"]);
    
            if ($userRepository->Verify_username ($param_username) == true ||  
					($param_username == $_SESSION["username"])){
                $new_username = trim($_POST["username"]); 
            }
            else {
                $username_err = "Ce pseudo est déjà pris.";
            }
             
    
            $new_email = trim($_POST["email"]);

            //Check Last_password
            $param_password = trim($_POST["lastpassword"]);
            if($userRepository->Validate_login($last_username,$param_password) == 1){
                $last_password = trim($_POST["lastpassword"]);
            }
            else{
                $last_password_err = "Le mot de passe que vous avez entré n'est pas valide.";
            }

			$new_password = trim($_POST["newpassword"]);
            
            // Validate confirm password
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($new_password != $confirm_password)){
                $confirm_password_err = "Ce mot de passe ne correspond pas au premier entré.";
			}
			
            
            // Check input errors before inserting in database
            if(empty($username_err) && empty($last_password_err)
                && empty($confirm_password_err)){
                // Set parameters
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Creates a password hash
                $userRepository->Modify_Pseudo($last_username,$new_username);
                $userRepository->Modify_Email($last_username,$new_email);
                $userRepository->Modify_Password($last_username,$hashed_password);
                $_SESSION["username"] = $new_username;

                // Redirect to Profil page
                header("location: /profil");
    
            }
    
            // Include La page html (le formulaire)
            $viewPath = __VIEWROOT__.'/html';
            include_once $viewPath.'/profilemodify.php';
	}
}

?>
