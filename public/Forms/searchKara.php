<?php
declare(strict_types=1);
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

require_once 'Factory/DbAdaperFactory.php';


function searchKara(string $str)
{
    $dbAdaper = (new DbAdaperFactoryDepth())->createService();
    $words = explode(" ", $str);
    $regex = "'.*";
    foreach ($words as $word)
    {
        $regex = $regex . $word . ".*|.*";
    }
    $regex = substr($regex, 0, -3);
    $regex = $regex . "'";

    $req = 'SELECT DISTINCT song_name, song_type, song_number, source_name FROM "kara" WHERE CONCAT_WS(\'||\', song_name, source_name, category) ~* ' . $regex . ';';
    $ret = $dbAdaper->query($req)->fetch(PDO::FETCH_NUM);

    return $ret;
}

$results = searchKara("some il");
foreach ( $results as $result )
{
    echo $result . " - ";
}

?>
