<?php

namespace Com;

class ComRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbComapter = $dbAdapter;
    }

    public function fetchAll()
    {
        $comsData = $this->dbAdapter->query('SELECT * FROM "com"');
        $coms = [];
        foreach ($comsData as $comsDatum) {
            $com = new com();
            $com
                ->setId($comsDatum['id'])
                ->setText($comsDatum['text'])
                ->setCreatedAt(new \DateTime($comsDatum['created_at']))
                ->setAuthorId($comsDatum['authorId'])
                ->setLikes($comsDatum['likes'])
		->setTextId($comsDatum['textId'])
                ->setReportCounter($comsDatum['reportCounter']);
            $coms[] = $com;
        }
        return $coms;
    }

    public function delete ($comId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "com" where id = :comId');
        $stmt->bindParam('comId', $comId);
        $stmt->execute();
    }
}
