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
        "SELECT DISTINCT song_name, song_type, song_number, source_name
         FROM \"karas\" 
         WHERE 
         song_name LIKE '%" . $names[0] . "%' AND
         source_name LIKE '%" . $names[1] . "%' AND
         author_name LIKE '%" . $names[2] . "%' AND
         language LIKE '%" . $names[3] . "%';";
    $ret = $dbAdapter->query($req)->fetchAll(PDO::FETCH_NUM);

    return $ret;
}

?>
