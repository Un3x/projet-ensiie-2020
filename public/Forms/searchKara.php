<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

include_once 'Karas/searchKara.php';

if ( isset($_GET["language"]) && isset($_SESSION["id"]) )
{

    include_once "View/Layout/head.php" ?>
    <body>
    <?php include_once "View/Layout/header.php" ?>

    <h3>Here are your results</h3>
    <p>Want to make <a href=/search.php>another one</a>?</p>

    <?php

    $names = array();
    $names[] = $_GET["song_name"];
    $names[] = $_GET["source_name"];
    $names[] = $_GET["author_name"];
    $names[] = $_GET["language"];

    $results = searchKaraByCriteria($names);

    echo "<ul>";
    foreach ($results as $result)
    {
        echo '<li>' . $result[0] . " - " . $result[1] . $result[2] . " - " . $result[3] . '</li>';
    }
    echo "</ul>";
?>
    <script src="/scripts/scripts.js"></script>
    </body>
    </html>
<?php
}

else
{
    echo "見ないで、バカ";
}
?>
