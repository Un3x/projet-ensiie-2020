<?php
require_once(dirname(__FILE__) . '/../lib/OAuth.php');
require_once(dirname(__FILE__) . '/../lib/compat.php');

class OAuthClientServiceConfig {
	protected static $oauth_request_token_uri = NULL;
	protected static $oauth_access_token_uri = NULL;
	protected static $oauth_authorize_uri = NULL;
	protected static $sig_method = NULL;

	public function getRequestTokenURI() {
		if (static::$oauth_request_token_uri === NULL) {
			throw new Exception("BUG: oauth_request_token_uri is NULL");
		}
		return static::$oauth_request_token_uri;
	}
	public function getAccessTokenURI() {
		if (static::$oauth_access_token_uri === NULL) {
			throw new Exception("BUG: oauth_access_token_uri is NULL");
		}
		return static::$oauth_access_token_uri;
	}
	public function getAuthorizeURI() {
		if (static::$oauth_authorize_uri === NULL) {
			throw new Exception("BUG: oauth_authorize_uri is NULL");
		}
		return static::$oauth_authorize_uri;
	}
	public function getSignatureMethod() {
		if (static::$sig_method === NULL) {
			throw new Exception("BUG: sig_method is NULL");
		}
		return static::$sig_method;
	}
}

class OAuthClient {
	private $consumer;
	private $service;

	private $request_tokens = array();
	private $access_token = NULL;

	public function __construct(OAuthConsumer $consumer, OAuthClientServiceConfig $service) {
		$this->consumer = $consumer;
		$this->service = $service;
	}

	public function ask_request_token($callback = NULL) {
		if ($callback === NULL || !is_string($callback)) {
			$callback = 'oob';
		}
		$parameters = array('oauth_callback' => $callback);
		$req_req = OAuthRequest::from_consumer_and_token($this->consumer, NULL, "POST", $this->service->getRequestTokenURI(), $parameters);
		$req_req->sign_request($this->service->getSignatureMethod(), $this->consumer, NULL);

		$stream = $this->do_request($req_req);
		$contents = stream_get_contents($stream);
		fclose($stream);

		if ($contents === FALSE) {
			throw new OAuthException("Error when getting request token");
		}

		$parameters = OAuthUtil::parse_parameters($contents);
		if (!isset($parameters['oauth_token']) || !isset($parameters['oauth_token_secret'])) {
			throw new OAuthException("Reply from service isn't complete: $contents");
		}
		if (!isset($parameters['oauth_callback_confirmed']) || $parameters['oauth_callback_confirmed'] !== 'true') {
			throw new OAuthException("Callback isn't confirmed");
		}
		
		$token = new OAuthToken($parameters['oauth_token'], $parameters['oauth_token_secret']);
		$this->request_tokens[$token->key] = $token;
		return $token;
	}

	public function get_pending_request_tokens() {
		return array_keys($this->request_tokens);
	}

	public function get_authorize_uri($request_token) {
		return http_build_url($this->service->getAuthorizeURI(), array('query' => 'oauth_token=' . $request_token->key), HTTP_URL_JOIN_QUERY);
	}

	public function ask_access_token($request_token_key, $access_verifier, $parameters = array()) {
		if (!isset($this->request_tokens[$request_token_key])) {
			throw new OAuthException("Unknown request token");
		}

		$request_token = $this->request_tokens[$request_token_key];

		$parameters = array_merge($parameters, array('oauth_verifier' => $access_verifier));
		$req_req = OAuthRequest::from_consumer_and_token($this->consumer, $request_token, "POST", $this->service->getAccessTokenURI(), $parameters);
		$req_req->sign_request($this->service->getSignatureMethod(), $this->consumer, $request_token);
		
		$stream = $this->do_request($req_req);
		$contents = stream_get_contents($stream);
		fclose($stream);

		if ($contents === FALSE) {
			throw new OAuthException("Error when getting access token");
		}

		$parameters = OAuthUtil::parse_parameters($contents);
		if (!isset($parameters['oauth_token']) || !isset($parameters['oauth_token_secret'])) {
			throw new OAuthException("Reply from service isn't complete");
		}

		// The request token is not valid anymore now
		unset($this->request_tokens[$request_token_key]);

		$this->access_token = new OAuthToken($parameters['oauth_token'], $parameters['oauth_token_secret']);
		return $this->access_token;
	}

	public function has_access_token() {
		return $this->access_token !== NULL;
	}

	public function clear_access_token() {
		$this->access_token = NULL;
	}
	
	public function create_authenticated_request($method, $uri, $parameters, $content_type = NULL, $content = NULL) {
		if ($this->access_token === NULL) {
			throw new OAuthException("Access token is not defined");
		}

		$req_req = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, $method, $uri, $parameters);
		if ($req_req->get_normalized_http_method() === 'POST' && $content_type === 'application/x-www-form-urlencoded') {
			foreach(OAuthUtil::parse_parameters($content) as $key => $param) {
				$req_req->set_parameter($key, $param);
			}
		}
		$req_req->sign_request($this->service->getSignatureMethod(), $this->consumer, $this->access_token);
		try {
			return $this->do_request($req_req, $content_type, $content);
		}
		catch(OAuthException $e) {
			$this->clear_access_token();
			throw $e;
		}
	}

	private function do_request($request, $content_type = NULL, $content = NULL) {
		$header = $request->to_header();
		if ($content_type) {
			$header = $header . "\r\nContent-Type: ${content_type}";
		}
		$opts = array('http' =>
				array(
					'method' => $request->get_normalized_http_method(),
					'header' => $header,
					'content' => $content,
					'ignore_errors' => TRUE,
				));
		$context = stream_context_create($opts);

		$stream = @fopen($request->get_normalized_http_url(), 'r', false, $context);

		if ($stream === FALSE) {
			throw new OAuthException("Can't connect to service");
		}

		$metadata = stream_get_meta_data($stream);

		$this->check_reply_error($metadata['wrapper_data'], $stream);

		// If we got here then no error has been encountered and we can pass the stream to the caller

		return $stream;
	}

	private function check_reply_error($headers, $stream) {
		$response_code = -1;
		$response_msg = "";
		foreach($headers as $line) {
			// We look at the last response line found to not treat redirections as errors
			if ( preg_match( '#^HTTP/[\d.]+ (\d+) (.*)$#', $line, $match ) ) {
				$response_code = (int) $match[1];
				$response_msg = $match[2];
			}
		}

		if ($response_code < 200 || $response_code > 299) {
			$response_content = stream_get_contents($stream);
			throw new OAuthException('Invalid reply from service: ' . $response_code . ' ' . $response_msg . "\n" . $response_content, $response_code);
		}

		return TRUE;
	}
}

