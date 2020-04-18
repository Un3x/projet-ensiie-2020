<?php


class DbAdaperFactory
{
    public function createService ()
    {
        $config = include '../src/config/config.php';
        return new \PDO(
            sprintf('pgsql:host=%s;dbname=%s', $config['db']['host'], $config['db']['dbname']),
            $config['db']['user'],
            $config['db']['password']
        );
    }
}

//this class is only to be used in sub-sub-directories
//I created it because im a big flemmard
//Cordialement.
class DbAdaperFactoryDepth
{
    public function createService ()
    {
        $config = include '../../src/config/config.php';
        return new \PDO(
            sprintf('pgsql:host=%s;dbname=%s', $config['db']['host'], $config['db']['dbname']),
            $config['db']['user'],
            $config['db']['password']
        );
    }
}

?>
