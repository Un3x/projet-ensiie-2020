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

    public function delete_comments(int $userId)
    {
        $query = "UPDATE comment SET userId = 1 WHERE userId =:userId";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':userId', $userId);
        $result->execute();
    }

}