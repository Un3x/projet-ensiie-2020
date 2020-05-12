<?php

include '../src/Ingame.php';
include '../src/IngameRepository.php';
include '../src/Map.php';
include '../src/Utilisateur.php';
include '../src/PplOnline.php';
include '../src/MapRepository.php';
include '../src/UtilisateurRepository.php';
include '../src/PplOnlineRepository.php';
include '../src/Factory/DbAdaperFactory.php';

session_start();
$dbAdaper = (new DbAdaperFactory())->createService();
$mapRepository = new \Map\MapRepository($dbAdaper);
$pplonlineRepository = new PplOnline\PplOnlineRepository($dbAdaper);
$utilisateurRepository = new \Utilisateur\UtilisateurRepository($dbAdaper);
$maps = $mapRepository->fetchAll();
$pplonlines = $pplonlineRepository->fetchAll();
$utilisateurs = $utilisateurRepository->fetchAll();
$gameRepository = new \Ingame\IngameRepository($dbAdaper);

$actualGame = $gameRepository->getGame();

$games = $gameRepository->fetchpplgame($actualGame->getId());

$mapgame = $mapRepository->selectmaps($actualGame->getMap1(), $actualGame->getMap2());

/*
if(isset($_SESSION['idmap1']) && isset($_SESSION['idmap2'])){
    $mapgame = $mapRepository->getmapbyid();
}
else{
    $mapgame = $mapRepository->selectmaps();
}
if(empty($_SESSION['timer'])){
    $_SESSION['timer'] = time();
}
else{
    unset($_SESSION['timer']);
    $delta = time() - $_SESSION['timer'];
  if($delta>60){
        header("Location: mapchoosed.php");
    }
}
$refreshafter = 60-$delta;
header("Refresh: ".$refreshafter);
*/

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>La Ligue des Deglingos</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Theau FERNANDEZ / Quentin JURY / Gabriel Meziere">
    <link rel="stylesheet" href="style.css?v=1.0">
</head>

<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Projet Web Ensiie 2020</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home</a>
                </li>
            </ul>
        </div>
    </nav>
</header>



 <table class="table" >
                <tr>
                    <th>Team</th>
                    <th>Pseudo</th>
                    <th>mdj</th>
                </tr>
                <?php foreach($games as $map){
                    if ($map->getTeam() == 1 ):                
                    ?>           
                    <tr>
                        <td class="team1"><?= $map->getTeam() ?></td>
                        <td class="team1"><?= $map->getPseudo() ?></td>
                        <td class="team1"><?= $map->getMdj() ?></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td class="team2"><?= $map->getTeam() ?></td>
                        <td class="team2"><?= $map->getPseudo() ?></td>
                        <td class="team2"><?= $map->getMdj() ?></td>
                    <?php endif; }?>
            </table>

<br/><br/>    

<?php 

$idmap1 ="images/map".$_SESSION['idmap1'].".jpg"; 
$idmap2 ="images/map".$_SESSION['idmap2'].".jpg"; 
$check1 = $_SESSION['check1']??null;
$check2 = $_SESSION['check2']??null;;
$check3 = $_SESSION['check3']??null;;

?>

<div class="vote">
<form method="POST" >
    <input class="toremove"type="radio" name="map" id="map1" value="Map1" checked=<?=$check1?>/>
   <label class ="map1" for="map1"><img id="pic1" src=<?=$idmap1?>></label>
   <input class="toremove" type="radio" name="map" id="map2" value="Map2"  checked=<?=$check2?>/>
   <label class="map2" for="map2"><img id="pic2" src=<?=$idmap2?>></label>
   <input class="toremove" type="radio" name="map" value="AutreMap" id="autremap" checked=<?=$check3?> />
   <label class="map3" for="autremap"><img id="pic3" src="images/autresmap.jpg"></label>
   <br/>
   <button type="submit" class="submitbutton"> Votez </button>
</form>
</div>
<?php
if (isset($_POST['map'])){
    if($_POST['map'] == "Map1"){
    $gameRepository->votemap($_SESSION['idmap1']);
    $_SESSION['check1'] = "checked";
    $_SESSION['check2'] = "";
    $_SESSION['check3'] = "";
    }
    else if($_POST['map'] == "Map2"){
    $gameRepository->votemap($_SESSION['idmap2']);
    $_SESSION['check2'] = "checked";
    $_SESSION['check1'] = "";
    $_SESSION['check3'] = "";
    }
    else if($_POST['map'] == "AutreMap"){
    $gameRepository->voteautre($actualGame->getId()); 
    $_SESSION['check3'] = "checked";
    $_SESSION['check1'] = "";
    $_SESSION['check2'] = "";
    }
}

?>




</body> 
</html>