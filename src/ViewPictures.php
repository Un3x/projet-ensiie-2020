<?php session_start();
set_include_path('.:'.$_SERVER['DOCUMENT_ROOT'].'/../src');?>

<?php
function pp($name, $height, $width,$border)
{
	
	echo "<a href=\"ChangePP.php\"><img style=\"border-radius:".$border."%;\" id=\"pp\" src=\"./Pictures/" .$name."\" alt=\"waifu\" height=".$height." width=".$width."> </a>" ;
}

function choicePP($name,$height, $width, $border) {
		
	echo "<input type=\"radio\" class=\"funky\" id=\"".$name."\" name=\"newImage\" value=\"".$name."\">";
	echo "<img class=\"choice\" style=\"border-radius:".$border."%;\" id=\"pp\" src=\"inc/Pictures/" .$name."\" alt=\"waifu\" height=".$height." width=".$width.">" ;

}
function choiceTitle(){
	include 'Factory/DbAdaperFactory.php';
	$dbAdaper = (new DbAdaperFactory())->createService();
	$titles=$dbAdaper->prepare('SELECT title FROM "title"');
	$titles=$dbAdaper->execute();
	foreach($titles as $title){
	       echo "<option value=\"".$title['title']."\">".$title['title']."<\option>";
	}       
	
}
?>
