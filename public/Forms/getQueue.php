<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

include_once 'Factory/DbAdaperFactory.php';

if (isset($_GET["getQueue"]))
{

    $dbAdapter = (new DbAdaperFactory())->createService();
    $stmt =
        "SELECT karas.source_name, karas.category, karas.song_number, karas.song_name, karas.id
         FROM queue JOIN karas
            ON karas.id=queue.id
         ORDER BY queue.position ASC;";
    $results = $dbAdapter->query($stmt)->fetchAll(PDO::FETCH_NUM);
    echo "<ul>";
    foreach ($results as $result)
    {
        //if ( $_SESSION['rights'] === 0 ) // <-- FIXME : 3 checks + add isSetbefore
            echo '<form method="POST">';
        echo "<li>" . $result[0] . " - " . $result[1] . $result[2] . " - " . $result[3] . "</li>";
        //if ( $_SESSION['rights'] === 0 )
            echo '<button type="button" onclick="deleteKara(' . $result[4] . ')">Delete</button>';
        echo "</li>";
        //if ( $_SESSION['rights'] === 0 )
            echo "</form>";
    }
    echo "</ul>";
}

else
{
    echo "見ないで、バカ";
}
?>
