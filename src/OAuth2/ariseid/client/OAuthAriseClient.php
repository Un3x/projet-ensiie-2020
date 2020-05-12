<?php

require_once(dirname(__FILE__) . "/OAuthClient.php");

class OAuthAPIException extends Exception {}

class OAuthAriseServiceConfig extends OAuthClientServiceConfig {
	protected static $oauth_request_token_uri = 'https://oauth.iiens.net/initiate.php';
	protected static $oauth_access_token_uri = 'https://oauth.iiens.net/token.php';
	protected static $oauth_authorize_uri = 'https://oauth.iiens.net/authorize.php';
	protected static $sig_method = NULL;

	public static function init() {
		static::$sig_method = new OAuthSignatureMethod_HMAC_SHA1();
	}
}
OAuthAriseServiceConfig::init();

class OAuthAriseClient {
	private $consumer;
	private $client;
	private $callback;
	private $cleanup_callback = TRUE;

	private $just_authenticated;

	private $consumer_private_key;

	private static $oauth_api_uri = 'https://oauth.iiens.net/api.php';
	private static $oauth_logout_uri = 'https://oauth.iiens.net/?page=logout&url=';

	private $caller;

	private function __construct($consumer) {
		$this->consumer = $consumer;
		$this->callback = NULL;
		$this->client = new OAuthClient($consumer, new OAuthAriseServiceConfig());

		$this->caller = new OAuthAPICaller($this);
	}

	/* This function shouldn't be called from outside */
	public function __sleep() {
		$vars = array_keys(get_object_vars($this));
		// Don't save the private key nor the caller
		return array_diff($vars, array("consumer_private_key", "caller"));
	}

	// We don't use __wakeup because at unserialize step we don't have the consumer set up
	private function wakeup() {
		if (isset($this->just_authenticated) && $this->just_authenticated > 0) {
			$this->just_authenticated--;
		}

		if(!$this->client->has_access_token()) {
			if (isset($_GET['oauth_token']) &&
				isset($_GET['oauth_verifier']) &&
				in_array($_GET['oauth_token'], $this->client->get_pending_request_tokens())) {

					if ($this->consumer_private_key !== "") {
						require_once(dirname(__FILE__) . "/../lib/crypto_basic.php");
						$ciphered_sid = ae_encrypt($this->consumer_private_key, session_id());
						if ($ciphered_sid === FALSE) {
							// Encryption must have failed because of invalid key
							// Don't die but don't provide clear-text session
							$ciphered_sid = NULL;
						}
					}
					else {
						$ciphered_sid = NULL;
					}
					$parameters = array("oauth_consumer_data" => $ciphered_sid);

					$this->client->ask_access_token($_GET['oauth_token'], $_GET['oauth_verifier'], $parameters);

					if ($this->cleanup_callback) {
						$this->just_authenticated = 2;

						$url = self::getScriptURL();
						$parts = parse_url($url);
						$query = $parts['query'];
						$params = explode('&', $query);
						$max = count($params);
						for($i = count($params) - 1; $i >= 0; $i--) {
							// Elements aren't shifted in the array when using unset
							if ((strncmp($params[$i], 'oauth_token=', strlen('oauth_token=')) === 0) ||
								(strncmp($params[$i], 'oauth_verifier=', strlen('oauth_verifier=')) === 0)) {
									unset($params[$i]);
							}
						}
						$query = implode('&', $params);
						$flags = HTTP_URL_REPLACE;
						if ($query == '') {
							$query = NULL;
							$flags |= HTTP_URL_STRIP_QUERY;
						}
						$url = http_build_url($url, array('query' => $query), $flags);
						http_response_code(303);
						header('Location: ' . $url);
						die();
					}
					else {
						$this->just_authenticated = 1;
					}

			}
		}
	}

	public function set_callback($callback) {
		$this->callback = $callback;
	}

	public function set_cleanup_callback($cleanup) {
		$this->cleanup_callback = $cleanup;
	}

