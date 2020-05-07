<?php

use User\UserRepository;
use Rating\RatingRepository;
use Comment\CommentRepository;

include '../src/User.php';
include '../src/Repository/UserRepository.php';
include '../src/Repository/CommentRepository.php';
include '../src/Repository/RatingRepository.php';
include '../src/Factory/DbAdaperFactory.php';

session_start();

$dbAdaperUser = (new DbAdaperFactory())->createService();
$dbAdaperRate = (new DbAdaperFactory())->createService();
$dbAdaperCom = (new DbAdaperFactory())->createService();


$userId = $_POST['user_id'];

$urep = new UserRepository($dbAdaperUser);
$urat = new RatingRepository($dbAdaperRate);
$ucom = new CommentRepository($dbAdaperCom);


$ucom->delete_comments($userId);
$urat->delete_ratings($userId);
$urep->delete_user($userId);

if (isset($_POST['delete_account']))
{

    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['admin']);

    header('Location: index.php');
}
if (isset($_POST['del_as_admin']))
{
    header('Location: admin_page.php');
}

?>