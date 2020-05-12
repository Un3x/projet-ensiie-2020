<?php

session_start();

if (isset($_SESSION['username']) && isset($_SESSION['password'])){
	echo '<html>';
	echo '<head>';
	echo '<title>Page de notre section membre</title>';
	echo '</head>';

	echo '<body>';
	echo 'Votre login est '.$_SESSION['username'].' et votre mot de passe est '.$_SESSION['password'].'.';
	echo '<br />';

	echo '<a href="./logout.php">Déconnection</a>';
}
else {
	echo 'Les variables ne sont pas déclarées.';
}
?>