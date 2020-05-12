<?php
use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$id_membre = $_POST['id_membre'] ?? null;
$id = $_POST['id'] ?? 0;
$nrole = $_POST['nrole'] ?? null;


if ($id_membre&&$id!=0) {
    if ($id_membre!=$id)
    {
        if ($nrole)
        {
            $userRepository = new UserRepository($dbAdaper);
            $userRepository->modif_role($id_membre, $nrole);
            //include_once '../public/template.php';
            //loadView('testadm',$id);
        }
        else {echo "erreur 1";}
    }
    else 
    {
        echo "Impossible de changer soi-même son role";
    }
}


//include_once '../public/template.php';
//loadView('testadm',$id);
header('Location: OtherUsrA.php');
?>
