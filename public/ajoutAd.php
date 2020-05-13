<?php
session_start();
$authorId=$_SESSION['id'];
include '../src/Factory/DbAdaperFactory.php';
if(isset($_POST['title'],$_POST['description'],$_POST['keyWords'])){
    $connexion = (new DbAdaperFactory())->createService();
    $sql=
    <<<SQL
    INSERT INTO "ad" (title,description,authorId,keyWords, created_at,reportCounter,likes) VALUES (:title,:description,:authorId,:keyWords,NOW(),0,0)
SQL;
    }
    $req=$connexion->prepare($sql);
    $req->bindParam(":title",$_POST['title'],PDO::PARAM_STR);
    $req->bindParam(":description",$_POST['description'],PDO::PARAM_STR);
    $req->bindParam(":keyWords",$_POST['keyWords'],PDO::PARAM_STR);
    $req->bindParam(":authorId",$authorId);
    $req->execute();
    echo $_POST['keyWords'];
    header ('Location: /espace_membre.php');
    exit();
?>
