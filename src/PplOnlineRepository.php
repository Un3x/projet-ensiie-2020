<?php

namespace PplOnline;

class PplOnlineRepository
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
        $pplonlineData = $this->dbAdapter->query('SELECT * FROM "nb_online"');
        $pplonlines = [];
        foreach ($pplonlineData as $pplOnlineDatum) {
            $pplonline = new PplOnline();
            $pplonline
                ->setIp($pplOnlineDatum['ip'])
                ->setTime($pplOnlineDatum['ti']);
            $pplonlines[] = $pplonline;
        }
        return $pplonlines;
    }

    public function update()
    {
        $count = 0;
        $stmt = $this->dbAdapter->query('SELECT * FROM "nb_online"');
        foreach ($stmt as $pplOnlineDatum) {
            $count++;
        }
        return $count;
    }

    public function justConnected ()
    {
        $date = date("U");
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "nb_online" (ip, ti) VALUES (:ip, :ti)');
        $stmt->bindParam('ip', $ip);
        $stmt->bindParam('ti', $date);
        $stmt->execute();
    }

    public function justDisconnected ()
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "nb_online" where ip = :ip');
        $stmt->bindParam('ip', $ip);
        $stmt->execute();
    }
}