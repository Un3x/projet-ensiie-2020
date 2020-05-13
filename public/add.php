<?php


require_once '../src/Factory/DbAdaperFactory.php';
require_once '../src/Repositories/AdRepository.php';
require_once '../src/Repositories/UserRepository.php';
require_once '../src/Entities/User.php';
require_once '../src/Entities/Ad.php';

?>
<head>
<?php include_once '../src/view/head.php' ?>
    <link rel="stylesheet" href="./css/connexion.css">
</head>

<?php include_once '../src/view/header.php'; ?>

<?php
$conn = (new DbAdaperFactory())->createService();
session_start();
if(isset($_POST['answer'])){
$sql=
<<<SQL
        INSERT INTO "com" (text,authorId, created_at,textId,likes) VALUES (:text,:authorId,NOW(),:adId,0)
SQL;
$req=$conn->prepare($sql);
$req->bindParam(":text",$_POST['answer'],PDO::PARAM_STR);
$req->bindParam(":authorId",$_SESSION['id'],PDO::PARAM_INT);
$req->bindParam(":adId",$_POST['ad'],PDO::PARAM_INT);
$req->execute();
}
?>

<?php

    // Récupère la recherche
    $ad =  isset($_POST['ad']) ? $_POST['ad'] : 1 ;


    // la requete mysql
    $sql= "SELECT title,username,description, \"ad\".created_at, likes, \"ad\".keyWords, \"ad\".id, \"user\".id AS usid
    FROM \"ad\" JOIN \"user\" ON \"user\".id=\"ad\".authorId
    WHERE \"ad\".id=:ad ";
    $sql2 = "SELECT username, text, \"com\".created_at, \"com\".likes
    FROM (\"ad\" LEFT OUTER JOIN \"com\" ON textId=\"ad\".id) JOIN \"user\" ON \"user\".id=\"com\".authorid
    WHERE \"ad\".id=:ad ";
    $q = $conn->prepare($sql);
    $q->bindParam(":ad", $ad,PDO::PARAM_STR);

    $q->execute();
    $q = $q->fetchAll(); ?>
    <body>
    <div class="row justify-content-center">
    <?php
    foreach($q as $r) { ?>
    <div class="card" style="width: 80rem;">

             <div class="card-body">
                 <h4 class="card-title"><?= $r['title'] ?></h4> <span> <br> <br><?php if (isset($_SESSION['id'])) { ?><form action="report.php" method="post" class="signalement">
                     <input class="form-control mr-sm-2" type="hidden" id="adId" name="adId" value="<?=  $r['id'] ?>">
                     <div class="d-flex justify-content-end"><button type="submit" class="btn btn-danger">Signaler</button></div>
                     </form> <?php }  ?> </span>
                 <form action="user.php" method="post" class="form-inline my-2 my-lg-0">
                     <input class="form-control mr-sm-2" type="hidden" id="user" name="user" value="<?=  $r['usid'] ?>">
                     <p><span class="card-title"><?= "par " ?></span><span><button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?= $r['username'] ?></button></span></p>
                     <?php $adId = $r['id']; ?>
                 </form>

                 <p class="card-text"><?= $r['description'] ?></p>
             </div>

        <ul class="list-group list-group-flush">
            <li class="list-group-item"><?= $r['created_at'] ?> </li>
            <li class="list-group-item"></li>
            <li class="list-group-item">Keywords : <span class="badge badge-secondary"><?=  $r['keywords'] ?></span> </li>
        </ul>
    <?php  }
    $q = $conn->prepare($sql2);
    $q->bindParam(":ad", $ad,PDO::PARAM_STR);

    $q->execute();
    $q = $q->fetchAll();
    if(count($q)!=0){
    foreach($q as $r) { ?>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><?= $r['username'] . " : " .  $r['text'] . " | Envoyé le " . $r['created_at'] ?> </li>
        </ul>


<?php  } } ?>
        <?php
        if (isset($_SESSION['id'])) {
        ?>
        <form action="" method="post" name="Formulaire">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <input type="text" class="form-control mr-sm-2" id="answer" name="answer" placeholder="Répondez !">
                    <input class="form-control mr-sm-2" type="hidden" id="ad" name="ad" value="<?= $ad ?>">
                </div>
            </div>
        </form>
        <?php }
        else { ?>
            <div class="col-md-6 mb-3">
                <br><br><br><br><br><br>
                Connectez-vous pour répondre !
            </div>
<?php } ?>
    </div>
    </div>
    </body>
<?php
include_once '../src/view/footer.php'; ?>
