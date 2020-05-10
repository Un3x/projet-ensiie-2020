<?php
include_once '../src/utils/autoloader.php';
use Story\StoryRepository;

$db = (new DbAdaperFactory())->createService();
$story_repo= new StoryRepository($db);
$data=[];
$stories=$story_repo->fetchAll();
$data['stories']=$stories;

loadView('display_stories',$data);
?>
