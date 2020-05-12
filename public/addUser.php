<?php

use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$users = $userRepository->fetchAll();

$pseudo= $_POST['pseudo'] ?? null;
$password= $_POST['password'] ?? null;
$id = $_POST['id'] ?? 0;

$unchosen_ps=true;
foreach ($users as $user)
{
    if($user->getPseudo()==$pseudo)
    {
       $unchosen_ps=false;
    }
}

if ($unchosen_ps)
{
    if ($pseudo&&$password)
    {
        $userRepository = new UserRepository($dbAdaper);
        $userRepository->insert($pseudo,$password);
    }
}
else 
{
    //afficher erreur
}


//header('Location: test.php');
//include_once '../public/template.php';
//loadView('test',$id);
header('Location: OtherUsrM.php');


?>
