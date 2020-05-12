<?php

namespace Controller;
require_once 'Controller.php';

class ProfilesController extends Controller
{
	public function get($params)
	{

        //Connection to the MainRepository
        $mainRepository = $this->getMainRepository();
        //Connection to the UserRepository
        $userRepository = $mainRepository->getUserRepository();
        
		$users = $userRepository->fetchAll();

		
		$viewPath = __VIEWROOT__.'/html';
		include $viewPath.'/profiles.php';
	}

	public function post($params){
		//Connection to the MainRepository
        $mainRepository = $this->getMainRepository();
        //Connection to the UserRepository
		$userRepository = $mainRepository->getUserRepository();

		$users = $userRepository->fetchAll();
		
		if(!empty($_POST['username_delete'])) {
			if($_SESSION["username"]==$_POST['username_delete']){
				$userRepository->delete($_POST['username_delete']);
				header("location: /logout");}
			else{
				$userRepository->delete($_POST['username_delete']);
				header("location: /profiles");
			}
		}
		else if (!empty($_POST['username_modify'])){
			if($_SESSION["username"]==$_POST['username_modify']){
				header("location: /profil");}
			else{
				$_SESSION["username_tmp"] = $_POST['username_modify'];
				header("location: /adminmodify");
			}
		}
		$viewPath = __VIEWROOT__.'/html';
		include $viewPath.'/profiles.php';
	}
}


?>
