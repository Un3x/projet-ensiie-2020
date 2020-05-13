<?php
function logged_only(){
	if(session_status() == PHP_SESSION_NONE){
		session_start();
	}

	if(!isset($_SESSION['auth'])){
		header('Location: login.php');

		$_SESSION['flash']['danger'] = "Vous n'êtes pas connecté";

		exit();
	}
}
?>
