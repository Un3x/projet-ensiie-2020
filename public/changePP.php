<?php session_start();
set_include_path('.:'.$_SERVER['DOCUMENT_ROOT'].'/../src');?>

<?php include_once "../src/ViewPictures.php"?>

<?php include_once "View/Layout/head.php" ?>
<?php include_once "View/Layout/header.php"?>

<?php if (isset($_SESSION['username'])){

 for ($i = 1; $i<=16; $i++){
choicePP("waifu".$i.".png", 200,200,20);
	if($i%4 == 0){echo "<br>";}
	
 }
}
else { include_once "Forms/error.php";
}
?>

