<?php

use User\UserRepository;
use Rating\RatingRepository;
use Comment\CommentRepository;
use Save\SaveRepository;

include '../src/Entity/User.php';
include '../src/Repository/UserRepository.php';
include '../src/Repository/CommentRepository.php';
include '../src/Repository/RatingRepository.php';
include '../src/Repository/SaveRepository.php';
include '../src/Factory/DbAdaperFactory.php';

session_start();

$dbAdaperUser = (new DbAdaperFactory())->createService();
$dbAdaperRate = (new DbAdaperFactory())->createService();
$dbAdaperCom = (new DbAdaperFactory())->createService();
$dbAdaperSave = (new DbAdaperFactory())->createService();


$userId = $_POST['user_id'];

$urep = new UserRepository($dbAdaperUser);
$urat = new RatingRepository($dbAdaperRate);
$ucom = new CommentRepository($dbAdaperCom);
$usav = new SaveRepository($dbAdaperSave);


$ucom->delete_comments($userId);
$urat->delete_ratings($userId);
$usav->deleteAllSave($userId);
$urep->delete_user($userId);

if (isset($_POST['delete_account']))
{

    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['admin']);
    $_SESSION['success'] = "Compte supprimé avec succès";

    header('Location: index.php');
}
if (isset($_POST['del_as_admin']))
{
    $_SESSION['success'] = "Utilisateur supprimé avec succès";
    header('Location: admin_page.php');
}

?>
