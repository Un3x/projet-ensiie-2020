<?php

use Post\Post;
use Comment\Comment;
use Friendship\FriendshipRepository;

include '../src/Model/User/User.php';
include '../src/Model/User/UserRepository.php';
include '../src/Model/Post/Post.php';
include '../src/Model/Post/PostRepository.php';
include '../src/Model/Comment/Comment.php';
include '../src/Model/Comment/CommentRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Model/Friendship/Friendship.php';
include '../src/Model/Friendship/FriendshipRepository.php';

include "./screen/printlayout.php";
$dbAdaper = (new DbAdaperFactory())->createService();

$userRepository = new \User\UserRepository($dbAdaper);
$postRepository = new \Post\PostRepository($dbAdaper);
$commentRepository = new \Comment\CommentRepository($dbAdaper);
$friendshipRepository = new \Friendship\FriendshipRepository($dbAdaper);

$posts = $postRepository->fetchAllRecent();
$users = $userRepository->fetchAll();
$comments = $commentRepository->fetchAll();
$friends = $friendshipRepository->fetchAll();


if (isset($_GET["wantnewpost"]))
    $wantnewpost = $_GET["wantnewpost"];

else {
    $wantnewpost = 1;
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {



    if ($wantnewpost == 1) {
        $newPost = new Post();

        $newPost
            ->setContent($_POST["content"])
            ->setCreatedAt(date("Y-m-d H:i:s"))
            ->setAuthorId(($_POST["user"]));

        $postRepository->create($newPost);

        header("location:profile.php");
    } else if ($wantnewpost == 0) {
        $newComment = new Comment();

        $newComment
            ->setContent($_POST["contentComment"])
            ->setCreatedAt(date("Y-m-d H:i:s"))
            ->setAuthorId(($_POST["userComment"]))
            ->setPostId(($_POST["postComment"]));

        $commentRepository->create($newComment);
        $postid= $_POST["postComment"];
        header("location:profile.php#post$postid");
    }
}

session_start();
?>





<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FacebIIkE</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Maureen LACHAIZE">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="shortcut icon" type="image/png" href="./images/icon-chevre.png" />

</head>

<body>
    <div class="flex-container">
        <?php printNav($friends, $userRepository,'profile.php'); ?>
        <div class="main">
            <div class="container">
                <div class="titleincenter">
                    <h1>Profil utilisateur</h1>

                    <?php if (isset($_SESSION['id']) && isset($_SESSION['pseudo']) && isset($_SESSION['email']) && isset($_SESSION['inactive'])) :
                        if ($_SESSION['inactive']) :
                            echo "<div class=\"col-sm-12\"><div class=\"borderpost\"><div class=\"settingsmain\"><h1>Veuillez réactiver votre compte pour accéder au profil utilisateur</h1><br><hr><br><form action=\"ReactivateAccount.php\" method='POST'>
                                                <input type='hidden' name='reactivateid' value='";
                            echo $_SESSION['id'];
                            echo "'/>
                                                <input type='submit' style=\"color :blue; name=\"reactivateaccount\" value=\"Réactiver mon compte\"/>
                                            </form>
                                            <br>
                                            <span>En réactivant votre compte, tous vos posts seront de nouveau visibles</span></div></div></div>";
                        else :
                            echo " Bienvenue sur votre profil !";
                            echo "</div>";
                            echo "<div class=\"col-sm-12\">
                    <div class=\"borderpost\">
                    <div class=\"settingsmain\">";
                        if(strcmp($_SESSION['slogan'],'')!=0){
                            echo "Mon slogan : " . $_SESSION['slogan'] . "<br/>";
                        }
                        else{
                            echo "Mon slogan : Vous n'avez pas défini de slogan !<br/>";
                        }
                                
                            echo "Adresse mail : " . $_SESSION['email'] . "<br/>";

                            if(strcmp($_SESSION['descript'],'')!=0){
                            echo "Ma description : " . $_SESSION['descript'] . "<br/>";
                        }
                        else{
                            echo "Ma description : Vous n'avez pas défini de description !<br/>";
                        }
                            
                            echo "<hr><br><form action=\"./settings.php\"><input type='submit'value='Modifier mes infos'/></form>";
                            echo "</div>
                    </div>
                    </div>"; ?>

                            <hr>
                            <div class="titleincenter">
                                <h1>Vos posts les plus récents</h1>
                            </div>
                            <br>
                            <div class="col-sm-12">
                                <?php
                                $i = 1;
                                foreach ($posts as $post) : ?>
                                    <?php if (($_SESSION['id'] == $post->getAuthorId())) : #si l'utilisation est lui-meme
                                    ?>
                                        <div class='borderpost' id='post<?php echo $post->getId();?>'>
                                            <span style="text-decoration: underline;">De :</span>
                                            <?php
                                            echo "<span style='text-decoration:underline;font-weight:bold;font-size:18px'>";
                                            foreach ($users as $user) {

                                                if ($user->getId() == $post->getAuthorId()) {
                                                    if ($user->getInactive() == 0) {
                                                        echo "<a href=\"./userprofile.php?user=" . $user->getUsername() . "&amp;useridincoming=" . $user->getId() . "\">" . $user->getUsername() . "</a>";
                                                    } else echo "Inconnu";
                                                }
                                            }
                                            ?>
                                            </span><br />
                                            <span style="text-decoration: underline;">Le :</span> <?php echo $post->getCreatedAt()->format("d/m/Y || H:i");
                                                                                                    if ($_SESSION['admin']) {
                                                                                                        echo "<form action=\"DeletePost.php\" method='post'> <input type='hidden' value=\"";
                                                                                                        echo $post->getId();
                                                                                                        echo "\" name='posttodelete'/> <input type='submit' value=\"Supprimer le post\" name=\"buttondeletepost\" class=\"buttondeletepost\" id=\"buttondelete\"/></form>";
                                                                                                    } ?>

                                            <hr>

                                            <div class="contentpost">
                                                <?php echo $post->getContent() ?><br />
                                                <hr>
                                            </div>
                                            <div>
                                                <form action="Like.php" method='post'>
                                                    <input type='hidden' value='<?php echo $post->getId()?>' name='posttolike'>
                                                    <input type='hidden' value='<?php echo $post->getLikeCount()?>' name='likecount'>
                                                    <input type='hidden' value='profile.php' name='src'>
                                                    <input type='submit' value="Like" name="likebutton" class="likebutton" id="likebutton">
                                                    <input type='submit' value="Dislike" name="dislikebutton" class="dislikebutton" id="dislikebutton">
                                                </form>
                                            </div>
                                            <span style="text-decoration: underline;">Nombre de likes :</span> <?php echo $post->getLikeCount(); ?>
                                            <br />
                                            <span style="text-decoration: underline;">Commentaires :</span> <br />
                                            <?php
                                            $commecount = 0;
                                            foreach ($comments as $comment) {
                                                if ($comment->getPostId() == $post->getId()) {
                                                    $commecount = $commecount + 1;
                                                    echo $comment->getCreatedAt()->format("d/m/Y");
                                                    echo " <span> | </span> ";
                                                    echo "<span style='text-decoration:underline;color:blue'>";
                                                    foreach ($users as $user) {
                                                        if ($user->getId() == $comment->getAuthorId()) {
                                                            if ($user->getInactive() == 0) {
                                                                echo "<a href=\"./userprofile.php?user=" . $user->getUsername() . "&amp;useridincoming=" . $user->getId() . "\">" . $user->getUsername() . "</a>";
                                                            } else echo "Inconnu";
                                                        }
                                                    }


                                                    echo ' :';
                                                    echo "</span>";
                                                    echo " ";
                                                    echo $comment->getContent();
                                                    echo '<br/>';
                                                }
                                            }
                                            if ($commecount == 0) {
                                                echo "<p>Il n'y a aucun commentaire sur cette publication<p>";
                                            }

                                            ?>


                                            <hr>

                                            <section class=" bordernewcomment">
                                                <?php echo "<button id='";
                                                echo "commenterbutton" . strval($i);
                                                echo "'";
                                                echo "style=\"display:block;\" onclick=\"show(1,'";
                                                echo strval($i);
                                                echo "','";
                                                echo "commenter" . strval($i);
                                                echo "')\">Commenter</button>"; ?><?php echo "<button id='";
                                                                                    echo "cacher" . strval($i);
                                                                                    echo "'";
                                                                                    echo " style=\"display:none;\" onclick=\"show(0,'";
                                                                                    echo strval($i);
                                                                                    echo "','";
                                                                                    echo "commenter" . strval($i);
                                                                                    echo "')\">Cacher</button>"; ?><br>
                                                <div style="display:none;" <?php echo "id='";
                                                                            echo "commenter" . strval($i);
                                                                            echo "'"; ?>>
                                                    <form action='profile.php?wantnewpost=0' method='POST'>
                                                        <label for="contentComment">Commentaire en tant que <?php echo $_SESSION['pseudo']; ?> : </label> <input type='text' value="" id='contentComment' name="contentComment" required>
                                                        <?php
                                                        echo "<input type='hidden' id='userComment' name='userComment' value='";
                                                        echo $_SESSION['id'];
                                                        echo "'/>";
                                                        ?>
                                                        <input name="postComment" id="postComment" type="hidden" value=<?php echo $post->getId(); ?>>
                                                        <input id="saveButton" type="submit" value="Poster" /><br>
                                                    </form>
                                                </div>

                                            </section>

                                        </div>
                                    <?php
                                    endif; ?>
                                    <br>

                                <?php
                                    $i = $i + 1;
                                endforeach; ?>
                            </div>

                        <?php endif; ?>
                    <?php else : echo "</div><div class=\"col-sm-12\"><div class=\"borderpost\"><div class=\"settingsmain\"><h1>Veuillez vous connecter pour accéder au profil utilisateur</h1><br><hr><br><form action=\"./index.php\"><input type='submit'value='Se connecter'/></form></div></div></div>";

                    endif; ?>
                </div>
            </div>
            <script>
                function show(value, index, element) {
                    if (value == 0) {
                        document.getElementById(element).style.display = "none";
                        document.getElementById(''.concat('commenterbutton', index)).style.display = "block";
                        document.getElementById(''.concat('cacher', index)).style.display = "none";
                    } else {
                        document.getElementById(element).style.display = "block";
                        document.getElementById(''.concat('cacher', index)).style.display = "block";
                        document.getElementById(''.concat('commenterbutton', index)).style.display = "none";
                    }
                }
            </script>

</body>

</html>