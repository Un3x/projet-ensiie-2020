<?php


$header="MIME-Version: 1.0\r\n";
$header.='From:"AllezRetour.fr"<allezretour@gmail.com>'."\n";
$header.='Content-Type:text/html; charset="uft-8"'."\n";
$header.='Content-Transfer-Encoding: 8bit';

$message='
<html>
	<body>
		<div align="center">
			Envoie du mail
	</body>
<html>
';
mail('allezretourevry@gmail.com', $message, $header);

?>