<?php

set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

class DbAdaperFactory
{
    public function createService ()
    {
        $config = include 'config/config.php';
        return new \PDO(
            sprintf('pgsql:host=%s;dbname=%s', $config['db']['host'], $config['db']['dbname']),
            $config['db']['user'],
            $config['db']['password']
        );
    }
}
?>
