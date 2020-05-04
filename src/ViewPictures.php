<?php session_start() ?>


<?php
function pp($name, $height, $width,$border)
{
	
	echo "<a href=\"ChangePP.php\"><img style=\"border-radius:".$border."%;\" id=\"pp\" src=\"./Pictures/" .$name."\" alt=\"waifu\" height=".$height." width=".$width."> </a>" ;
}

function choicePP($name,$height, $width, $border) {
		
	echo "<input type=\"radio\" class=\"funky\" id=\"".$name."\" name=\"pp\" value=\"".$name."\">";
	echo "<img class=\"choice\" style=\"border-radius:".$border."%;\" id=\"pp\" src=\"./Pictures/" .$name."\" alt=\"waifu\" height=".$height." width=".$width.">" ;

}
?>
