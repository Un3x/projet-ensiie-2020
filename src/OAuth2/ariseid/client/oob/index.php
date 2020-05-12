<?php
require_once("./config.oob.inc.php");
require_once("../OAuthAriseClient.php");

session_start();

$client = OAuthAriseClient::getInstance($consumer_key, $consumer_secret, "");

$client->set_callback('oob');

if (isset($_POST['logout'])) {
	$client->logout();
	unset($_SESSION['username']);
}

if (!$client->is_authenticated()) {
	if (isset($_POST['login'])) {
		do_display_link($client->get_authorize_uri());
		die();
	}
	elseif (isset($_POST['verifier'])) {
		$client->got_oob_verifier($_POST['verifier']);
	}
	else {
		do_login();
		die();
	}
}

// Passed this point we are authenticated
//if (!isset($_SESSION['oob_username'])) {
	$_SESSION['username'] = $client->api()->get_identifiant();
	$_SESSION['authorizations'] = $client->api()->get_authorizations();
//}

do_page($_SESSION['username'], $_SESSION['authorizations']);

function do_page($username, $authz) {
?>
<?php var_dump($username); ?>
<?php var_dump($authz); ?>
<form method='POST'>
<input type='submit' value='Log out' name='logout' />
</form>
<?php
}

function do_login() {
?>
<form method='POST'>
<input type='submit' value='Log In with AriseID' name='login' />
</form>
<?php
}

function do_display_link($link) {
?>
<p>Please go the the URL below and, once you have been authenticated, input in the field the verification code returned by AriseID</p>
<p><?php echo htmlspecialchars($link, ENT_COMPAT, 'UTF-8'); ?>
<form method='POST'>
<input type="text" name="verifier" />
<input type='submit' value='Validate' />
</form>
<?php
}
