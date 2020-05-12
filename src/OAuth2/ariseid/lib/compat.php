<?php
if (!function_exists('http_build_url'))
{
    define('HTTP_URL_REPLACE', 1);              // Replace every part of the first URL when there's one of the second URL
    define('HTTP_URL_JOIN_PATH', 2);            // Join relative paths
    define('HTTP_URL_JOIN_QUERY', 4);           // Join query strings
    define('HTTP_URL_STRIP_USER', 8);           // Strip any user authentication information
    define('HTTP_URL_STRIP_PASS', 16);          // Strip any password authentication information
    define('HTTP_URL_STRIP_AUTH', 32);          // Strip any authentication information
    define('HTTP_URL_STRIP_PORT', 64);          // Strip explicit port numbers
    define('HTTP_URL_STRIP_PATH', 128);         // Strip complete path
    define('HTTP_URL_STRIP_QUERY', 256);        // Strip query string
    define('HTTP_URL_STRIP_FRAGMENT', 512);     // Strip any fragments (#identifier)
    define('HTTP_URL_STRIP_ALL', 1024);         // Strip anything but scheme and host

    // Build an URL
    // The parts of the second URL will be merged into the first according to the flags argument. 
    // 
    // @param   mixed           (Part(s) of) an URL in form of a string or associative array like parse_url() returns
    // @param   mixed           Same as the first argument
    // @param   int             A bitmask of binary or'ed HTTP_URL constants (Optional)HTTP_URL_REPLACE is the default
    // @param   array           If set, it will be filled with the parts of the composed url like parse_url() would return 
    function http_build_url($url, $parts=array(), $flags=HTTP_URL_REPLACE, &$new_url=false)
    {
        $keys = array('user','pass','port','path','query','fragment');

        // HTTP_URL_STRIP_ALL becomes all the HTTP_URL_STRIP_Xs
        if ($flags & HTTP_URL_STRIP_ALL)
        {
            $flags |= HTTP_URL_STRIP_USER;
            $flags |= HTTP_URL_STRIP_PASS;
            $flags |= HTTP_URL_STRIP_PORT;
            $flags |= HTTP_URL_STRIP_PATH;
            $flags |= HTTP_URL_STRIP_QUERY;
            $flags |= HTTP_URL_STRIP_FRAGMENT;
        }
        // HTTP_URL_STRIP_AUTH becomes HTTP_URL_STRIP_USER and HTTP_URL_STRIP_PASS
        elseif ($flags & HTTP_URL_STRIP_AUTH)
        {
            $flags |= HTTP_URL_STRIP_USER;
            $flags |= HTTP_URL_STRIP_PASS;
        }

        // Parse the original URL
        $parse_url = parse_url($url);

        // Scheme and Host are always replaced
        if (isset($parts['scheme']))
            $parse_url['scheme'] = $parts['scheme'];
        if (isset($parts['host']))
            $parse_url['host'] = $parts['host'];

        // (If applicable) Replace the original URL with it's new parts
        if ($flags & HTTP_URL_REPLACE)
        {
            foreach ($keys as $key)
            {
                if (isset($parts[$key]))
                    $parse_url[$key] = $parts[$key];
            }
        }
        else
        {
            // Join the original URL path with the new path
            if (isset($parts['path']) && ($flags & HTTP_URL_JOIN_PATH))
            {
                if (isset($parse_url['path']))
                    $parse_url['path'] = rtrim(str_replace(basename($parse_url['path']), '', $parse_url['path']), '/') . '/' . ltrim($parts['path'], '/');
                else
                    $parse_url['path'] = $parts['path'];
            }

            // Join the original query string with the new query string
            if (isset($parts['query']) && ($flags & HTTP_URL_JOIN_QUERY))
            {
                if (isset($parse_url['query']))
                    $parse_url['query'] .= '&' . $parts['query'];
                else
                    $parse_url['query'] = $parts['query'];
            }
        }

        // Strips all the applicable sections of the URL
        // Note: Scheme and Host are never stripped
        foreach ($keys as $key)
        {
            if ($flags & (int)constant('HTTP_URL_STRIP_' . strtoupper($key)))
                unset($parse_url[$key]);
        }


        $new_url = $parse_url;

        return 
             ((isset($parse_url['scheme'])) ? $parse_url['scheme'] . '://' : '')
            .((isset($parse_url['user'])) ? $parse_url['user'] . ((isset($parse_url['pass'])) ? ':' . $parse_url['pass'] : '') .'@' : '')
            .((isset($parse_url['host'])) ? $parse_url['host'] : '')
            .((isset($parse_url['port'])) ? ':' . $parse_url['port'] : '')
            .((isset($parse_url['path'])) ? $parse_url['path'] : '')
            .((isset($parse_url['query'])) ? '?' . $parse_url['query'] : '')
            .((isset($parse_url['fragment'])) ? '#' . $parse_url['fragment'] : '')
        ;
    }
}

