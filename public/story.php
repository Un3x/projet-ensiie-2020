<?php
    include_once '../src/utils/autoloader.php';

    use Story\StoryRepository;
    $db = (new DbAdaperFactory())->createService();
    $storyRepo = new StoryRepository($db);

    if (is_null($_GET['storyId'])){
        $_SESSION['errors'] = "Veuillez choisir une histoire.";
        header('location: display_stories.php');
    }

    $story = $storyRepo->fetchStory($_GET['storyId']);
    $pages = $storyRepo->fetchPages($_GET['storyId']);

    if (isset($_GET['pageId']))
        foreach ($pages as $p) {
            if ($p->getId() == $_GET['pageId'])
                $cur = $p;
        }
    else
        foreach($pages as $p) {
            if ($p->getFirst())
                $cur = $p;
        }

    $data = [];
    $data['storyId'] = $_GET['storyId'];
    $data['title'] = $story->getTitle();
    $data['page'] = $cur;
    
    $_SESSION['page'] = $data['page']->getId();
    $_SESSION['story'] = $data['storyId'];
    $_SESSION['skill'] = $story->getSkill();
    $_SESSION['stamina'] = $story->getStamina();
    $_SESSION['luck'] = $story->getLuck();

    loadView('story', $data);
?>