<?php

namespace Factory;

class DbAdapterFactory
{
	private static $instance = null;
	
    public static function createService ()
    {
		if (DbAdapterFactory::$instance != null) return $instance;
		
        $config = include '../src/config/config.php';
		try
		{
			$instance = new \PDO(
				sprintf('pgsql:host=%s;dbname=%s',
					$config['db']['host'],
					$config['db']['dbname']),
				$config['db']['user'],
				$config['db']['password']
			);
			return $instance;
		}
		catch (\PDOException $e){
			echo 'Connexion échouée : ' . $e->getMessage();
		}
    }
}
