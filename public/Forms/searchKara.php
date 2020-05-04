<?php
declare(strict_types=1);
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

require_once 'Factory/DbAdaperFactory.php';


function searchKara(string $str)
{
    $dbAdaper = (new DbAdaperFactory())->createService();
    $words = explode(" ", $str);
    $regex = "'.*";
    foreach ($words as $word)
    {
        $regex = $regex . $word . ".*|.*";
    }
    $regex = substr($regex, 0, -3);
    $regex = $regex . "'";

    $req =
        'SELECT DISTINCT song_name, song_type, song_number, source_name
         FROM "karas" 
         WHERE CONCAT_WS(\'||\', song_name, source_name, category) ~* ' . $regex . ';';
    $ret = $dbAdapter->query($req)->fetchAll(PDO::FETCH_NUM);

    return $ret;
}

$results = searchKara("g");
var_dump($results);
foreach ( $results as $result )
{
    /*
    echo $result . " - ";
     */
}

?>
