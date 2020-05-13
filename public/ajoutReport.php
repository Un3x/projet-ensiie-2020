<?php
include_once '../src/Factory/DbAdaperFactory.php';
$conn = (new DbAdaperFactory())->createService();
session_start();
$authorId=$_SESSION['id'];
if(isset($_POST['text'])){
    $conn = (new DbAdaperFactory())->createService();
    $sql=
        <<<SQL
        INSERT INTO "report" (text, authorId, created_at, textId) VALUES (:text,:authorId,NOW(),:textId);
SQL;
    $req=$conn->prepare($sql);
    $req->bindParam(":text",$_POST['text'],PDO::PARAM_STR);
    $req->bindParam(":authorId",$_SESSION['id'],PDO::PARAM_INT);
    $req->bindParam(":textId", $_POST['textId'],PDO::PARAM_INT);
    $req->execute();
    
    $sql2=
        <<<SQL
        SELECT reportCounter WHERE textId=:textId
SQL;
    $req2=$conn->prepare($sql2); 
    $req2->bindParam(":textId", $_POST['textId'],PDO::PARAM_INT);
    $req2->execute();
    $req2=$req2->fetch();
    $req2=$req2['reportcounter']+1;
    
    $sql3=
        <<<SQL
        UPDATE "ad" SET reportCounter=:req2 WHERE id=:textId
SQL;
        $req3=$conn->prepare($sql3);
        $req3->bindParam(":req2",$req2,PDO::PARAM_INT);
        $req3->bindParam(":textId",$_POST['textId'],PDO::PARAM_INT);
        $req3->execute();
        header( "Location:/index.php" );
        exit();
}
?>
