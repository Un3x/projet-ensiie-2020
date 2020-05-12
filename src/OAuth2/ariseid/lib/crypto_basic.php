<?php
if (!in_array('aes-128-cbc', array_map('strtolower', openssl_get_cipher_methods()), TRUE)) {
	trigger_error("Can't find aes-128-cbc cipher");
}

if (!in_array('sha256', array_map('strtolower', hash_algos()), TRUE)) {
	trigger_error("Can't find sha256 HMAC");
}

// key is 128 bits long
function ae_encrypt($key, $data) {
	// Get the Randoms
	$secure = FALSE;
	while(!$secure) {
		$iv = openssl_random_pseudo_bytes(16, $secure);
	}

	// We use the IV as a salt for the derivation function : I don't think it is risky but that's should be checked
	$key_cipher = hash_hkdf('sha256', $key, 16, 'cipher', $iv); // 16 = 128 bits
	if ($key_cipher === FALSE) {
		// There was an error and hash_hkdf already warned : just return FALSE
		return FALSE;
	}
	$key_hmac   = hash_hkdf('sha256', $key, 16, 'hmac', $iv); // 16 = 128 bits
	if ($key_hmac === FALSE) {
		// There was an error and hash_hkdf already warned : just return FALSE
		return FALSE;
	}
	
	$cipher_text = openssl_encrypt($data, 'aes-128-cbc', $key_cipher, OPENSSL_RAW_DATA, $iv);

	$to_mac_text = $iv . $cipher_text;

	$mac = hash_hmac('sha256', $to_mac_text, $key_hmac, TRUE);

	$result = base64_encode($mac . $to_mac_text);

	return $result;
}

function ae_decrypt($key, $data) {
	$data = base64_decode($data);
	if ($data === FALSE) {
		return FALSE;
	}

	// 64 = 32 + 16 + 16
	// 32 : size of sha256
	// 16 : size of IV
	// 16 : size of one AES block
	if (strlen($data) < 64) { // (32 + 16 + 16)
		return FALSE;
	}

	$mac = substr($data, 0, 32);
	$to_mac_text = substr($data, 32);

	$iv = substr($to_mac_text, 0, 16);
	$cipher_text = substr($to_mac_text, 16);
	
	$key_cipher = hash_hkdf('sha256', $key, 16, 'cipher', $iv); // 16 = 128 bits
	if ($key_cipher === FALSE) {
		// There was an error and hash_hkdf already warned : just return FALSE
		return FALSE;
	}
	$key_hmac   = hash_hkdf('sha256', $key, 16, 'hmac', $iv); // 16 = 128 bits
	if ($key_hmac === FALSE) {
		// There was an error and hash_hkdf already warned : just return FALSE
		return FALSE;
	}

	$real_mac = hash_hmac('sha256', $to_mac_text, $key_hmac, TRUE);

	$clear_text = openssl_decrypt($cipher_text, 'aes-128-cbc', $key_cipher, OPENSSL_RAW_DATA, $iv);

	// Don't check MAC before decryption to be immunized to timing attacks
	if (strlen($mac) != strlen($real_mac)) {
		return FALSE;
	}

	// Avoid a timing leak with a (hopefully) time insensitive compare
	$result = 0;
	for ($i = 0; $i < strlen($real_mac); $i++) {
		$result |= ord($real_mac{$i}) ^ ord($mac{$i});
	}
	if ($result != 0) {
		return FALSE;
	}

	# MAC is OK we can return clear text
	return $clear_text;
}
