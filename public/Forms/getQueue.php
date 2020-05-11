<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

include_once 'Factory/DbAdaperFactory.php';
include_once 'ViewPictures.php';

if ( isset($_GET["getQueue"]) && isset($_SESSION["id"]) )
{

    $dbAdapter = (new DbAdaperFactory())->createService();

    $stmt =
        'SELECT karas.source_name, karas.category, karas.song_number, karas.song_name, karas.id, "user".username, userCosmetics.IDimage
         FROM queue JOIN karas
            ON karas.id=queue.id
            JOIN "user" ON queue.added_by="user".id
            JOIN userCosmetics ON userCosmetics.id="user".id
         ORDER BY queue.position ASC;';
    $results = $dbAdapter->query($stmt)->fetchAll(\PDO::FETCH_NUM);

    if ( $_SESSION['rights'] >= 1 ) // User is an admin or root
    {
        echo "<ul>";
        foreach ($results as $result)
        {
            echo '<li>';
            echo '<button type="button" onclick="deleteKara(' . $result[4] . ')">Delete</button>';
            echo $result[0] . " - " . $result[1] . $result[2] . " - " . $result[3];
            echo '<span id="queueAdder">';
            echo $result[5];
            viewPP("waifu$result[6].png", 50, 50, 5);
            echo '</span>';
            echo '</li>';
        }
        echo "</ul>";
    }

    else // User is a peasant
    {
        echo "<ul>";
        foreach ($results as $result)
        {
            echo '<li>';
            viewPP("waifu$result[6].png", 50, 50, 5);
            echo $result[0] . " - " . $result[1] . $result[2] . " - " . $result[3] . " {" . $result[5] . "}";
            echo "</li>";
        }
        echo "</ul>";
    }
}

else
{
    echo "見ないで、バカ";
}
?>
