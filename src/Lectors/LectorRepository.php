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
        $lectorData = $this->dbAdapter->query('SELECT lector.id, ip, lector.port, username FROM lector JOIN "user" on lector.id="user".id');
        $lectors = [];
        foreach ($lectorData as $lectorDatum) {
            $lector = new Lector();
            $lector
                ->setId($lectorDatum['id'])
                ->setIP($lectorDatum['ip'])
                ->setPort($lectorDatum['port'])
                ->setUsername($lectorDatum['username']);
            $lectors[] = $lector;
        }
        return $lectors;
    }

    public function isLektor ($lectorId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare(
                'SELECT COUNT(*) 
                    FROM lector
                    WHERE id=:id;');
        $stmt->bindParam('id', $lectorId, \PDO::PARAM_INT);
        $stmt->execute();
        var_dump($stmt);
    }

    public function delete ($lectorId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "lector" where id = :lectorId');

        $stmt->bindParam('lectorId', $lectorId, \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function add ($id, $ip, $port)
    {
        $stmt=$this
            ->dbAdapter
                ->prepare('INSERT INTO "lector" (id, ip, port) VALUES (:id, :ip, :port)');
        $stmt->bindParam('id', $id, \PDO::PARAM_INT);
        $stmt->bindParam('ip', $ip, \PDO::PARAM_STR);
        $stmt->bindParam('port', $port, \PDO::PARAM_INT);
        $stmt->execute();
    }
}
