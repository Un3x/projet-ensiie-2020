<?php session_start() ?>
<?php $_SESSION['username'] = "oui";
$_SESSION['waifu'] = "waifu12.png";
include_once "../../src/ViewPictures.php"
?>

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
	<body>
	
	<?php if (!(isset($_SESSION['username']))){
	include "error.php";
	}
	else {
		
		echo  "<header> <h1>  Profil de " . $_SESSION['username']. "</h1> </header>";
		pp($_SESSION['waifu'],200,200,50);
	}?>

	</body>
</html>
