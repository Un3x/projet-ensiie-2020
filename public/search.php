<?php

use Comment\Comment;
use Friendship\FriendshipRepository;
use Post\Post;

include '../src/Factory/DbAdaperFactory.php';

include '../src/Model/User/User.php';
include '../src/Model/User/UserRepository.php';


include '../src/Model/Post/Post.php';
include '../src/Model/Post/PostRepository.php';

include '../src/Model/Comment/Comment.php';
include '../src/Model/Comment/CommentRepository.php';

include '../src/Model/Friendship/Friendship.php';
include '../src/Model/Friendship/FriendshipRepository.php';

include "./screen/printlayout.php";
$dbAdaper = (new DbAdaperFactory())->createService();

$userRepository = new \User\UserRepository($dbAdaper);
$friendshipRepository = new \Friendship\FriendshipRepository($dbAdaper);

$users = $userRepository->fetchAll();
$friends = $friendshipRepository->fetchAll();

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
    <?php $loc='search.php'?>
        <?php printNav($friends, $userRepository,$loc); ?>
        <div class="main">
            <div class="container">
                <div class="titleincenter">
                    <h1>Utilisateurs correspondants à <?php echo $_POST['search_words'];?></h1>
                </div>

                    <?php if (isset($_SESSION['id']) && isset($_SESSION['pseudo']) && isset($_SESSION['email']) && isset($_SESSION['inactive'])) :
                        if ($_SESSION['inactive']) :
                            echo "<div class=\"col-sm-12\"><div class=\"borderpost\"><div class=\"settingsmain\"><h1>Veuillez réactiver votre compte pour rechercher un utilisateur</h1><br><hr><br><form action=\"ReactivateAccount.php\" method='POST'>
                                                <input type='hidden' name='reactivateid' value='";
                            echo $_SESSION['id'];
                            echo "'/>
                                                <input type='submit' style=\"color :blue; name=\"reactivateaccount\" value=\"Réactiver mon compte\"/>
                                            </form>
                                            <br>
                                            <span>En réactivant votre compte, tous vos posts seront de nouveau visibles</span></div></div></div>";
                        else :
                                $i = 0;
                                foreach ($users as $user) :
                                    if(strncmp(strtolower($_POST['search_words']),strtolower($user->getUsername()),strlen($_POST['search_words']))==0){ 
                                    echo "<div class='col-sm-12'><div class='borderpost' style=\"text-align:center;\">";
                                        echo "Nom : <a href=\"./userprofile.php?user=".$user->getUsername().
                                        "&amp;useridincoming=".$user->getId()."\">".$user->getUsername()."</a><br>";
                                        echo "Slogan : ".$user->getSlogan()."<br>";
                                    echo "</div></div><br>";
                                    $i += 1;
                                    }
                                endforeach;
                                if ($i == 0) {
                                    echo "<divclass='col-sm-12'><p style=\"text-align:center;\">Aucun utilisateur ne correspond à votre recherche</p></div>";
                                }
                    ?>

                        <?php endif; ?>
                    <?php else : echo "</div><div class=\"col-sm-12\"><div class=\"borderpost\"><div class=\"settingsmain\"><h1>Veuillez vous connecter pour rechercher un utilisateur</h1><br><hr><br><form action=\"./index.php\"><input type='submit'value='Se connecter'/></form></div></div></div>";

                    endif; ?>

</body>
</html>