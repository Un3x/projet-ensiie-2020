<?php

use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);

$id_membre = $_POST['id_membre'] ?? null;
$id = $_POST['id'] ?? 0;
if ($id_membre&&$id!=0) {
    if ($id_membre!=$id)
    {
        $userRepository->modif_etat($id_membre, "accuse");
        //include_once '../public/template.php';
        //loadView('test',$id);
    }
    else 
    {
        echo "Est-tu sûr de vouloir te signaler toi-même ?";
    }
}

//header('Location: test.php');

//include_once '../public/template.php';
//loadView('test',$id);
header('Location: OtherUsrM.php');
?>
