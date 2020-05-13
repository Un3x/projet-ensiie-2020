<?php
include '../src/Factory/DbAdaperFactory.php';
if (isset($_POST['email'],$_POST['pwd'])){
        $connexion = (new DbAdaperFactory())->createService();
        $sql=
        <<<SQL
        SELECT COUNT(*) FROM "user" WHERE email=:email AND pwd=md5(:pwd)
SQL;
        $req=$connexion->prepare($sql);
        $req->bindParam(":email",$_POST['email'],PDO::PARAM_STR);
        $req->bindParam(":pwd",$_POST['pwd'],PDO::PARAM_STR);
        $req->execute();
        $req=$req->fetchAll();
        
        if ($req[0][0] == 1){
            session_start();
            session_regenerate_id(true);
            $sql1=
        <<<SQL
        SELECT id FROM "user" WHERE email=:email AND pwd=md5(:pwd)
SQL;
            $req1=$connexion->prepare($sql1);
            $req1->bindParam(":email",$_POST['email'],PDO::PARAM_STR);
            $req1->bindParam(":pwd",$_POST['pwd'],PDO::PARAM_STR);
            $req1->execute();
            $req1=$req1->fetch();
            $_SESSION['id']=$req1['id'];
            header('Location: /espace_membre.php');
            exit();}

        elseif ($req[0][0] == 0) {
            header( "refresh:2;url=/connexion.php" );
            echo 'Mauvais email ou mot de passe';}
        else {
            echo " plusieurs utilisateurs ont le meme mot de passe";
            header('Location: /connexion.php');
            exit();}
    }
else {
    header( "refresh:2;url=/connexion.php" );
    echo 'Mauvais email ou mot de passe'; 
    }

