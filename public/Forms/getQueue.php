<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

include_once 'Factory/DbAdaperFactory.php';

if (/*isset($_GET["getQueue"])*/ true)
{
    $dbAdapter = (new DbAdaperFactory())->createService();
    $results = $dbAdapter->query('SELECT karas.source_name, karas.category, karas.song_number, karas.song_name FROM queue JOIN karas ON karas.id=queue.id ORDER BY queue.position ASC;')->fetchAll(PDO::FETCH_NUM);
    echo "<ul>";
    foreach ($results as $result)
    {
        echo "<li>" . $result[0] . " - " . $result[1] . $result[2] . " - " . $result[3] . "</li>";
    }
    echo "</ul>";
}

else
{
    echo "見ないで、バカ";
}
?>
