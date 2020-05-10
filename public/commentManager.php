<?php
ob_start();
include_once "../src/utils/autoloader.php";

use Comment\CommentRepository;

$db = (new DbAdaperFactory())->createService();
$comRepo = new CommentRepository($db);

if (isset($_POST['newComment'])) {
    $success = $comRepo->addComment($_SESSION['id'],$_POST['storyId'],$_POST['text']);
    if ($success) {
        header('Location: story_page.php?storyId='.$_POST['storyId']);
    } else {
        // affiche une page d'erreur
    }
}
// affiche une page d'erreur

?>