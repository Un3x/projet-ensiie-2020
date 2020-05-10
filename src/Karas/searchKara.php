<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

require_once 'Factory/DbAdaperFactory.php';


//$col : column to search for keywords
// -1 : default
//  0 : id
//  1 : song_name
//  2 : source_name
//  3 : category
//  4 : song_type
//  5 : song_number (disabled)
//  6 : language
//  7 : is_new
//  8 : author_name
function searchKara($str)
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

    $cols = 'CONCAT_WS(\'||\', song_name, source_name, category)';

    $req =
        'SELECT DISTINCT song_name, song_type, song_number, source_name
         FROM "karas" 
         WHERE ' . $cols . ' ~* ' . $regex . ';';
    $ret = $dbAdapter->query($req)->fetchAll(PDO::FETCH_NUM);

    return $ret;
}

function searchKaraByCriteria($names)
{
    $dbAdapter = (new DbAdaperFactory())->createService();


    $req =
        "SELECT DISTINCT song_name, song_type, song_number, source_name, id
         FROM \"karas\" 
         WHERE 
         song_name LIKE :n0 AND
         source_name LIKE :n1 AND
         author_name LIKE :n2";
    if ( $names[3] !== "all" )
        $req = $req . " AND language LIKE :n3";
        $n3 = "%" . $names[3] . "%";
    if ( $names[4] !== "all" )
        $req = $req . " AND song_type LIKE :n4";
        $n4 = "%" . $names[4] . "%";
    if ( $names[5] !== "Indifferent" )
    {
        if ( $names[5] === "Yes" )
            $req = $req . " AND is_new=1";
        elseif ( $names[5] === "No" )
            $req = $req . " AND is_new=0";
    }

    $n0 = "%" . $names[0] . "%";
    $n1 = "%" . $names[1] . "%";
    $n2 = "%" . $names[2] . "%";

    $ret = $dbAdapter->prepare($req);
    $ret->bindParam(':n0', $n0);
    $ret->bindParam(':n1', $n1);
    $ret->bindParam(':n2', $n2);
    if ( $names[3] !== "all" )
        $ret->bindParam(':n3', $n3);
    if ( $names[4] !== "all" )
        $ret->bindParam(':n4', $n4);

    $ret->execute();
    //$ret->fetchAll(PDO::FETCH_NUM);

    return $ret;
}

?>