	public function authenticate() {
		$callback = $this->callback;
		if ($callback === NULL) {
			$callback = self::getScriptURL();
		}

		$token = $this->client->ask_request_token($callback);
		http_response_code(303);
		header('Location: ' . $this->client->get_authorize_uri($token));
		die();
	}

	public function get_authorize_uri() {
		$token = $this->client->ask_request_token($this->callback);
		return $this->client->get_authorize_uri($token);
	}

	public function has_just_authenticated() {
		return $this->client->has_access_token() && 
			isset($this->just_authenticated) && 
			$this->just_authenticated > 0;
	}

	public function is_authenticated() {
		return $this->client->has_access_token();
	}

	public function session_id_changed() {
		if (!$this->is_authenticated()) {
			return;
		}

		if ($this->consumer_private_key === "") {
			return;
		}


		require_once(dirname(__FILE__) . "/../lib/crypto_basic.php");
		$ciphered_sid = ae_encrypt($this->consumer_private_key, session_id());
		if ($ciphered_sid === FALSE) {
			// Encryption must have failed because of invalid key
			// Don't change session id
			return;
		}

		$this->caller->set_consumer_data($ciphered_sid);
	}

	public function api() {
		return $this->caller;
	}

	/* This function shouldn't be called from outside */
	public function do_call_api($payload) {
		$data = json_encode($payload);

		if (!in_array('sha256', hash_algos(), TRUE)) {
			throw new Exception('SHA256 not supported by server version of PHP');
		}
		$hash = hash('sha256', $data, FALSE);

		$parameters = array('oauth_api_call_hash' => $hash);

		$stream = $this->client->create_authenticated_request('POST', self::$oauth_api_uri, $parameters,
			'application/json', $data);
		$reply = stream_get_contents($stream);
		if ($reply === FALSE) {
			throw new Exception("Error when calling API");
		}

		$payload = json_decode($reply, TRUE);
		if (!is_array($payload)) {
			throw new Exception("Error when calling API");
		}

		return $payload;
	}

	public function got_oob_verifier($verifier) {
		if(!$this->client->has_access_token()) {
			// We can't know the token related to this verifier : so we brute-force
			foreach($this->client->get_pending_request_tokens() as $token) {
				try {
					$this->client->ask_access_token($token, $verifier);
				}
				catch(OAuthException $e) {
				}
			}
			if (!$this->client->has_access_token()) {
				// No token matched the verifier : user is stupid
				throw new OAuthException('Invalid verifier code');
			}
		}
	}

	public function logout() {
		$this->client->clear_access_token();
		$this->client = new OAuthClient($this->consumer, new OAuthAriseServiceConfig());
	}

	static public function getInstance($consumer_key, $consumer_secret, $consumer_private_key) {
		$logout_requested = self::handleLogoutRequest($consumer_private_key);

		if (!isset($_SESSION))
			session_start();

		if (!isset($_SESSION['oauth_arise_clients'])) {
			$_SESSION['oauth_arise_clients'] = array();
		}
		if (!isset($_SESSION['oauth_arise_clients'][$consumer_key])) {
			$client = $_SESSION['oauth_arise_clients'][$consumer_key] = new OAuthAriseClient(new OAuthAriseConsumer($consumer_key, $consumer_secret));
		}
		else {
			$client = $_SESSION['oauth_arise_clients'][$consumer_key];
			$client->consumer->secret = $consumer_secret;
			$client->consumer_private_key = $consumer_private_key;
			// We reset the callback to be sure it's always the current page : it's more logic
			$client->callback = self::getScriptURL();
			// Recreate the caller
			$client->caller = new OAuthAPICaller($client);

			$client->wakeup();
		}


		if ($logout_requested) {
			$client->logout();
		}

		return $client;
	}

