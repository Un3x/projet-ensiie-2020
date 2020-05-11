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

$userID=htmlspecialchars($_SESSION['id']);

if (isset($_POST['newImage'])){
	try {
        $newImage = htmlspecialchars($_POST['newImage']);
		$sql='UPDATE userCosmetics SET IDimage=:newImage WHERE id=:userID;';
		$stmt=$dbAdapter->prepare($sql);
		$stmt->bindParam('newImage', $newImage);
		$stmt->bindParam('userID', $userID);
		$stmt->execute();
		$_SESSION['image'] = $_POST['newImage'];
	}
	catch (PDOException $err){
		header('Location: ../index.php?error=sqlerror');
		exit();		
	}	
}

if (isset($_POST['newTitle'])){
	try {
        $newTitle = htmlspecialchars($_POST['newTitle']);
		$sql='UPDATE userCosmetics SET IDtitle= :newTitle WHERE id= :userID;';
		$stmt=$dbAdapter->prepare($sql);
		$stmt->bindParam('newTitle', $newTitle);
		$stmt->bindParam('userID',$userID);
		$stmt->execute();
		$_SESSION['title'] = $newTitle;
	}
	catch (PDOException $err){
		header('Location: ../index.php?error=sqlerror');
		exit();		
	}	
}
header('Location: /index.php');
?>
