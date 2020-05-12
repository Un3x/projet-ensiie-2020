<?php

namespace Rediite\Model\Factory;

class DbAdapterFactory
{
    public function createService ()
    {
	$db   = "ensiie";
	$host ="localhost";
	$mdp  ="ensiie";
	$user ="ensiie";
	$port=8080;
	return new \PDO("pgsql:dbname=$db;host=$host",$user,$mdp);
    }

}
