<?php
ob_start();
session_start();
include_once "../src/utils/autoloader.php";

use Comment\CommentRepository;

$db = (new DbAdaperFactory())->createService();
$comRepo = new CommentRepository($db);

if (isset($_POST['newComment'])) {
    $success = $comRepo->addComment($_SESSION['id'],$_POST['storyId'],$_POST['text']);
    if ($success) {
        $_SESSION['success'] = "Commentaire posté !";
        header('Location: story_page.php?storyId='.$_POST['storyId'].'');
    } else {
        $_SESSION['errors'] = "Impossible de commenter, réessayez plus tard.";
        header('Location: display_stories.php');
    }
}
if (isset($_POST['delCom'])){
    $comRepo->remove_comments($_POST['commentId']);
    $_SESSION['success'] = "Commentaire supprimé avec succès";
    header('Location: story_page.php?storyId='.$_POST['storyId'].'');
}
?>