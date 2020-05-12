<?php
use User\UserRepository;

session_start();
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);

$id_post = $_REQUEST['id_post'] ?? null;
if ($id_post) {
    $comments = $userRepository->fetchComments($id_post);
    foreach ($comments as $comment) {
        echo "<div class=\"shadow p-3 mb-5 bg-white rounded\" >
                <p>{$comment->getContent()} </p>
                <footer class=\"blockquote-footer\">
                    par <strong>{$comment->getAuthor()}</strong>
                    , {$comment->getCreatedAt()->format('g:ia \o\n l jS F Y')}</footer>
                    <div style='padding: 10px'>";
                   if ($_SESSION['username'] == $comment->getAuthor() || $_SESSION['admin']) {
                       echo "<button  class='delete' style='position: relative;left : 89%' onclick=\"deletecomment({$comment->getID()});showComments({$id_post});\">Supprimer</button>";
                           }
echo"                </div>
            </div>";
    }
}