<?php

namespace Socket;

class SimpleSocket {
	protected $socket;
	protected $env;
	protected $data;
	protected $socket_error;
	
	public function __construct($env)
	{
		$this->env = $env;
		$this->data = null;
		
		require 'server_conf.php';
		$this->connectToSocketServer($server_conf['host'], $server_conf['port']);
	}
	
	// Se connecte au serveur de sockets
	private function connectToSocketServer($host, $port)
	{
		$this->socket = pfsockopen($host, $port, $errno, $errstr, 20);
		if (!$this->socket)
		{
			$this->computeError("Can't connect to socket server: ($errno) $errstr", 1, __FILE__, __LINE__, __FUNCTION__);
			return false;
		}
	}
	
	// Prépare les infos de connexion à envoyer au serveur de sockets
	public function prepareLoggingOnInfo()
	{
		$this->data = [
			'user' => $_SESSION['username'],
			'connect' => true,
		];
		return $this;
	}
	
	// Prépare les infos de déconnexion à envoyer au serveur de sockets
	public function prepareLoggingOffInfo()
	{
		$this->data = [
			'user' => $_SESSION['username'],
			'connect' => false,
		];
		return $this;
	}
	
	// Prépare la demande de listage des utilisateurs connectés
	public function prepareConnectedUsersListing()
	{
		$this->data = [
			'user' => $_SESSION['username'],
			'connect' => true,
			'listing' => true,
		];
		return $this;
	}
	
	// Prépare la demande de défis
	public function preparePlayAgainstUser($username)
	{
		$this->data = [
			'user' => $_SESSION['username'],
			'connect' => true,
			'challenge' => $username,
		];
		return $this;
	}
	
	// Prépare une partie seul
	public function preparePlayAlone()
	{
		$this->data = [
			'user' => $_SESSION['username'],
			'connect' => true,
			'alone' => true,
		];
		return $this;
	}
	
	// Prépare une partie seul
	public function prepareAloneMove($move)
	{
		$this->data = [
			'user' => $_SESSION['username'],
			'connect' => true,
			'alone_move' => $move,
		];
		return $this;
	}
	
	// Retourne les données préparées en JSON
	public function getJSON()
	{
		if ($json = json_encode($this->data))
			return $json;
		
		$this->computeError('Data has not been prepared.', 7, __FILE__, __LINE__, __FUNCTION__);
		return false;
	}
	
	// Envoie les infos préparées au serveur de sockets
	public function sendData()
	{
		if (!$this->socket)
			$this->computeError('Socket has not been connected to socket server!', 2, __FILE__, __LINE__, __FUNCTION__);
		else if ($json = json_encode($this->data))
		{
			// Envoi des données
			if (fwrite($this->socket, $json))
			{
				$this->data = null;
				return $this->getResponse();
			}
			else
				$this->computeError('Failed to send data to socket', 3, __FILE__, __LINE__, __FUNCTION__);
		}
		else
			$this->computeError('Failed to encode data', 4, __FILE__, __LINE__, __FUNCTION__);
		
		// Retourne false en cas d'erreur
		return false;
	}
	
	// Retourne la réponse du serveur de sockets après avoir envoyé des données
	public function getResponse()
	{
		$time = time();
		$response = "";
		while (true)
		{
			// On récupère caractères par caractère la réponse
			$line = fgetc($this->socket);
			if ($line == "\n") break;
			$response .= $line;
			
			if (time() - $time > 4)
			{
				$this->computeError('Time out, socket server isn\'t responding', 5, __FILE__, __LINE__, __FUNCTION__);
				return false;
			}
		}
		
		// Conversion en array PHP
		if ($array = json_decode($response, true))
			return $array;
		else
			$this->computeError('Socket server sent back wrong data', 6, __FILE__, __LINE__, __FUNCTION__);
			
		return false;
	}
	
	// Prépare l'erreur pour pouvoir ensuite l'afficher avec printError
	private function computeError($msg, $no, $file, $line, $function)
	{
		if ($this->env === 'dev' || $this->env === 'test')
		{
			$this->socket_error = "$msg: in $file in $function at line $line.\n";
		}
		else if ($this->env === 'prod')
		{
			if ($no == 1)
				$this->socket_error = "A problem occured in our services, unabled to see connected user list and to start games.\n";
			else
				$this->socket_error = "A error occured in our services...\n";
		}
	}
	
	// Retourne s'il y a eu une erreur
	public function hasErrorOccured()
	{
		return isset($this->socket_error);
	}
	
	// Affiche les erreurs qui peuvent survenir
	public function printError()
	{
		echo $this->socket_error;
		$this->socket_error = null;
	}
}

?>
