<?php
include_once '../src/utils/autoloader.php';

use Story\StoryRepository;
use Rating\RatingRepository;

$dbAdaper = (new DbAdaperFactory())->createService();
$storyRepo = new Story\StoryRepository($dbAdaper);
$db = (new DbAdaperFactory())->createService();
$ratingRepo = new Rating\RatingRepository($db);
$data =[];


if (isset($_GET['storyId'])) {
  // Get story data
  $story =  $storyRepo->fetchStory($_GET['storyId']);
  $data['story']=$story;
  
  // Get rating data 
  $rating = $ratingRepo->fetchRating($_GET['storyId']);
  $data['rating']=$rating;
  $avg_rate=$ratingRepo->fetchAvgRating($data['story']->getId());
  $data['avg_rate']=$avg_rate;
  $count_rates=$ratingRepo->fetchCountRating($data['story']->getId());
  $data['count']=$count_rates;
  $star1=$ratingRepo->fetchStarCount($data['story']->getId(),1);
  $data['star1']=$star1;
  $star2=$ratingRepo->fetchStarCount($data['story']->getId(),2);
  $data['star2']=$star2;
  $star3=$ratingRepo->fetchStarCount($data['story']->getId(),3);
  $data['star3']=$star3;
  $star4=$ratingRepo->fetchStarCount($data['story']->getId(),4);
  $data['star4']=$star4;
  $star5=$ratingRepo->fetchStarCount($data['story']->getId(),5);
  $data['star5']=$star5;


  // Get comment data ... XD lol

  // Load the view
  loadView('story_page',$data);
}
?>

