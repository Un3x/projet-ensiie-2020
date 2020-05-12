<?php

use User\UserRepository;

session_start();
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);

$theme = $_REQUEST['theme'] ?? null;
$follow = $_REQUEST['follow'] ?? null;
if ($theme) {
    $PostsTheme = $userRepository->fetchPoststheme($theme);

    foreach ($PostsTheme as $post) {
        echo " <div class=\"shadow p-3 mb-5 bg-white rounded\" > <p>{$post->getContent()}</p>
<footer class=\"blockquote-footer\">par <strong>{$post->getAuthor()}</strong> dans {$post->getTheme()}
    , {$post->getCreatedAt()->format('g:ia \o\n l jS F Y')}</footer>
<div style='padding: 10px'>
    <button class='like' onclick=\"likePost({$post->getId()},username);showPosts('theme')\">
        <i class='icon solid fa fa-heart'></i> {$userRepository->getLikes($post->getId())}</button>
    <button class='comments' onclick=\"gotoComments({$post->getId()})\">Commentaires</button>";
        if ($_SESSION['username'] == $post->getAuthor() || $_SESSION['admin']) {
            echo "<button class='delete' onclick=\"deletepost({$post->getID()});showPosts('theme');\">Supprimer</button>";
        }
        echo "
</div>
</div>";
    }
} else if ($follow) {
    $followedcomments = $userRepository->fetchfollowcomments($follow);
    foreach ($followedcomments as $followcom) {
        echo "<div class=\"shadow p-3 mb-5 bg-white rounded\" > <p>{$followcom->getContent()}</p>
        <footer class=\"blockquote-footer\"> par <strong>{$followcom->getAuthor()}</strong> dans {$followcom->getTheme()}, {$followcom->getCreatedAt()->format('g:ia \o\n l jS F Y')}</footer>
        <div style='padding: 10px'>
            <button class='like' onclick=\"likePost({$followcom->getId()},username);showPosts('follow')\">
                <i class='icon solid fa fa-heart'></i> {$userRepository->getLikes($followcom->getId())}</button>
            <button class='comments' onclick=\"gotoComments({$followcom->getId()})\">Commentaires</button>";
        if ($_SESSION['username'] == $followcom->getAuthor() || $_SESSION['admin']) {
            echo "<button  class='delete' onclick=\"deletepost({$followcom->getID()});showPosts('follow');\">Supprimer</button> ";
        }
        echo "</div>
    </div>";
    }
}