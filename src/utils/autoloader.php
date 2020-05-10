<?php
session_start();
include '../src/Entity/User.php';
include '../src/Entity/Story.php';
include '../src/Entity/Page.php';
include '../src/Entity/Rating.php';
include '../src/Repository/UserRepository.php';
include '../src/Repository/StoryRepository.php';
include '../src/Repository/RatingRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/View/template.php';
include '../src/utils/scripts.js';
?>
