<?php

require_once(dirname(__FILE__) . '/compat.php');
require_once(dirname(__FILE__) . '/crypto_basic.php');

// Test HKDF (using tests from RFC)
function test_hkdf($algo, $ikm, $salt, $info, $length, $expected) {
	$ikm = pack('H*', $ikm);
	$salt = pack('H*', $salt);
	$info = pack('H*', $info);
	$expected = pack('H*', $expected);

	$ret = hash_hkdf($algo, $ikm, $length, $info, $salt);

	//echo bin2hex($ret) . "\n";
	//echo bin2hex($expected) . "\n";

	return $ret === $expected;
}
// Test 1
var_dump(test_hkdf('sha256', '0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b', '000102030405060708090a0b0c', 
	'f0f1f2f3f4f5f6f7f8f9', 42, '3cb25f25faacd57a90434f64d0362f2a2d2d0a90cf1a5a4c5db02d56ecc4c5bf34007208d5b887185865'));
// Test 2
var_dump(test_hkdf('sha256', '000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f202122232425262728292a2b2c2d2e2f303132333435363738393a3b3c3d3e3f404142434445464748494a4b4c4d4e4f',
	'606162636465666768696a6b6c6d6e6f707172737475767778797a7b7c7d7e7f808182838485868788898a8b8c8d8e8f909192939495969798999a9b9c9d9e9fa0a1a2a3a4a5a6a7a8a9aaabacadaeaf',
	'b0b1b2b3b4b5b6b7b8b9babbbcbdbebfc0c1c2c3c4c5c6c7c8c9cacbcccdcecfd0d1d2d3d4d5d6d7d8d9dadbdcdddedfe0e1e2e3e4e5e6e7e8e9eaebecedeeeff0f1f2f3f4f5f6f7f8f9fafbfcfdfeff',
	82, 'b11e398dc80327a1c8e7f78c596a49344f012eda2d4efad8a050cc4c19afa97c59045a99cac7827271cb41c65e590e09da3275600c2f09b8367793a9aca3db71cc30c58179ec3e87c14c01d5c1f3434f1d87'));
// Test 3
var_dump(test_hkdf('sha256', '0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b', '', 
	'', 42, '8da4e775a563c18f715f802a063c5a31b8a11f5c5ee1879ec3454e5f3c738d2d9d201395faa4b61a96c8'));
var_dump(test_hkdf('sha256', '0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b', '', 
	NULL, 42, '8da4e775a563c18f715f802a063c5a31b8a11f5c5ee1879ec3454e5f3c738d2d9d201395faa4b61a96c8'));
// Test 4
var_dump(test_hkdf('sha1', '0b0b0b0b0b0b0b0b0b0b0b', '000102030405060708090a0b0c', 
	'f0f1f2f3f4f5f6f7f8f9', 42, '085a01ea1b10f36933068b56efa5ad81a4f14b822f5b091568a9cdd4f155fda2c22e422478d305f3f896'));
// Test 5
var_dump(test_hkdf('sha1', '000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f202122232425262728292a2b2c2d2e2f303132333435363738393a3b3c3d3e3f404142434445464748494a4b4c4d4e4f',
	'606162636465666768696a6b6c6d6e6f707172737475767778797a7b7c7d7e7f808182838485868788898a8b8c8d8e8f909192939495969798999a9b9c9d9e9fa0a1a2a3a4a5a6a7a8a9aaabacadaeaf',
	'b0b1b2b3b4b5b6b7b8b9babbbcbdbebfc0c1c2c3c4c5c6c7c8c9cacbcccdcecfd0d1d2d3d4d5d6d7d8d9dadbdcdddedfe0e1e2e3e4e5e6e7e8e9eaebecedeeeff0f1f2f3f4f5f6f7f8f9fafbfcfdfeff',
	82, '0bd770a74d1160f7c9f12cd5912a06ebff6adcae899d92191fe4305673ba2ffe8fa3f1a4e5ad79f3f334b3b202b2173c486ea37ce3d397ed034c7f9dfeb15c5e927336d0441f4c4300e2cff0d0900b52d3b4'));
// Test 6
var_dump(test_hkdf('sha1', '0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b', '', 
	'', 42, '0ac1af7002b3d761d1e55298da9d0506b9ae52057220a306e07b6b87e8df21d0ea00033de03984d34918'));
var_dump(test_hkdf('sha1', '0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b0b', '', 
	NULL, 42, '0ac1af7002b3d761d1e55298da9d0506b9ae52057220a306e07b6b87e8df21d0ea00033de03984d34918'));
// Test 7
var_dump(test_hkdf('sha1', '0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c', NULL, 
	'', 42, '2c91117204d745f3500d636a62f64f0ab3bae548aa53d423b0d1f27ebba6f5e5673a081d70cce7acfc48'));
var_dump(test_hkdf('sha1', '0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c0c', NULL, 
	NULL, 42, '2c91117204d745f3500d636a62f64f0ab3bae548aa53d423b0d1f27ebba6f5e5673a081d70cce7acfc48'));

// Test ae_(en|de)crypt

$secure = FALSE;
while(!$secure) {
  $key = openssl_random_pseudo_bytes(16, $secure);
}

$text = "Coucou c'est nous ! 01234567890123456789";

$cipher = ae_encrypt($key, $text);

echo $cipher . "\n";

$back = ae_decrypt($key, $cipher);

var_dump($back);
var_dump($back === $text);

$cipher[0] = chr((ord($cipher[0]) + 1) % 256);

echo $cipher . "\n";

$back = ae_decrypt($key, $cipher);

var_dump($back);
var_dump($back === $text);
