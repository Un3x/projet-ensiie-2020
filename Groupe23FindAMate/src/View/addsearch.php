<?php
$dbAdapter = (new DbAdaperFactory())->createService();
$searchRepository = new \src\Model\repository\SearchRepository($dbAdapter);


if (isset($_POST['submit']))
{
    $userName=htmlspecialchars($_SESSION['name']);
    $playersToFind=htmlspecialchars($_POST['playerstofind']);
    $gameName=strtolower(htmlspecialchars($_POST['jeu']));
    $title=htmlspecialchars($_POST['title']);
    if($_POST['jeu']=="err")
    {
        $err=1;
        header("location: createsearch.php?err=".$err."&nb=".$playersToFind."&title=".$title);
    }
    else{

    $searchRepository->insert($userName,$playersToFind,$gameName,$title);
    header('Location: allSearch.php');
    }
}
else
{
    header('Location: creasearch.php');
}
?>