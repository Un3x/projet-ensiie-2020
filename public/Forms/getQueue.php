<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

include_once 'Factory/DbAdaperFactory.php';

if ( isset($_GET["getQueue"]) && isset($_SESSION["id"]) )
{

    $dbAdapter = (new DbAdaperFactory())->createService();

    if ( $_SESSION['rights'] >= 1 ) // User is an admin or root
    {
        $stmt =
            "SELECT karas.source_name, karas.category, karas.song_number, karas.song_name, karas.id
             FROM queue JOIN karas
                ON karas.id=queue.id
             ORDER BY queue.position ASC;";
        $results = $dbAdapter->query($stmt)->fetchAll(PDO::FETCH_NUM);

        echo "<ul>";
        foreach ($results as $result)
        {
            echo '<li><form method="POST">'
                . $result[0] . " - " . $result[1] . $result[2] . " - " . $result[3] .
                '<button type="button" onclick="deleteKara(' . $result[4] . ')">Delete</button>
                </form></li>';
        }
        echo "</ul>";
    }

    else // User is a peasant
    {
        $stmt =
            "SELECT karas.source_name, karas.category, karas.song_number, karas.song_name
             FROM queue JOIN karas
                ON karas.id=queue.id
             ORDER BY queue.position ASC;";
        $results = $dbAdapter->query($stmt)->fetchAll(PDO::FETCH_NUM);

        echo "<ul>";
        foreach ($results as $result)
        {
            echo '<li>"' . $result[0] . " - " . $result[1] . $result[2] . " - " . $result[3] . '</li>';
        }
        echo "</ul>";
    }
}

else
{
    echo "見ないで、バカ";
}
?>
