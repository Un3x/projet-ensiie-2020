<?php

namespace Comment;

class CommentRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchStoryCom(int $storyId)
    {
        $query = 'SELECT commentid, storyid, username, txt  FROM comment NATURAL JOIN users WHERE storyid=:storyId';
        $commentsData = $this->dbAdapter->prepare($query);
        $commentsData->bindParam(':storyId', $storyId);
        $commentsData->execute();

        $comments = [];
        foreach ($commentsData as $comDat) {
          // Create a story object and add it to the stories list
          $comment = new Comment();
          $comment
            ->setId(intval($comDat['commentid']))
            ->setStoryId(intval($comDat['storyid']))
            ->setUser($comDat['username'])
            ->setText(stripcslashes($comDat['txt']));
          $comments[] = $comment;
        }
        return $comments;
    }

    public function addComment(int $userId, int $storyId, string $text) {
        if (is_int($userId) && is_int($storyId) && is_string($text)) {
            $query = "INSERT INTO comment (storyid, userid, txt) VALUES(:userId, :storyId, :text)";
            $result = $this->dbAdapter->prepare($query);
            $result->bindParam(':userId', $userId);
            $result->bindParam(':storyId', $storyId);
            $result->bindParam(':text', addcslashes($text,'\+*?[^]$(){}=!<>|:-'));
            $result->execute();
            return $result;
        }
        return false;
    }

    public function delete_comments(int $userId)
    {
        $query = "UPDATE comment SET userId = 1 WHERE userId =:userId";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':userId', $userId);
        $result->execute();
    }

}