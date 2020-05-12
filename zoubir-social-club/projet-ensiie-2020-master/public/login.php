<?php
session_start();
include_once '../src/utils/autoloader.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$dbfactory = new \Rediite\Model\Factory\DbAdapterFactory();
$dbAdapter = $dbfactory->createService();

$PersonneHydrator = new \Rediite\Model\Hydrator\PersonneHydrator();
$PersonneRepository = new \Rediite\Model\Repository\PersonneRepository($dbAdapter, $PersonneHydrator);


 /* problème en choisissant le menu */
 /*
if (null == $choixMenu)
{
	header('Location: index.php'); 
}
*/
$data=[];
	if (isset($_POST['email'])&& isset($_POST['mdp']))
	{
	    $mail = htmlspecialchars($_POST['email']);
	    $mdp = $_POST['mdp'];

	    $test = $PersonneRepository->checkConnexion($mail,$mdp);
	    if ($test == "good")
	    {
			include_once '../src/view/template.php';
	    	loadView('profile', $_SESSION);
	    }
		else
	    {
			$erreur="L'email et le mot de passe que vous avez entrés ne correspondent pas à ceux présents dans nos fichiers. Veuillez vérifier et réessayer.";
			$data=['erreur'=>$erreur];
			include_once '../src/view/template.php';
			loadView('login', $data);	
	    }
	}
	else
	{
		include_once '../src/view/template.php';
		loadView('login', $data);	
	}
	

?>