// Needed in PHP5.3 and PHP5.4
// From https://github.com/rchouinard/hash_pbkdf2-compat
if (!function_exists('hash_pbkdf2'))
{
  function hash_pbkdf2($algo, $password, $salt, $iterations, $length = 0, $raw_output = false)
  {
      // Prep input arguments
      $algo       = (string)  isset($algo) ? $algo : null;
      $password   = (string)  isset($password) ? $password : null;
      $salt       = (string)  isset($salt) ? $salt : null;
      $iterations = (integer) isset($iterations) ? $iterations : null;
      $length     = (integer) $length;
      $raw_output = (boolean) $raw_output;
  
      // Recreate \hash_pbkdf2() error conditions
      $num_args = func_num_args();
      if ($num_args < 4) {
          trigger_error(sprintf('\%s() expects at least 4 parameters, %d given', __FUNCTION__, $num_args), E_USER_WARNING);
          return null;
      }
  
      if (!in_array($algo, hash_algos())) {
          trigger_error(sprintf('Unknown hashing algorithm: %s', $algo), E_USER_WARNING);
          return false;
      }
  
      if ($iterations <= 0) {
          trigger_error(sprintf('Iterations must be a positive integer: %d', $iterations), E_USER_WARNING);
          return false;
      }
  
      if ($length < 0) {
          trigger_error(sprintf('Length must be greater than or equal to 0: %d', $length), E_USER_WARNING);
          return false;
      }
  
      $salt_len = strlen($salt);
      if ($salt_len > PHP_INT_MAX - 4) {
          trigger_error(sprintf('Supplied salt is too long, max of PHP_INT_MAX - 4 bytes: %d supplied', $salt_len), E_USER_WARNING);
          return false;
      }
  
      // Algorithm implementation
      $hash_len = strlen(hash($algo, null, true));
      if ($length == 0) {
          $length = $hash_len;
      }
  
      $output = '';
      $block_count = ceil($length / $hash_len);
      for ($block = 1; $block <= $block_count; ++$block) {
          $key1 = $key2 = hash_hmac($algo, $salt . pack('N', $block), $password, true);
          for ($iteration = 1; $iteration < $iterations; ++$iteration) {
              $key2 ^= $key1 = hash_hmac($algo, $key1, $password, true);
          }
          $output .= $key2;
      }
  
      // Output the derived key
      // NOTE: The built-in \hash_pbkdf2() function trims the output to $length,
      // not the raw bytes before encoding as might be expected. I'm not a fan
      // of that decision, but it's emulated here for full compatibility.
      return substr(($raw_output) ? $output : bin2hex($output), 0, $length);
  }
}

if (!function_exists('hash_hkdf')) {
  // HKDF is supported by PHP 7.1.2 and onwards, try to recreate it by compat
  // key must be in raw bytes
  function hash_hkdf($algo, $ikm, $length = 0, $info = '', $salt = '') {
        // Prep input arguments
        $algo       = (string)  isset($algo) ? $algo : NULL;
        $ikm        = (string)  isset($ikm)  ? $ikm  : NULL;
        $length     = (integer) $length;
        $info       = (string)  $info;
        $salt       = (string)  $salt;

        // Recreate \hash_pbkdf2() error conditions
        $num_args = func_num_args();
        if ($num_args < 2) {
            trigger_error(sprintf('\%s() expects at least 2 parameters, %d given', __FUNCTION__, $num_args), E_USER_WARNING);
            return NULL;
        }
        else if ($num_args > 5) {
            trigger_error(sprintf('\%s() expects at most 5 parameters, %d given', __FUNCTION__, $num_args), E_USER_WARNING);
            return NULL;
        }

        if (!in_array($algo, hash_algos())) {
            trigger_error(sprintf('Unknown hashing algorithm: %s', $algo), E_USER_WARNING);
            return FALSE;
        }

        if (strlen($ikm) == 0) {
            trigger_error('Input keying material cannot be empty', E_USER_WARNING);
            return FALSE;
        }

        if ($length < 0) {
            trigger_error(sprintf('Length must be greater than or equal to 0: %d', $length), E_USER_WARNING);
            return FALSE;
        }

        $hash_len = strlen(hash($algo, NULL, TRUE));

        if ($length > 255 * $hash_len) {
            trigger_error(sprintf('Length must be lower than or equal to %d: %d', 255 * $hash_len, $length), E_USER_WARNING);
            return FALSE;
        }

        // Algorithm implementation
        if ($length == 0) {
            $length = $hash_len;
        }

        // Extract
        // If salt is '' we don't change it (see Test case 7 of RFC)
        if (!isset($salt)) {
          $salt = str_repeat("\0", $hash_len);
        }
        $prk = hash_hmac($algo, $ikm, $salt, TRUE);

        //echo "PRK: ", bin2hex($prk), "\n";

        // Expand
        $okm = '';
        $t = '';
        for ($index = 1; strlen($okm) < $length; $index++) {
            $t = hash_hmac($algo, $t . $info . chr($index), $prk, TRUE);
            $okm .= $t;
        }
        return substr($okm, 0, $length);
  }
}

