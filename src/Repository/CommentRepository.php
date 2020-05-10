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
            ->setId($comDat['commentid'])
            ->setStoryId($comDat['storyid'])
            ->setUser($comDat['username'])
            ->setText($comDat['txt']);
          $comments[] = $comment;
        }
        return $comments;
    }

    public function delete_comments(int $userId)
    {
        $query = "UPDATE comment SET userId = 1 WHERE userId =:userId";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':userId', $userId);
        $result->execute();
    }

}