<?php

namespace Model\Factory;

class dbFactory
{

  function createService()
  {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    $config = include $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    return new \PDO(
      sprintf('%s:host=%s;dbname=%s;port=%s', $config['db']['type'], $config['db']['host'], $config['db']['dbname'], $config['db']['port']),
      $config['db']['user'],
      $config['db']['password']
    );
  }
}
