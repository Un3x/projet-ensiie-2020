<?php

namespace Save;

class SaveRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }


    public function existSave(int $userId, int $storyId)
    {
        $query = "SELECT * FROM save WHERE userId=:userid AND storyId=:storyid";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':userid', $userId);
        $result->bondParam(':storyid', $storyId);
        return $result->rowCount >= 1;
    }
}