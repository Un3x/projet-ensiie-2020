<?php session_start();
set_include_path('.:'.$_SERVER['DOCUMENT_ROOT'].'/../src');?>

<?php
function pp($name, $height, $width,$border)
{
	
	echo "<img style=\"border-radius:".$border."%;\" class=\"pp\" src=\"/images/ProfilePictures/" .$name."\" alt=\"waifu\" height=".$height." width=".$width.">"  ;
}

function choicePP($name,$height, $width, $border) {
		
	echo "<input type=\"radio\" class=\"funky\" id=\"".$name."\" name=\"newImage\" value=\"".$name."\">";
	echo "<img class=\"choice\" style=\"border-radius:".$border."%;\" id=\"pp\" src=\"images/ProfilePictures/" .$name."\" alt=\"waifu\" height=".$height." width=".$width.">" ;
}

function choiceTitle(){
	include 'Factory/DbAdaperFactory.php';
	$dbAdaper = (new DbAdaperFactory())->createService();
	$titles=$dbAdaper->prepare('SELECT title FROM titles;');
	$titles->execute();

	foreach($titles as $title){
		echo "<option value=\"".$title['title']."\"";
			if ($_SESSION['title']==$title['title']){
				echo "selected=\"selected\">".$title['title']."</option>";
			}
			else{
				echo ">".$title['title']."</option>";
			}
	}       
	
}

function choiceTitleDummy(){

	$titles = ['Titre 1','Titre 2', 'Titre 3', 'Titre 4', 'Titre 5'];
	foreach($titles as $title){

		echo "<option value=\"".$title."\"";
			if ($_SESSION['title']==$title){
				echo "selected=\"selected\">".$title."</option>";
			}
			else{
				echo ">".$title."</option>";
			}
	}
}

function viewPP($name,$height, $width, $border) {
	echo "<img style=\"border-radius:".$border."%;\" id=\"pp\" src=\"images/ProfilePictures/" .$name."\" alt=\"waifu\" height=".$height." width=".$width.">" ;
}
?>
