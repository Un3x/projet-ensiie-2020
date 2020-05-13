<?php

namespace NJV;

class NJVRepository
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
        $eventData = $this->dbAdapter->query('SELECT * FROM "njv"');
        $event = [];
        foreach ($eventData as $eventDatum) {
            $njv = new Njv();
            $njv
                ->setEdition($eventDatum['edition'])
                ->setJour($eventDatum['jour']);
            $event[] = $njv;
        }
        return $event;
    }
/*
    public function delete ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "user" where id = :userId');

        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }
    */
}