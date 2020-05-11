<?php
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
session_start();
use User\UserRepository;

include 'Lectors/Lector.php';
include 'Lectors/LectorRepository.php';
include 'Factory/DbAdaperFactory.php';

$errsCount=0;
$dbAdapter = (new DbAdaperFactory())->createService();
$LectorRepository = new \Lector\LectorRepository($dbAdapter);

//check validity of given userName

if (!isset($_SESSION['id'])){
	header('Location: ../login.php');
	exit();
}

if (isset($_SESSION['port'])){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else {
		$ip=$_SERVER['REMOTE_ADDR'];
	}

	$LectorRepository->add($_SESSION['id'],$ip,$_SESSION['port']);
	header('Location: ../index.php');
}


else {
	header('Location: ../index.php');
	exit();
}


?>
