<?php
/******/
/*This file will allow the user to change his cosmetics.
/*These might be profile picture, title, maybe even his waifu (◡‿◡✿)
/*
 * the POST variables this files expects are 'userID', 'newImage' and 'newTitle' (soon newWaifu ??!!?!) 
/******/
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

use User\UserRepository;

include 'Users/User.php';
include 'Users/UserRepository.php';
include 'Factory/DbAdaperFactory.php';

$dbAdapter = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);

$userID=htmlspecialchars($_POST['userID']);

if (isset($_POST['newImage'])){
	try {
		$sql='UPDATE userCosmetics SET IDimage= :newImage WHERE id= :userID;';
		$stmt=dbAdapter->prepare($sql))
		$stmt->bindParam('newImage',$_POST['newImage']);
		$stmt->bindParam('userID',$userID);
		$stmt->execute();
	}
	catch (PDOException $err){
		header('Location: ../index.php?error=sqlerror');
		exit();		
	}	
}

if (isset($_POST['newTitle'])){
	try {
		$sql='UPDATE userCosmetics SET IDtitle= :newTitle WHERE id= :userID;';
		$stmt=dbAdapter->prepare($sql))
		$stmt->bindParam('newTitle',$_POST['newImage']);
		$stmt->bindParam('userID',$userID);
		$stmt->execute();
	}
	catch (PDOException $err){
		header('Location: ../index.php?error=sqlerror');
		exit();		
	}	
}
?>
