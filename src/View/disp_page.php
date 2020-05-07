<?php
    /*Affichage de la page*/
    function dispPage($text, $choice1, $choice2, $choice3, $text1, $text2, $text3) {
        echo '<link rel="stylesheet" type="text/css" href="cite_des_voleurs.css">';
        
        echo '<div class="content">';
        echo '<strong style="font-size:36px">'.$text.'</strong>';
        echo '</div>';
        
        echo '<form method="post">';

        /*Dasn le cas où il n'y a pas de choix, c'est-à-dire qu'on est arrivé à la fin*/
        if ($text1 == null) {
            echo '<div class="text-block">';
            echo '<h4>Félicitations, vous avez terminé l\'histoire !</h4>';
            echo '<p>Vous pouvez maintenant aller en découvrir d\'autres parmi nos 
            propositions, ou bien rejouer celle-ci ! Après tout, il vous reste encore
            de nombreux choix à faire. Et qui dit que vous n\'obtiendrez pas une fin
            différente ?</p>';
            echo '</div>';
            echo '<button type="submit" class="bot-btn">Retourner au début de 
            l\'histoire.</button>';
        }

        /*Dans le cas où il y a deux choix*/
        else if ($text3 == null) {
            echo '<button type="submit" class="mid-btn" name="choice1" value="'
            .$choice1.'">'.$text1.'</button>';
            echo '<button type="submit" class="bot-btn" name="choice2" value="'
            .$choice2.'">'.$text2.'</button>';
        }

        /*Dans le cas où il y a trois choix*/
        else {
            echo '<button type="submit" class="top-btn" name="choice1" value="'
            .$choice1.'">'.$text2.'</button>';
            echo '<button type="submit" class="mid-btn" name="choice2" value="'
            .$choice2.'">'.$text2.'</button>';
            echo '<button type="submit" class="bot-btn" name="choice3" value="'
            .$choice3.'">'.$text3.'</button>';
        }
        echo '</form>';
    }
?>