<?php

namespace Controller;

include '../src/Repositories/MainRepository.php';
use \Repository\MainRepository;

abstract class Controller {
	protected $repositories;
	protected $socket;
	
	public function __construct()
	{
		$this->repositories = new MainRepository;
	}
	
    public function handle($params, $method)
    {
		if($this->IsUserConnected()==false){
            header("location: /login");
        }
		else{
            switch ($method)
            {
                case 'GET':
                    $this->get($params);
                    break;
                case 'POST':
                    $this->post($params);
                    break;
            }
        }
    }
    
    public function getMainRepository()
	{
		return $this->repositories;
    }
    
    /* Si l'utilisateur n'est pas connecté, il a accès seulement à la page login et register */
    public function IsUserConnected(){
        if ((isset($_SESSION["loggedin"]) == true )||($this instanceof RegisterController)||($this instanceof LoginController)){
            return true;
        }
        else {return false;}
    }
    
    public function setSocket($sock)
    {
		$this->socket = $sock;
	}

    abstract public function get($params);
    abstract public function post($params);
}

?>
