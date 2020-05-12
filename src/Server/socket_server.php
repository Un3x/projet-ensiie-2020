<?php

require "server_conf.php";
include "Morpiien.php";

if (($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) == FALSE)
{
	echo 'socket_create_listen() a échoué : '.socket_strerror(socket_last_error($socket)).'\n';
	exit(1);
}

// L'option SO_REUSEADDR à 1 permet de relier de nouveau une socket à un port en TIME_WAIT
if (!socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1))
{
	echo 'Impossible de définir l\'option du socket : '.socket_strerror(socket_last_error($socket)).'\n';
	exit(1);
}

if(socket_bind($socket, $server_conf['host'], $server_conf['port']) == FALSE)
{
	echo 'socket_bind() a échoué : '.socket_strerror(socket_last_error($socket)).'\n';
	exit(1);
}

if(socket_listen($socket)==FALSE)
{
	echo 'socket_listen() a échoué : '.socket_strerror(socket_last_error($socket)).'\n';
	exit(1);
}

echo "Listening on ${server_conf['host']}:${server_conf['port']}.\n";
echo "Ctrl-c to quit.\n";
socket_set_nonblock($socket);
$clients = [];
$sockets = [];
$alone_games = [];
while (TRUE)
{
	if ($c = socket_accept($socket))
	{
		// Passage en mode non bloquant de la socket du client
		socket_set_nonblock($c);
		// On ajoute la socket
		$hash = (int) $c;
		$sockets[$hash] = $c;
		//$status[$hash] = 'Disconnected';
		echo "Received a new connection from yet unknow user.\n";
	}
	
	// On parcourt la liste des clients connectés au serveur de sockets
	foreach ($sockets as $hash => $sock)
	{
		if ($buf = socket_read($sock, 5000))
		{
			$response = [
				'status' => 'KO',
			];
			
			if (!($data = json_decode($buf, true)))
			{
				echo "Error while parsing socket data: ".json_last_error().": ".json_last_error_msg()."\n";
			}
			else
			{
				$response['status'] = 'OK';
				if (isset($data['connect']))
				{
					if ($data['connect'])
					// Un utilisateur s'est authentifié, on l'ajoute donc
					{
						if (!isset($clients[$hash]))
						{
							echo "User authentificated: ${data['user']}\n";
							// Ajout de la socket cliente avec le nom de l'utilisateur
							$clients[$hash] = $data['user'];
						}
					}
					else
					{
						// Si l'utilisateur s'est déconnecté, on le retire
						echo "User disconnected: ${clients[$hash]}\n";
						unset($clients[$hash]);
					}
				}
				
				// Renvoie la liste des utilisateurs connectés à l'utilisateur
				if (isset($data['listing']) && $data['listing'] && isset($clients[$hash]))
				{
					echo "Listing connected users for ${clients[$hash]}\n";
					
					$connected_users = [];
					foreach ($clients as $hash_in => $users_in)
						$connected_users[$users_in] = $users_in;
					
					if (!empty($connected_users))
						$response['connected_users'] = $connected_users;
				}
				
				// Le joueur veut jouer seul
				if (isset($data['alone']))
				{
					echo "${clients[$hash]} wants to play alone!\n";
					$alone_games[$hash] = new \Morpiien($clients[$hash], "L'IA");
				}
				else if (isset($data['alone_move']))
				{
					// Déroulement de la partie
					echo "${clients[$hash]} has sent a move!\n";
					
					if ($alone_games[$hash]->isFinished() !== false)
						$response['valid_move'] = false;
					// On vérifie que le joueur peut jouer cela
					else if (!$alone_games[$hash]->player1Play($data['alone_move']))
						$response['valid_move'] = false;
					else
					{
						$response['valid_move'] = true;
						if (($who = $alone_games[$hash]->isFinished()) === false)
						{
							// Si le joueur n'a pas gagné on continue
							$response['ia_move'] = $alone_games[$hash]->AIPlay();
							if (($who = $alone_games[$hash]->isFinished()) === false)
								$response['finished'] = false;
							else
								$response['finished'] = $who;
						}
						else
						{
							// Le joueur a gagné donc on retourne le gagnant
							$response['finished'] = $who;
							$response['ia_move'] = 'NO';
						}
					}
				}
			}
			
			socket_write($sock, json_encode($response)."\n");
		}
		
		if ($sockets[$hash] == false)
		{
			// On efface les sockets fermées
			echo "Connection closed: user: $user\n";
			unset($sockets[$hash]);
			unset($clients[$hash]);
			unset($alone_games[$hash]);
		}
	}
	
	// Pour la consommation de resources c'est préférable
	usleep(500);
}

socket_close($socket);

?>
