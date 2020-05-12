<?php

namespace Repository;
include 'Repositories.php';
use \User\UserRepository;
use \Game\GameRepository;

class MainRepository
{
    private static $instance = null;
    
	private $userRepository;
	private $gameRepository;
	
	public function __construct()
	{
		// Instance unique de la classe pour un utilisateur
		if (MainRepository::$instance != null) return $instance;
		else $instance = $this;
		
		$this->userRepository = new UserRepository;
		$this->gameRepository = new GameRepository;
	}
	
	public function getUserRepository()
	{
		return $this->userRepository;
	}
	
	public function getGameRepository()
	{
		return $this->gameRepository;
	}
}

?>
