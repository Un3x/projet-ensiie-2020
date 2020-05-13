<?php

namespace Ad;

class AdRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll()
    {
        $adsData = $this->dbAdapter->query('SELECT * FROM "ad"');
        $ads = [];
        foreach ($adsData as $adsDatum) {
            $ad = new Ad();
            $ad
                ->setId($adsDatum['id'])
                ->setTitle($adsDatum['title'])
                ->setDescription($adsDatum['description'])
                ->setCreatedAt(new \DateTime($adsDatum['created_at']))
                ->setKeyWords((isset($adsDatum['keyWords'])) ?$adsDatum['keyWords'] : "" )
                ->setAuthorId((isset($adsDatum['authorId'])) ?$adsDatum['authorId'] : "" )
                ->setLikes($adsDatum['likes'])
                ->setReportCounter((isset($adsDatum['reportCounter'])) ? $adsDatum['reportCounter'] : "" );
            $ads[] = $ad;
        }
        return $ads;
    }
    
        

    public function delete ($adId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "ad" where id = :adId');
        $stmt->bindParam(':adId', $adId);
        $stmt->execute();
    }
    
    public function deleteAll ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "ad" where authorId = :userId');
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }
}
?>
