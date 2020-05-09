<?php session_start();
set_include_path('.:'.$_SERVER['DOCUMENT_ROOT'].'/../src');?>
<?php $_SESSION["username"] = "poupou";
?>
<?php include_once "../src/ViewPictures.php"?>

<?php include_once "View/Layout/head.php" ?>
<?php include_once "View/Layout/header.php"?>

<?php if (isset($_SESSION['username'])){
echo "<form action=\"Forms/modifyUserCosmetics.php\" method=\"post\">";
echo "<label for=\"newTitle\">Titre : </label>";
echo "<select id=\"newTitle\" name=\"cars\">";
choiceTitleDummy();
echo "</select><br>";
 for ($i = 1; $i<=16; $i++){
choicePP("waifu".$i.".png", 200,200,20);
if($i%4 == 0){echo "<br>";}
 }
	

echo "<input class=\"subPP\" type=\"submit\"  value=\"Appliquer les changements\">";
echo "</form>";
}
else { include_once "Forms/error.php";
}
?>

