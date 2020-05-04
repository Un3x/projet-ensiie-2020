<?php session_start() ?>
<?php include_once "../../src/ViewPictures.php"?>
<html>
		
	<head>
		<meta charset="utf-8" />

<?php if (isset($_SESSION['username'])){
		echo "<title> Profil de " . $_SESSION['username']."</title>";
	}
	else{
		echo "<title> Profil non disponible</title>";
	}
?> 
	<link rel ="stylesheet" href="../style.css">
	

	</head>

<?php
echo "<form>";
for($i=1;$i<=16; $i++){

	$name = "waifu".strval($i).".png";
	if (($i - 1)%4 == 0 ) {echo "<br><br>";}
	choicePP($name,150,150,10);
	



}
?>
