<?php
include_once '../src/utils/autoloader.php';

use Story\StoryRepository;

$dbAdaper = (new DbAdaperFactory())->createService();
$storyRepo = new Story\StoryRepository($dbAdaper);
$data =[];

if (isset($_GET['storyId'])) {
  // Get story data
  $story =  $storyRepo->fetchStory($_GET['storyId']);
  $data['story']=$story;
  
  // Get rating data ... I guess

  // Get comment data ... XD lol

  // Load the view
  loadView('story_page',$data);
}
?>

