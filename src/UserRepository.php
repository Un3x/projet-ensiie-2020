<?php

namespace User;

include '../src/User.php';
include '../src/Post.php';
include '../src/Comment.php';
include '../src/Message.php';

use DateTime;
use Exception;
use Interest\Interest;
use PDO;
use Post\Post;
use Post\Comment;

class UserRepository
{
    /**
     * @var PDO
     */
    private $dbAdapter;

    public function __construct(PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll()
    {
        $usersData = $this->dbAdapter->query('SELECT * FROM "user"');
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            try {
                $user
                    ->setUsername($usersDatum['username'])
                    ->setPassword($usersDatum['user_password'])
                    ->setEmail($usersDatum['email'])
                    ->setCreatedAt(new DateTime($usersDatum['created_at']))
                    ->setAdmin($usersDatum['is_admin']);
            } catch (Exception $e) {
            }
            $users[] = $user;
        }
        return $users;
    }

    public function deleteUser($username)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "user" where username = :username');


        $stmt->bindParam(':username', $username);
        $stmt->execute();
    }

    public function follow($userfollowing, $userfollowed)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "Follow" (user_followed,user_following) VALUES (:userfollowed,:userfollowing) ');
        $stmt->bindParam(':userfollowed', $userfollowed);
        $stmt->bindParam(':userfollowing', $userfollowing);
        $stmt->execute();
    }

    public function unfollow($userfollowing, $userfollowed)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "Follow" where user_followed = :userfollowed and user_following = :userfollowing ');
        $stmt->bindParam(':userfollowed', $userfollowed);
        $stmt->bindParam(':userfollowing', $userfollowing);
        $stmt->execute();
    }

    public function fetchfollowers($username)
    {
        $usersData = $this->dbAdapter->prepare('SELECT DISTINCT username,user_password,is_admin,email,created_at FROM "user" JOIN "Follow" ON username = user_following where :username=user_followed');
        $usersData->bindParam(':username', $username);
        $usersData->execute();
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            try {
                $user
                    ->setUsername($usersDatum['username'])
                    ->setPassword($usersDatum['user_password'])
                    ->setEmail($usersDatum['email'])
                    ->setCreatedAt(new DateTime($usersDatum['created_at']))
                    ->setAdmin($usersDatum['is_admin']);
            } catch (Exception $e) {
            }
            $users[] = $user;
        }
        return $users;
    }

    public function fetchfollowed($username)
    {
        $usersData = $this->dbAdapter->prepare('SELECT DISTINCT username,user_password,is_admin,email,created_at FROM "user" JOIN "Follow" ON username = user_followed where :username=user_following');
        $usersData->bindParam(':username', $username);
        $usersData->execute();
        $users = [];
        foreach ($usersData as $usersDatum) {
            $user = new User();
            try {
                $user
                    ->setUsername($usersDatum['username'])
                    ->setPassword($usersDatum['user_password'])
                    ->setEmail($usersDatum['email'])
                    ->setCreatedAt(new DateTime($usersDatum['created_at']))
                    ->setAdmin($usersDatum['is_admin']);
            } catch (Exception $e) {
            }
            $users[] = $user;
        }
        return $users;
    }

    public function register($username, $password, $email)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "user" (username,user_password,email,created_at) VALUES (:username,:password, :email,clock_timestamp()) ');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    }

    public function fetchInterests($username)
    {
        $interestsData = $this->dbAdapter->prepare('SELECT DISTINCT "Interest".theme as theme, subscribers FROM "Interest"  JOIN "Interested" ON "Interest".theme = "Interested".theme WHERE username=:username');
        $interestsData->bindParam(':username', $username);
        $interestsData->execute();
        $interests = [];
        foreach ($interestsData as $interestsDatum) {
            $interest = new Interest();
            try {
                $interest
                    ->setTheme($interestsDatum['theme'])
                    ->setSubscribers($interestsDatum['subscribers']);
            } catch (Exception $e) {
            }
            $interests[] = $interest;
        }
        return $interests;
    }

    public function fetchUser($username)
    {
        $usersData = $this->dbAdapter->prepare('SELECT * FROM "user" WHERE username=:username');
        $usersData->bindParam(':username', $username);
        $usersData->execute();
        foreach ($usersData as $usersDatum) {
            $user = new User();
            try {
                $user
                    ->setUsername($usersDatum['username'])
                    ->setPassword($usersDatum['user_password'])
                    ->setEmail($usersDatum['email'])
                    ->setCreatedAt(new DateTime($usersDatum['created_at']))
                    ->setAdmin($usersDatum['is_admin']);
            } catch (Exception $e) {
            }
            return $user;
        }

    }

    public function userCanLog($username, $password)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT * FROM "user" WHERE username=:username AND user_password=:password');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $count = 0;
        foreach ($stmt as $user) {
            $count += 1;
        }
        if ($count == 0) {
            return false;
        }
        return true;
    }

    public function userExists($username)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT * FROM "user" WHERE username=:username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $count = 0;
        foreach ($stmt as $user) {
            $count += 1;
        }
        if ($count == 0) {
            return false;
        }
        return true;
    }

    public function addInterested($username, $Pref)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "Interested" (username,theme) VALUES (:user,:pref)');
        $stmt->bindParam(':user', $username);
        $stmt->bindParam(':pref', $Pref);
        $stmt->execute();
    }


    public function addPost($username, $content, $theme)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "Post" (author, post_content, created_at,theme) VALUES (:user,:content,clock_timestamp(),:theme)');
        $stmt->bindParam(':user', $username);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':theme', $theme);
        $stmt->execute();
    }

    public function fetchPosts($username)
    {
        $PostsData = $this
            ->dbAdapter
            ->prepare('SELECT *,"Post".created_at as creation_date FROM "Post" JOIN "user" ON username = author WHERE username=:username ORDER BY "Post".created_at DESC');
        $PostsData->bindParam(':username', $username);
        $PostsData->execute();
        $Posts = [];
        foreach ($PostsData as $PostsDatum) {
            $Post = new Post();
            try {
                $Post
                    ->setContent($PostsDatum['post_content'])
                    ->setId($PostsDatum['id_post'])
                    ->setAuthor($PostsDatum['author'])
                    ->setCreatedAt(new DateTime($PostsDatum['creation_date']))
                    ->setTheme($PostsDatum['theme']);
            } catch (Exception $e) {
            }
            $Posts[] = $Post;
        }
        return $Posts;
    }

    public function SetPref($username, $Pref)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "Interested" (username, theme) VALUES (:user,:pref)');
        foreach ($Pref as $name) {
            $stmt->bindParam(':user', $username);
            $stmt->bindParam(':pref', $name);
            $stmt->execute();
        }
    }

    public function fetchPost($id_post)
    {
        $postsData = $this->dbAdapter->prepare('SELECT * FROM "Post" WHERE id_post=:id_post');
        $postsData->bindParam(':id_post', $id_post);
        $postsData->execute();
        foreach ($postsData as $postsDatum) {
            $post = new Post();
            try {
                $post
                    ->setContent($postsDatum['post_content'])
                    ->setId($postsDatum['id_post'])
                    ->setTheme($postsDatum['theme'])
                    ->setAuthor($postsDatum['author'])
                    ->setCreatedAt(new DateTime($postsDatum['created_at']));
            } catch (Exception $e) {
            }
            return $post;
        }
    }

    public function deletePost($id_post)
    {
        $comments = $this->fetchComments($id_post);
        foreach ($comments as $comment){
            $this->deleteComment($comment->getId());
        }
        $likes = $this->getLikes($id_post);
        for ($i = 0; $i < $likes; $i++){
            $stmt = $this->dbAdapter->prepare('DELETE FROM "Like" WHERE id_post = :id_post');
            $stmt->bindParam(':id_post',$id_post);
            $stmt->execute();
        }
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "Post" where id_post = :id_post');
        $stmt->bindParam(':id_post', $id_post);
        $stmt->execute();
    }

    public function getLikes($id_post)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT DISTINCT username FROM "Like" WHERE id_post=:id_post');
        $stmt->bindParam(':id_post', $id_post);
        $stmt->execute();
        $i = 0;
        foreach ($stmt as $count) {
            $i += 1;
        }
        return $i;
    }

    public function likePost($id_post, $username)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "Like" (username,id_post) VALUES (:username,:id_post)');
        $stmt->bindParam(':id_post', $id_post);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    }

    public function countsub($theme)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "Interest" SET subscribers=(SELECT COUNT(DISTINCT username) FROM "Interested" WHERE theme=:theme) WHERE theme=:theme');
        $stmt->bindParam('theme', $theme);
        $stmt->execute();
    }

    public function fetchPostsTheme($theme)
    {
        $PostsData = $this
            ->dbAdapter
            ->prepare('SELECT *,"Post".created_at as creation_date FROM "Post" WHERE theme=:theme ORDER BY "Post".created_at DESC');
        $PostsData->bindParam(':theme', $theme);
        $PostsData->execute();
        $Posts = [];
        foreach ($PostsData as $PostsDatum) {
            $Post = new Post();
            try {
                $Post
                    ->setContent($PostsDatum['post_content'])
                    ->setId($PostsDatum['id_post'])
                    ->setAuthor($PostsDatum['author'])
                    ->setCreatedAt(new DateTime($PostsDatum['creation_date']))
                    ->setTheme($PostsDatum['theme']);
            } catch (Exception $e) {
            }
            $Posts[] = $Post;
        }
        return $Posts;
    }

    public function fetchComments($id_post)
    {
        $CommentsData = $this
            ->dbAdapter
            ->prepare('SELECT *,"Comment".created_at as creation_date FROM "Comment"  WHERE id_post=:id_post ORDER BY "Comment".created_at ');
        $CommentsData->bindParam(':id_post', $id_post);
        $CommentsData->execute();
        $Comments = [];
        foreach ($CommentsData as $CommentsDatum) {
            $Comment = new Comment();
            try {
                $Comment
                    ->setContent($CommentsDatum['content'])
                    ->setId($CommentsDatum['id_comment'])
                    ->setAuthor($CommentsDatum['author'])
                    ->setCreatedAt(new DateTime($CommentsDatum['creation_date']))
                    ->setIdPost($CommentsDatum['id_post']);
            } catch (Exception $e) {
            }
            $Comments[] = $Comment;
        }
        return $Comments;
    }

    public function addComment($author, $id_post, $content)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "Comment" (id_post, author, content, created_at)  VALUES (:id_post,:author,:content,now())');
        $stmt->bindParam(':id_post', $id_post);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
    }

    public function deleteComment($id_comment)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "Comment" where id_comment = :id_comment');
        $stmt->bindParam(':id_comment', $id_comment);
        $stmt->execute();
    }

    public function fetchComment($id_Comment)
    {
        $CommentsData = $this->dbAdapter->prepare('SELECT * FROM "Comment" WHERE id_comment=:id_comment');
        $CommentsData->bindParam(':id_comment', $id_Comment);
        $CommentsData->execute();
        foreach ($CommentsData as $CommentsDatum) {
            $Comment = new Comment();
            try {
                $Comment
                    ->setContent($CommentsDatum['content'])
                    ->setId($CommentsDatum['id_comment'])
                    ->setIdPost($CommentsDatum['id_post'])
                    ->setAuthor($CommentsDatum['author'])
                    ->setCreatedAt(new DateTime($CommentsDatum['created_at']));
            } catch (Exception $e) {
            }
            return $Comment;
        }
    }

    public function unsub($username, $theme)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "Interested" where username = :username AND theme=:theme');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':theme', $theme);
        $stmt->execute();
    }

    public function fetchMessagesSent($sender)
    {
        $MessagesData = $this
            ->dbAdapter
            ->prepare('SELECT *,"Message".created_at as creation_date FROM "Message"  WHERE sender=:sender ORDER BY "Message".created_at ');
        $MessagesData->bindParam(':sender', $sender);
        $MessagesData->execute();
        $Messages = [];
        foreach ($MessagesData as $MessagesDatum) {
            $Message = new Message();
            try {
                $Message
                    ->setContent($MessagesDatum['content'])
                    ->setId($MessagesDatum['id_message'])
                    ->setSender($MessagesDatum['sender'])
                    ->setCreatedAt(new DateTime($MessagesDatum['creation_date']))
                    ->setReceiver($MessagesDatum['receiver']);
            } catch (Exception $e) {
            }
            $Messages[] = $Message;
        }
        return $Messages;
    }

    public function fetchMessagesReceived($receiver)
    {
        $MessagesData = $this
            ->dbAdapter
            ->prepare('SELECT *,"Message".created_at as creation_date FROM "Message"  WHERE receiver=:receiver ORDER BY "Message".created_at ');
        $MessagesData->bindParam(':receiver', $receiver);
        $MessagesData->execute();
        $Messages = [];
        foreach ($MessagesData as $MessagesDatum) {
            $Message = new Message();
            try {
                $Message
                    ->setContent($MessagesDatum['content'])
                    ->setId($MessagesDatum['id_message'])
                    ->setSender($MessagesDatum['sender'])
                    ->setCreatedAt(new DateTime($MessagesDatum['creation_date']))
                    ->setReceiver($MessagesDatum['receiver']);
            } catch (Exception $e) {
            }
            $Messages[] = $Message;
        }
        return $Messages;
    }

    public function sendMessage($sender,$receiver,$content)
        {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "Message" (sender, receiver, content, created_at)  VALUES (:sender,:receiver,:content,now())');
        $stmt->bindParam(':sender', $sender);
        $stmt->bindParam(':receiver', $receiver);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
    }
    public function fetchfollowcomments($username){
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT *,"Post".created_at as creation_date FROM "Post" JOIN "Follow" ON author=user_followed WHERE user_following=:username ORDER BY "Post".created_at DESC');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $Posts = [];
        foreach ($stmt as $PostsDatum) {
            $Post = new Post();
            try {
                $Post
                    ->setContent($PostsDatum['post_content'])
                    ->setId($PostsDatum['id_post'])
                    ->setAuthor($PostsDatum['author'])
                    ->setCreatedAt(new DateTime($PostsDatum['creation_date']))
                    ->setTheme($PostsDatum['theme']);
            } catch (Exception $e) {
            }
            $Posts[] = $Post;
        }
        return $Posts;
    }
}

