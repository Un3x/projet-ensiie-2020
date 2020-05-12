<?php

namespace Controller;
require_once 'Controller.php';

class HomeController extends Controller
{
	public function get($params)
	{
		$viewPath = __VIEWROOT__.'/html';
		
		/* Checks $params (for example if($params['lang'] == 'fr')
		 * or if(isset($params['someAttribute']) ))
		 */
		
		$this->socket->prepareConnectedUsersListing();
		if (!($connected_users = $this->socket->sendData()))
			$this->socket->printError();
		
		$title = 'Accueil'; // Pour la vue
		include $viewPath.'/home.php';
	}

	public function post($params)
	{
		// Checks $params
		// require some view to display (in public/html)
	}
}

?>
