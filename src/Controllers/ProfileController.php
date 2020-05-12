<?php

namespace Controller;
require_once 'Controller.php';

class ProfileController extends Controller
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
		$username_err = "";

		$viewPath = __VIEWROOT__.'/html';
		include $viewPath.'/profile.php';
	}

	public function post($params){
        
        //Connection to the MainRepository
        $mainRepository = $this->getMainRepository();
        //Connection to the UserRepository
        $userRepository = $mainRepository->getUserRepository();

        if(!empty($_POST['delete'])) {
			if (!$this->socket->prepareLoggingOffInfo()->sendData())
				$this->socket->printError();
			
            $userRepository->delete($_SESSION["username"]);
			header("location: /logout");
        }
        else{     
            // Define variables and initialize with empty values
            $new_username = $new_email = "";
            $username_err = "";
    
            //Connection to the MainRepository
            $mainRepository = $this->getMainRepository();
            //Connection to the UserRepository
            $userRepository = $mainRepository->getUserRepository();
			 
			//Get current User
			$current_user = $userRepository->getByKey($_SESSION["username"]);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
    
            //Check if the user isn't already taken
			if ($userRepository->Verify_username ($param_username) == true ||  
					($param_username == $_SESSION["username"])){
                $new_username = trim($_POST["username"]); 
            }
            else {
                $username_err = "Ce pseudo est déjà pris.";
            }
             
            $new_email = trim($_POST["email"]);
            
            // Check input errors before modifying database
            if(empty($username_err)){
                // Set parameters
				$userRepository->Modify_Pseudo ($current_user->getPseudo(),$new_username);
				$userRepository->Modify_Email ($current_user->getPseudo(),$new_email);
				
				if (!$this->socket->prepareLoggingOffInfo()->sendData())
					$this->socket->printError();
				
                $_SESSION["username"] = $new_username;
                
				if (!$this->socket->prepareLoggingOnInfo()->sendData())
					$this->socket->printError();
                
                // Redirect to profil page
                header("location: /profil");
    
            }
    
            // Include La page html (le formulaire)
            $viewPath = __VIEWROOT__.'/html';
            include_once $viewPath.'/profile.php';
        }
	}
}

?>
