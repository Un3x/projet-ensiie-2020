<?php

use Interest\InterestRepository;
use User\UserRepository;


include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/InterestRepository.php';

session_start();
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$username = $_REQUEST['username'];
$interestRepository = new InterestRepository($dbAdaper);
$interestsAll = $interestRepository->fetchAll();
$interestsUser = $userRepository->fetchInterests($username);
$posts = $userRepository->fetchPosts($username);
echo "<h1 style='text-align: center; font-weight: 700'>Mur </h1>";
foreach ($posts as $post) {
    echo "<div class=\"shadow p-3 mb-5 bg-white rounded\" > <p>{$post->getContent()}</p>
                <footer class=\"blockquote-footer\">{$post->getTheme()}, {$post->getCreatedAt()->format('g:ia \o\n l jS F Y')}</footer>
                <div style='padding: 10px'> 
                    <button class='like' onclick=\"likePost({$post->getId()},username);show_wall(username)\">
                        <i class='icon solid fa fa-heart'></i> {$userRepository->getLikes($post->getId())}</button>
                    <button class='comments' onclick=\"gotoComments({$post->getId()})\">Commentaires</button>";
    if ($_SESSION['username'] == $post->getAuthor() || $_SESSION['admin']) {
        echo "<button  class='delete' onclick=\"deletepost({$post->getID()});show_wall(username);\">Supprimer</button> ";
    }
    echo " </div>
            </div>";

}