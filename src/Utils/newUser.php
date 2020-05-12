<?php

include '../Model/Entity/User.php';
include '../Model/Repository/UserRepository.php';
include '../Model/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);

if (!(empty ($_POST["username"])) AND !(empty ($_POST["email"])) AND !(empty ($_POST["password"]))) {

    $username = $_POST["username"];
	$email = $_POST["email"];
	$password = $_POST["password"];

    $nbUser = $userRepository->checkIfUserExists($username);
    
    if($nbUser == 0) {  // on vérifie qu'il n'y ai pas déjà un utilisateur avec ce login 
        $userRepository->insert($username,$email,$password);
        header('Location: ../View/connection.html');
    }
    else {
        header('Location: ../View/inscription.html');
    }
}
else {
    echo "Erreur ! Veuillez remplir tous les champs !";
}

?>