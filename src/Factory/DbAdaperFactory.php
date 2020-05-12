<?php

class DbAdaperFactory
{
    public function createService ()
    {
        $config = include '../config/config.php';
        return new \PDO(
            sprintf('pgsql:host=%s;dbname=%s', $config['db']['host'], $config['db']['dbname']),
            $config['db']['user'],
            $config['db']['password'],
              //throws exception or show error in case of a problem
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
}
