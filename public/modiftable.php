<?php

session_start();
include '../src/Factory/DbAdaperFactory.php';

if (isset($_POST['pseudo'])) {
    $userId=$_SESSION['id'];
    $connexion = (new DbAdaperFactory())->createService();
    $sql1=
    <<<SQL
    UPDATE "user" SET username=:pseudo WHERE id=:userId
SQL;
    $req=$connexion->prepare($sql1);
    $req->bindParam(":pseudo",$_POST['pseudo'],PDO::PARAM_STR);
    $req->bindParam(":userId",$userId);
    $req->execute();
    header('Location: /espace_membre.php');
    exit();}

if (isset($_POST['email'])) {
    $userId=$_SESSION['id'];
    $connexion = (new DbAdaperFactory())->createService();
    $sql2=
    <<<SQL
    UPDATE "user" SET email=:email WHERE id=:userId
SQL;
    $req2=$connexion->prepare($sql2);
    $req2->bindParam(":email",$_POST['email'],PDO::PARAM_STR);
    $req2->bindParam(":userId",$userId);
    $req2->execute();
    header('Location: /espace_membre.php');
    exit();
}


if (isset($_POST['pwd1'],$_POST['pwd2'])){
    if($_POST['pwd1']==$_POST['pwd2']){
        $userId=$_SESSION['id'];
        $connexion = (new DbAdaperFactory())->createService();
        $sql3=
        <<<SQL
        UPDATE "user" SET pwd=md5(:pwd1) WHERE id=:userId
SQL;
        $req3=$connexion->prepare($sql3);
        $req3->bindParam(":pwd1",$_POST['pwd1'],PDO::PARAM_STR);
        $req3->bindParam(":userId",$userId);
        $req3->execute();
        echo "votre mot de passe a bien été modifié, la page va se recharger dans 2 secondes";
        header( "refresh:2;url=/espace_membre.php" );
    }
    else{
        echo "les deux mots de passe ne correspondent pas, cette page va se recharger dans 2 secondes";
        header( "refresh:2;url=/espace_membre.php" );
    }
}

if (isset($_POST['adId'],$_POST['title'],$_POST['description'],$_POST['keyWords'])){
    $adId=$_POST['adId'];
    echo "oui0";
    $connexion = (new DbAdaperFactory())->createService();
    $sql4=
        <<<SQL
        UPDATE "ad" SET title=:title WHERE id=:adId
SQL;
        $req4=$connexion->prepare($sql4);
        $req4->bindParam(":title",$_POST['title'],PDO::PARAM_STR);
        $req4->bindParam(":adId",$adId);
        $req4->execute();
        echo "oui1";
    
    
        $sql5=
        <<<SQL
        UPDATE "ad" SET description=:description WHERE id=:adId
SQL;
        $req5=$connexion->prepare($sql5);
        $req5->bindParam(":description",$_POST['description'],PDO::PARAM_STR);
        $req5->bindParam(":adId",$adId);
        $req5->execute();
        echo "oui1";
        
        
        $sql6=
        <<<SQL
        UPDATE "ad" SET keyWords=:keyWords WHERE id=:adId
SQL;
        $req6=$connexion->prepare($sql6);
        $req6->bindParam(":keyWords",$_POST['keyWords'],PDO::PARAM_STR);
        $req6->bindParam(":adId",$adId);
        $req6->execute();
        echo "oui1";
        header('Location: /espace_membre.php');
        exit();
}




?>
