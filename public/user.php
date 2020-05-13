<?php

require_once '../src/Factory/DbAdaperFactory.php';
require_once '../src/Entities/User.php';
require_once '../src/Entities/Ad.php';

include_once '../src/view/head.php';
include_once '../src/view/header.php'; ?>

<?php
$conn = (new DbAdaperFactory())->createService();
session_start();
$authorId=$_SESSION['id'];
?>

<?php
// Récupère la recherche
$user =  isset($_POST['user']) ? $_POST['user'] : 1 ;


// la requete mysql
$sql="SELECT username,fname, \"user\".name,age,keyWords,id
    FROM \"user\" 
    WHERE \"user\".id=:user ";
$sql2 = "SELECT title, description, \"ad\".created_at, \"ad\".keyWords, \"ad\".id
    FROM \"user\" JOIN \"ad\" ON authorId=\"user\".id 
    WHERE \"user\".id=:user";
$q = $conn->prepare($sql);
$q->bindParam(":user", $user,PDO::PARAM_STR);

$q->execute();
$q = $q->fetchAll();
foreach($q as $r) { ?>
    <div class="card" style="width: 80rem;">
        <div class="card-body">
            <p class="card-text"><?= $r['username'] ?></p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><?= $r['fname'] . " " . $r['name'] . ", " . $r['age'] . " ans." ?> </li>
            <li class="list-group-item">Keywords : <span class="badge badge-secondary"><?=  $r['keywords'] ?></span> </li>
        </ul>
    </div>
<?php  }
$q = $conn->prepare($sql2);
$q->bindParam(":user", $user,PDO::PARAM_STR);

$q->execute();
$q = $q->fetchAll();
foreach($q as $r) { ?>
    <div class="card" style="width: 80rem;">
        <div class="card-body">
            <h5 class="card-title"><?= $r['title'] ?></h5>

            <p class="card-text"><?= $r['description'] ?></p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><?= $r['created_at'] ?> </li>
            <li class="list-group-item">Keywords : <span class="badge badge-secondary"><?=  $r['keywords'] ?></span> </li>
        </ul>
        <div class="card-body">
            <form action="add.php" method="post" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="hidden" id="ad" name="ad" value="<?=  $r['id'] ?>">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Aller voir l'annonce !</button>
            </form>
        </div>
    </div>
<?php  } ?>
<?php
 ?>

<?php
include_once '../src/view/footer.php'; ?>