if (!defined('OPENSSL_RAW_DATA')) {
  // If it is not defined we are in PHP5.3
  define('OPENSSL_RAW_DATA', TRUE);
}

// Introduced in PHP 5.4
if (!function_exists('http_response_code')) {
	function http_response_code($code = NULL) {
		static $lastcode = 200;
		if ($code !== NULL) {
			switch ($code) {
				case 100: $text = 'Continue'; break;
				case 101: $text = 'Switching Protocols'; break;
				case 200: $text = 'OK'; break;
				case 201: $text = 'Created'; break;
				case 202: $text = 'Accepted'; break;
				case 203: $text = 'Non-Authoritative Information'; break;
				case 204: $text = 'No Content'; break;
				case 205: $text = 'Reset Content'; break;
				case 206: $text = 'Partial Content'; break;
				case 300: $text = 'Multiple Choices'; break;
				case 301: $text = 'Moved Permanently'; break;
				case 302: $text = 'Moved Temporarily'; break;
				case 303: $text = 'See Other'; break;
				case 304: $text = 'Not Modified'; break;
				case 305: $text = 'Use Proxy'; break;
				case 400: $text = 'Bad Request'; break;
				case 401: $text = 'Unauthorized'; break;
				case 402: $text = 'Payment Required'; break;
				case 403: $text = 'Forbidden'; break;
				case 404: $text = 'Not Found'; break;
				case 405: $text = 'Method Not Allowed'; break;
				case 406: $text = 'Not Acceptable'; break;
				case 407: $text = 'Proxy Authentication Required'; break;
				case 408: $text = 'Request Time-out'; break;
				case 409: $text = 'Conflict'; break;
				case 410: $text = 'Gone'; break;
				case 411: $text = 'Length Required'; break;
				case 412: $text = 'Precondition Failed'; break;
				case 413: $text = 'Request Entity Too Large'; break;
				case 414: $text = 'Request-URI Too Large'; break;
				case 415: $text = 'Unsupported Media Type'; break;
				case 500: $text = 'Internal Server Error'; break;
				case 501: $text = 'Not Implemented'; break;
				case 502: $text = 'Bad Gateway'; break;
				case 503: $text = 'Service Unavailable'; break;
				case 504: $text = 'Gateway Time-out'; break;
				case 505: $text = 'HTTP Version not supported'; break;
				default:
					trigger_error('Unknown http status code "' . ((int)$code) . '"', E_USER_ERROR);
					break;
			}

			$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
			header($protocol . ' ' . $code . ' ' . $text, true, $code);
			$lastcode = $code;
		}
		return $lastcode;
	}
}

// Only needed in PHP 5.2 which we don't support anymore
/*
if (!function_exists('openssl_random_pseudo_bytes')) {
	function openssl_random_pseudo_bytes($length) {
		// get pseudorandom bits in a string

		$pr_bits = '';

		// Unix/Linux platform?
		$fp = @fopen('/dev/urandom','rb');
		if ($fp !== FALSE) {
			$pr_bits .= @fread($fp, $length);
			@fclose($fp);
		}

		// MS-Windows platform?
		if (@class_exists('COM')) {
			// http://msdn.microsoft.com/en-us/library/aa388176(VS.85).aspx
			try {
				$CAPI_Util = new COM('CAPICOM.Utilities.1');
				$pr_bits .= $CAPI_Util->GetRandom($length, 0);

				// if we ask for binary data PHP munges it, so we
				// request base64 return value.
				if ($pr_bits) { $pr_bits = base64_decode($pr_bits); }
			} catch (Exception $ex) {
				// echo 'Exception: ' . $ex->getMessage();
			}
		}

		if (strlen($pr_bits) < $length) {
			throw new Exception("Can't generate enough length");
		}

		return substr($pr_bits, 0, $length);
	}
}
*/
