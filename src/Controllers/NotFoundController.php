<?php

namespace Controller;
require_once 'Controller.php';

class NotFoundController extends Controller
{
	public function get($params)
	{
		http_response_code(404);
		echo 'Page not found!';
	}

	public function post($params){}
}

?>
