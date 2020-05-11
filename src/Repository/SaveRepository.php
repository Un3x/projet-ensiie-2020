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


    public function existSave(int $userId, int $storyName)
    {
        $query = "SELECT * FROM saves WHERE userId=:userid AND storyName=:storyName";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':userid', $userId);
        $result->bondParam(':storyName', $storyName);
        $result->execute();
        return $result->rowCount >= 1;
    }

    public function fetchAll(int $userId)
    {
        $savesData = $this->dbAdapter->prepare('SELECT saveId, userId, title, storyId, pageId, skill, stamina, luck FROM saves NATURAL JOIN story WHERE userId=:userid');
        $savesData->bindParam(':userid', $userId);
        $savesData->execute();
        $saves = [];
        foreach ($savesData as $savesDatum) {
            $save = new Save();
            $save
                ->setId($savesDatum['saveid'])
                ->setUserId($savesDatum['userid'])
                ->setStoryTitle($savesDatum['title'])
                ->setStoryId($savesDatum['storyid'])
                ->setPageId($savesDatum['pageid'])
                ->setStamina($savesDatum['stamina'])
                ->setSkill($savesDatum['skill'])
                ->setLuck($savesDatum['luck']);
            $saves[] = $save;
        }
        return $saves;
    }

    public function updateSave(int $saveId, int $pageId, int $skill, int $stamina, int $luck)
    {
        $query = "UPDATE saves SET pageId=:pageid skill=:skill stamina=:stamina luck=:luck WHERE saveId = :saveid";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':pageid', $pageId);
        $result->bindParam(':skill', $skill);
        $result->bindParam(':stamina', $stamina);
        $result->bindParam(':luck', $luck);
        $result->bindParam(':saveid', $saveId);
        $result->execute();
        return TRUE;
    }

    public function addSave(int $userId, int $storyName, int $pageId, int $skill, int $stamina, int $luck)
    {
        $query = "INSERT INTO saves (userId, storyName, pageId, skill, stamina, luck) VALUES (:userid, :storyname, :pageid, :skill, :stamina, :luck";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':userid', $userId);
        $result->bindParam(':storyname', $storyName);
        $result->bindParam(':pageid', $pageId);
        $result->bindParam(':skill', $skill);
        $result->bindParam(':stamina', $stamina);
        $result->bindParam(':luck', $luck);
        $result->execute();
        return TRUE;
    }

    public function deleteAllSave(int $userId){
        $query = "DELETE FROM saves WHERE userId = :userid";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':userid', $userId);
        $result->execute();
        return TRUE;
    }

    public function deleteSave(int $saveId){
        $query = "DELETE FROM saves WHERE saveId = :saveid";
        $result = $this->dbAdapter->prepare($query);
        $result->bindParam(':saveid', $saveId);
        $result->execute();
        return TRUE;
    }
}