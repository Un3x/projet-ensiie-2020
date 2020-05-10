<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

include_once 'Karas/searchKara.php';


include_once "View/Layout/head.php"; ?>
</head>

<body>
<?php include_once "View/Layout/header.php";

include_once "View/Layout/karaSearch.php";

if ( isset($_GET["language"]) && isset($_SESSION["id"]) )

{?>
    <h3>Here are your results</h3>
    <?php

    $names = array();
    $names[] = htmlspecialchars($_GET["song_name"]);
    $names[] = htmlspecialchars($_GET["source_name"]);
    $names[] = htmlspecialchars($_GET["author_name"]);
    $names[] = htmlspecialchars($_GET["language"]);
    $names[] = htmlspecialchars($_GET["song_type"]);
    $names[] = htmlspecialchars($_GET["is_new"]);

    $results = searchKaraByCriteria($names);

    echo "<ul>";
    if ( count($results) === 0 )
    {
        echo "No matches for your search";
    }
    else
    {
    foreach ($results as $result)
    {
        echo '<li>' . $result[0] . " - " . $result[1] . $result[2] . " - " . $result[3] . '</li>';
    }
    echo "</ul>";
    }
?>
<?php
}?>

</body>
</html>
