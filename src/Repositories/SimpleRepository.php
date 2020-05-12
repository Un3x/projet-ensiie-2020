<?php

namespace Repository;
use \Factory\DbAdapterFactory;

abstract class SimpleRepository
{
    /**
     * @var \PDO
     */
    protected $dbAdapter;
    
    public function __construct()
    {
		$this->dbAdapter = DbAdapterFactory::createService();
	}

    public abstract function fetchAll();
    public abstract function delete ($id);
    public abstract function getByKey ($id);
}
