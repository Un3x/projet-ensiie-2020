<?php session_start();
set_include_path('.:'.$_SERVER['DOCUMENT_ROOT'].'/../src');?>
<?php $_SESSION["username"] = "poupou";
 $_SESSION["title"] = "Titre 4";
 $_SESSION["image"] = "waifu4.png";
 $_SESSION["email"] = "jeanducu@gmail.fr";
?>
<?php include_once "../src/ViewPictures.php"?>

<?php include_once "View/Layout/head.php" ?>
</head>
<?php include_once "View/Layout/header.php"?>

<?php if (isset($_SESSION['username'])){
pp($_SESSION['image'],200,200,50);
echo "<h1 class=\"titre\">".$_SESSION['title']."</h1>";
echo "<form action=\"Forms/modifyUserCosmetics.php\" method=\"post\">";
echo '<div class="custom-select">';
echo "<label for=\"newTitle\">Title : </label>";
echo "<select id=\"newTitle\" name=\"cars\">";
choiceTitleDummy();
echo "</select></div><br>";
for ($i = 1; $i<=16; $i++){
	echo '<span class="container">';
	choicePP("waifu".$i.".png", 200,200,20);
	echo '<span class="checkmark"></span>';
	echo "</span>";	
	if($i%4 == 0){echo "<br>";}
 	}
	

echo "<input class=\"subPP\" type=\"submit\"  value=\"Apply change\">";
echo "</form>";
}
else { include_once "Forms/error.php";
}
?>

