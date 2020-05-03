<?php

namespace Lector;

class LectorRepository
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
        $lectorData = $this->dbAdapter->query('SELECT * FROM "lector"');
        $lectors = [];
        foreach ($lectorData as $lectorDatum) {
            $lector = new Lector();
            $lector
                ->setId($lectorDatum['id'])
                ->setIP($lectorDatum['ip'])
                ->setPort($lectorDatum['port']);
            $lectors[] = $lector;
        }
        return $lectors;
    }

    public function delete ($lectorId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "lector" where id = :lectorId');

        $stmt->bindParam('lectorId', $lectorId);
        $stmt->execute();
    }
}
