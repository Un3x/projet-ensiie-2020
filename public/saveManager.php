<?php
ob_start();
include_once '../src/utils/autoloader.php';

use Save\SaveRepository;

$db = (new DbAdaperFactory())->createService();
$saveRepo = new SaveRepository($db);

if (isset($_SESSION['id'])) {
    $saveId = $saveRepo->existSave($_SESSION['id'], $_POST['storyId']);
    if ($saveId) {
        $saveRepo->updateSave($saveId, $_POST['pageId'], $_SESSION['skill'], $_SESSION['stamina'], $_SESSION['luck']);
    } else {
        $saveRepo->addSave($_SESSION['id'], $_POST['pageId'], $_SESSION['skill'], $_SESSION['stamina'], $_SESSION['luck']);
    }
    header("Location: story.php?storyId=".$_POST['storyId']."&pageId=".$_POST['pageId']."");
}


?>