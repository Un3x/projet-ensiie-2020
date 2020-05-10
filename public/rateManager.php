<?php
ob_start();
session_start();
include_once "../src/utils/autoloader.php";

use Rating\RatingRepository;

$db = (new DbAdaperFactory())->createService();
$rateRepo = new RatingRepository($db);

if (isset($_POST['rate_story'])) {
    $userId = $_SESSION['id'];
    $storyId = $_POST['storyId'];
    $rate = $_POST['rate'];
    $success = $rateRepo->addRate($userId, $storyId, $rate);
    if ($success) {
        $_SESSION['success'] = "Notation prise en compte !";
        header('Location: story_page.php?storyId='.$storyId.'');
    } else {
        $_SESSION['errors'] = "Impossible de noter, réessayez plus tard.";
        header('Location: display_stories.php');
    }
}
else{
    $_SESSION['errors'] = "Un problème est survenu, réessayez plus tard";
    header('Location: display_stories.php');
}

?>