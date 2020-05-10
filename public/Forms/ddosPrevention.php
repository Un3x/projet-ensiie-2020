<?php
/* protect the waifus! */
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
$limitpmin=6; //number max of request the user can do in 20s

if (!isset($_SESSION['first_request']))
{
	$_SESSION['request']=0;
	$_SESSION['first_request']=$_SERVER['REQUEST_TIME'];
}

$_SESSION['request']++;

if ($_SESSION['request']>$limitpmin && ($_SERVER['REQUEST_TIME']-$_SESSION['first_request']<=30))
{
	$_SESSION['sleepState']=1;
}
if ($_SERVER['REQUEST_TIME']-$_SESSION['first_request']>30)
{
	$_SESSION['first_request']=$_SERVER['REQUEST_TIME'];
	$_SESSION['request']=0;
	$_SESSION['sleepState']=0;
}
echo $_SESSION['sleepState'];
echo "\n";
echo $_SESSION['request'];
echo "\n";
echo $_SERVER['REQUEST_TIME']-$_SESSION['first_request'];
?>
