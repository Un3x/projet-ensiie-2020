<?php
include '../src/Factory/DbAdaperFactory.php';
if(isset($_POST['nom'],$_POST['prenom'],$_POST['pseudo'],$_POST['age'],$_POST['email'],$_POST['pwd1'],$_POST['pwd2'])){
    $connexion = (new DbAdaperFactory())->createService();
    $sql=
    <<<SQL
    SELECT COUNT(*) FROM "user" WHERE email=:email
SQL;
    $req=$connexion->prepare($sql);
    $req->bindParam(":email",$_POST['email'],PDO::PARAM_STR);
    $req->execute();
    $req=$req->fetchAll();
    print_r($req);
    if ($req[0][0]==0){
        $sql2=
        <<<SQL
        INSERT INTO "user" (username,fname,name,email,pwd, age, created_at,isAdmin) VALUES (:pseudo,:prenom,:nom,:email,md5(:pwd2),:age,NOW(),'false')
SQL;
        $req2=$connexion->prepare($sql2);
        $req2->bindParam(":email",$_POST['email'],PDO::PARAM_STR);
        $req2->bindParam(":pseudo",$_POST['pseudo'],PDO::PARAM_STR);
        $req2->bindParam(":prenom",$_POST['prenom'],PDO::PARAM_STR);
        $req2->bindParam(":nom",$_POST['nom'],PDO::PARAM_STR);
        $req2->bindParam(":pwd2",$_POST['pwd2'],PDO::PARAM_STR);
        $req2->bindParam(":age",$_POST['age'],PDO::PARAM_INT);
        $req2->execute();
        echo "oui";
        $sql1=
        <<<SQL
        SELECT id FROM "user" WHERE email=:email
SQL;
        $req1=$connexion->prepare($sql1);
        $req1->bindParam(":email",$_POST['email'],PDO::PARAM_STR);
        $req1->execute();
        $req1=$req1->fetch();
        echo $req1;
        session_start();
        $_SESSION['id']=$req1['id'];
        header ('Location: /espace_membre.php');
        exit();
    }
    else{
        $erreur="echec de l'inscription, cet email existe déjà";
        echo $erreur;
        header ('Location: /sinscrire.php');
        exit();
        }
    }
else{
    echo "erreur";
   header ('Location: /sinscrire.php');
    exit();
    }
