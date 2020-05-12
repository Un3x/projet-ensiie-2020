<?php

namespace src\Model\repository;
use Entity\Search as Search;
class SearchRepository
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
        $searchsData = $this->dbAdapter->query('SELECT * FROM "search" ORDER BY "began_at" DESC');
        $searchs = [];
        foreach ($searchsData as $searchsDatum) {
            $search = new Search();
            $search
                ->setTitle($searchsDatum['title'])
                ->setPlayersToFind($searchsDatum['playerstofind'])
                ->setCreatedAt(new \DateTime($searchsDatum['began_at']))
                ->setUsername($searchsDatum['pseudo'])
                ->setGameName($searchsDatum['gamename'])
                ->setId($searchsDatum['searchid']);
            $searchs[] = $search;
        }
        return $searchs;
    }

    public function fetchLikeAll(string $gameName)
    {
        $sql="SELECT * FROM search WHERE gameName LIKE ? OR title LIKE ? ORDER BY began_at DESC";
        $searchsData=$this->dbAdapter->prepare($sql);
        $searchsData->execute(array("%".$gameName."%","%".$gameName."%"));
        $searchs = [];
        foreach ($searchsData as $searchsDatum) {
            $search = new Search();
            $search
                ->setTitle($searchsDatum['title'])
                ->setPlayersToFind($searchsDatum['playerstofind'])
                ->setCreatedAt(new \DateTime($searchsDatum['began_at']))
                ->setUsername($searchsDatum['pseudo'])
                ->setGameName($searchsDatum['gamename'])
                ->setId($searchsDatum['searchid']);
            $searchs[] = $search;
        }
        return $searchs;
    }

    //function insert(string $userName,string $createdAt,string $playersToFind,string $gameName,string $title)
    function insert(string $userName,string $playersToFind,string $gameName,string $title)
    {
       
        $sql="insert into search (pseudo,playersToFind,gameName,title,began_at) values (?,?,?,?,NOW())";
        $stmt=$this->dbAdapter->prepare($sql);
        $stmt->bindParam(1,$userName);
        // $stmt->bindParam(2,$createdAt);
        $stmt->bindParam(2,$playersToFind);
        $stmt->bindParam(3,$gameName);
        $stmt->bindParam(4,$title);
        $stmt->execute();  
        
     
    }

    public function delete ($SearchId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "search" where searchId = :SearchId');

        $stmt->bindParam('SearchId', $SearchId);
        $stmt->execute();
    }

    public function getInfo($SearchId)
    {
    $sql="SELECT * FROM search WHERE searchid = :searchid";
    $searchdata=$this->dbAdapter->prepare($sql);
    $searchdata->bindParam('searchid', $SearchId);
    $searchdata->execute();
    $searchs = [];
    foreach($searchdata as $searchdatum)
    {
        $search=new Search();
        $search
            ->setId($searchdatum['searchid'])
            ->setUsername($searchdatum['pseudo'])
            ->setCreatedAt($searchdatum['began_at'])
            ->setGameName($searchdatum['gamename'])
            ->setPlayersToFind($searchdatum['playerstofind'])
            ->setTitle($searchdatum['title']);
        $searchs [] =$search;
    }
    return $searchs;
    }
}