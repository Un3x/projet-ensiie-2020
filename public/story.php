<?php
    include_once '../src/utils/autoloader.php';

    use Story\StoryRepository;
    $db = (new DbAdaperFactory())->createService();
    $storyRepo = new StoryRepository($db);

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
    loadView('story', $data);
?>