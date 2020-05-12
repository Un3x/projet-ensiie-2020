<?php

use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$id_membre = $_POST['id_membre'] ?? null;
$id = $_POST['id'] ?? 0;
if ($id_membre) {
    $userRepository = new UserRepository($dbAdaper);
    $userRepository->delete($id_membre);
}

//header('Location: test.php');

include_once '../public/template.php';
if ($id_membre!=$id)
{
    header('Location: OtherUsrA.php');
}
else 
{
    header('Location: home.php');
}


?>
