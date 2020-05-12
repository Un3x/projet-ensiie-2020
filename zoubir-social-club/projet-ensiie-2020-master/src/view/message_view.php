<?php

    function print_message_header($nom, $prenom) 
    {
	    echo "

		<div class=\"centrer\">
		<div class=\"printMessage\">
	        <p>$prenom $nom a écrit:</p>
	        <table>";
    }

function print_content($content) {
		   echo "
		<tr>
			<td>$content</td>
		</tr>";
}

function print_message_closer($date,$id_mess,$id_pers,$nb_likes,$isLiked,$writer) {
	if ( ((isset($_SESSION['is_admin'])) & ($_SESSION['is_admin']==1)) 
			|| ($_SESSION['n_pers']) == $id_pers )
	{
		echo "
				</table>
				<p> Ecrit le $date</p>
				<p> A été like $nb_likes fois </p>
				</div>
					<form action='gestionSuppressionMessage.php' method=\"post\" >
						<p class=\"suppression\">
						<br>
						<input class=\"input_delete\" type=\"hidden\" 
										size=\"3\" maxlength=\"4\" id=\"message_delete\"  
										 name=\"message_delete\" value = ".$id_mess."
						<br>
						<button type=\"submit\" id=\"submit\" value =  ".$id_mess." > Supprimer</button>
						</form>
							";
						
	}
	else
	{
		echo "
				</table>
				<p> Ecrit le $date</p>
				<p> A été like $nb_likes fois </p>
				</div>
				";
	}
	echo "<form action='gestionLike.php' method=\"post\" >";
	if ($isLiked=="no")
	{
		echo "
		<button type=\"submit\" id=\"submit2\" name=\"like\" value = ".$id_mess." > Liker </button>";
	}
	else
	{
		if ($_SESSION['n_pers']==$writer || $isLiked=="yes")
		{
			echo "
			<button type=\"submit\" id=\"submit3\" 
				name = \"unlike\" value=".$id_mess." > Unlike </button>";

			echo "</div>";
		}
		else
		{
			echo "
			<button type=\"submit\" id=\"submit2\" name=\"like\" value = ".$id_mess." > Liker </button>";
		}
		
	}
			
}

?>
