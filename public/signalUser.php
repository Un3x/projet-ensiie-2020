<?php

use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$id_membre = $_POST['id_membre'] ?? null;
$id = $_POST['id'] ?? 0;
$dcsn = $_POST['decision'] ?? null;


if ($id_membre&&$id!=0) {
    if ($id_membre!=$id)
    {
        if ($dcsn)
        {
            $userRepository = new UserRepository($dbAdaper);
            $userRepository->modif_etat($id_membre, $dcsn);
            //include_once '../public/template.php';
            //loadView('testadm',$id);
        }
    }
    else 
    {
        echo "Impossible de changer soi-même son statut";
    }
}

//header('Location: test.php');

//include_once '../public/template.php';
//loadView('testadm',$id);
header('Location: OtherUsrA.php');
?>
