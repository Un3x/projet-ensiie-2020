<?php
require_once("../OAuthAriseClient.php");
require_once("./config.inc.php");

if (!isset($_SESSION)) {
	session_start();
}

$client = OAuthAriseClient::getInstance($consumer_key, $consumer_secret, $consumer_private_key);

if (isset($_POST['logout'])) {
	$client->logout();
}

if (!$client->is_authenticated()) {
	if (isset($_POST['login'])) {
		$client->authenticate();
	}
	else {
		do_login();
		die();
	}
}
// Passed this point we are authenticated
$results['authorizations'] = $client->api()->get_authorizations();

$caller = $client->api()->begin();
foreach($results['authorizations'] as $auth) {
	call_user_func(array($caller, $auth));
}

if ($client->has_just_authenticated()) {
	session_regenerate_id(TRUE);
	$client->session_id_changed();
}

$tmp = $caller->done();

foreach($tmp as $key => $value) {
	if (is_int($key)) {
		// Skip numeric indices and use only strings
		continue;
	}
	try {
		$results[$key] = $value();
	}
	catch(OAuthAPIException $e) {
		var_dump($e);
		$results[$key] = NULL;
	}
}

do_page($results);

function do_page($results) {
?>
<?php
	ob_start();
	var_dump($results);
	$dump = ob_get_clean();
	echo htmlentities($dump);
?>
<form method='POST'>
<input type='submit' value='Log out' name='logout' />
</form>
<a href="<?php echo OAuthAriseClient::get_single_logout_uri(OAuthAriseClient::getScriptURL(FALSE)); ?>">Logout from AriseID</a>
<?php
}

function do_login() {
?>
<form method='POST'>
<input type='submit' value='Log In with AriseID' name='login' />
</form>
<?php
}
