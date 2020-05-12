<?php

use Message\MessageRepository;
use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Message.php';
include '../src/MessageRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$messageRepository = new MessageRepository($dbAdaper);
//$users = $userRepository->fetchAll();

$pseudo= $_POST['dest'] ?? null;
$message= $_POST['msg'] ?? null;
$id = $_POST['id'] ?? 0;
$sendA = $_POST['sendAll'] ?? null;

if($sendA){
    if ($message&&$id!=0){
        $messageRepository->insert($message,$id,$id);
    }
}
else{
    if ($id!=0){
        $user=$userRepository->select($id);
    }

    $dest=$userRepository->select_ps($pseudo);
    if ($dest&&$message&&$id!=0){
        $idDest=$dest->getId();
        if ($idDest!=$id){
            $messageRepository->insert($message,$id,$idDest);        
        }
        else{
            //echo "On ne peut pas s'envoyer des messages à soi-même.";        
        }
    }
}
/*
if($user->getRole()=="Membre")
{
    header('Location: msgUser.php');
}
if($user->getRole()=="Administrateur")
{
    header('Location: msgUserA.php');
}
*/
header('Location: msgUser.php');
?>
