<?php
    include_once '../src/utils/autoloader.php';

    use Story\StoryRepository;
    $db = (new DbAdaperFactory())->createService();
    $storyRepo = new StoryRepository($db);
    
    $story = $storyRepo->fetchStoryByTitle($_GET['request']);
    
    $data = [];
    $data['storyId'] = $story->getId();
    $data['title'] = $story->getTitle();
    $data['author'] = $story->getAuthor();

    loadView('search', $data);
?>