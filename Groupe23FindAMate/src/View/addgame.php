<?php

if (isset($_POST['valider'])){
    $gamename = strtolower(htmlspecialchars($_POST['gamename']));
    $description = htmlspecialchars($_POST['description']);
    $isFree = $_POST['isFree'];

    if($isFree == "1"){
        $dbAdapter = (new DbAdaperFactory())->createService();
        $gameRepository = new \src\Model\repository\GameRepository($dbAdapter);
        $gameRepository -> insert($gamename,1,$description);
        header('Location: index.php');
    }


    else if($isFree == "0"){
        $dbAdapter = (new DbAdaperFactory())->createService();
        $gameRepository = new \src\Model\repository\GameRepository($dbAdapter);
        $gameRepository -> insert($gamename,0,$description);
        header('Location: index.php');
    }

    else {
        $erreur = "Tout les champs doivent être remplis !";
        header('Location: game.php?erreur='.$erreur);
    }
    

}


?>