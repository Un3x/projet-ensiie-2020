<?php 
session_start();
set_include_path('.:'.$_SERVER['DOCUMENT_ROOT'].'/../src');
include_once "errors.php";
?>

<?php include_once "ViewPictures.php"?>

<?php include_once "View/Layout/head.php" ?>
</head>
<?php include_once "View/Layout/header.php"?>
<body>

<?php if (isset($_SESSION['username'])){
pp($_SESSION['image'],200,200,50);
echo "<h1 class=\"titre\">".$_SESSION['title']."</h1>";
echo "<form action=\"Forms/modifyUserCosmetics.php\" method=\"post\">";
echo '<div class="custom-select">';
echo "<label for=\"newTitle\">Title : </label>";
echo "<select id=\"newTitle\" name=\"cars\">";
choiceTitle();
echo "</select></div><br>";
$dbAdaper = (new DbAdaperFactory())->createService();
$images=$dbAdaper->prepare('SELECT IDimage,image FROM image WHERE xpNeeded <= :xp;');
$images->bindParam('xp',$_SESSION['xp']);
$images->execute();
$i=0;
foreach ($images as $image){
	echo '<span class="container">';
	choicePP($image['idimage'], $image['image'], 200, 200, 20);
	echo '<span class="checkmark"></span>';
	echo "</span>";	
	if($i%4 == 0){echo "<br>";}
	$i++;
 	}
	

echo "<input class=\"subPP\" type=\"submit\"  value=\"Apply change\">";
echo "</form>";
}
else
{
    connect_yourself();
    exit();
}
?>

</body>