	static private function handleLogoutRequest($consumer_private_key) {
		if ($consumer_private_key === '') {
			return FALSE;
		}

		$headers = OAuthUtil::get_headers();
		// get_headers recapitalize headers names
		if (isset($headers['Oauthlogout'])) {
			$logout_information = OAuthUtil::parse_parameters($headers['Oauthlogout']);
			if (isset($logout_information['consumer_data'])) {
				require_once(dirname(__FILE__) . "/../lib/crypto_basic.php");
				$session_id = ae_decrypt($consumer_private_key, $logout_information['consumer_data']);
				if ($session_id === FALSE) {
					return FALSE;
				}

				// Destroy existing session as it must be a new one
				if (isset($_SESSION))
					session_destroy();

				session_id($session_id);
				session_start();
				// Don't disclose the session to the provider
				header_remove("Set-Cookie");
				return TRUE;
			}
		}
		return FALSE;
	}

	static public function get_single_logout_uri($return_uri) {
		return self::$oauth_logout_uri . urlencode($return_uri);
	}

	/**
	* Renvoie l'URL du script en cours d'exécution.
	*/
	static public function getScriptURL($with_query = TRUE)
	{
		$host = $_SERVER['SERVER_NAME'];
		$port = $_SERVER['SERVER_PORT'];
		if ($with_query) {
			$path = $_SERVER['REQUEST_URI'];
		}
		else {
			$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		}

		$ssl =  (
			isset($_SERVER['HTTPS']) &&
			$_SERVER['HTTPS'] == 'on'
		) ? 's' : '';

		if (($ssl != '' && $port == "443") ||
			(!$ssl && $port == "80"))
			$p = '';
		else $p = ':' . $port;

		$res = "http$ssl://$host$p$path";
		return $res;
    }
}

class OAuthAriseConsumer extends OAuthConsumer {
	public function __sleep() {
		$vars = array_keys(get_object_vars($this));
		// Don't save the secret
		return array_diff($vars, array("secret"));
	}
}

class OAuthAPICaller {
	private $client;
	private $batch = FALSE;
	private $batch_id_base;
	private $batch_id_current;
	private $batch_requests;

	public function __construct($client) {
		$this->client = $client;
	}

	public function begin() {
		$this->batch = TRUE;
		$this->batch_id_base = mt_rand();
		$this->batch_id_current = $this->batch_id_base;
		$this->batch_requests = array();

		return $this;
	}

	public function done() {
		if (!$this->batch) {
			trigger_error('done() shouldn\'t be called without a previous begin() call', E_USER_ERROR);
		}

		if (count($this->batch_requests) === 0) {
			return array();
		}

		$replies = $this->client->do_call_api($this->batch_requests);

		$ret = array();
		foreach($replies as $reply) {
			if (!isset($reply['id'])) {
				continue;
			}
			$id = $reply['id'] - $this->batch_id_base;

			if (isset($reply['error']['code'])) {
				$result = function () use ($reply) {
					throw new OAuthAPIException($reply['error']['message'], $reply['error']['code']);
				};
			}
			else {
				$result = function () use ($reply) {
					return isset($reply['result']) ? $reply['result'] : NULL;
				};
			}
			$ret[$id] = $result;
			$method = $this->batch_requests[$id]['method'];
			if (isset($method)) {
				$ret[$method] = $result;
			}
		}

		$this->batch_requests = NULL;
		$this->batch = FALSE;

		return $ret;
	}

	public function __call($name, $arguments) {
		$payload = array(
			'jsonrpc' => '2.0',
			'method' => $name);

		if (!empty($arguments)) {
			$payload['params'] = $arguments;
		}

		if ($this->batch) {
			$payload['id'] = $this->batch_id_current;

			$this->batch_requests[] = $payload;

			$this->batch_id_current = $this->batch_id_current + 1;

			// In batch mode we let user chain its calls
			return $this;
		}
		else {
			$payload['id'] = mt_rand();

			$reply = $this->client->do_call_api($payload);

			if (isset($reply['error']['code'])) {
				throw new OAuthAPIException($reply['error']['message'], $reply['error']['code']);
			}
			else {
				return isset($reply['result']) ? $reply['result'] : NULL;
			}
		}
	}
}
