<?php
    if ($data['storyId'] != NULL)
        echo'
        <h4>Voici les résultats de votre recherche !</h4>
        <form method="get" action="story_page.php">
        <input type="hidden" name="storyId" value="'.$data['storyId'].'"/>
        <button type="submit" class="btn btn-link"><strong>'.$data['title'].'</strong>, '
        .$data['author'].'</button>
        </form>';
    else
        echo
        '<h4>Oups, c\'est difficile de chercher une histoire sans connaître son
        titre !</h4>
        <p>Attention à bien entrer le <b>titre exact et complet</b> de l\'histoire, en
        respectant les majuscules et les minuscules.
        (Nous sommes un peu pointilleux là-dessus...)';
?>