<?php
include_once '../src/utils/autoloader.php';

use Story\StoryRepository;
use Comment\CommentRepository;

$dbAdaper = (new DbAdaperFactory())->createService();
$storyRepo = new Story\StoryRepository($dbAdaper);
$comRepo = new CommentRepository($dbAdaper);
$data =[];

if (isset($_GET['storyId'])) {
  // Get story data
  $story =  $storyRepo->fetchStory($_GET['storyId']);
  $data['story']=$story;
  
  // Get rating data ... I guess

  // Get comment data ... XD lol
  $comments = $comRepo->fetchStoryCom($_GET['storyId']);
  $data['comments'] = $comments;

  // Load the view
  loadView('story_page',$data);
}
?>

