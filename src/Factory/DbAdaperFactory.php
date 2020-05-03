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
?>
