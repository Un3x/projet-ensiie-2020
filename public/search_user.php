<head>
    <?php
include_once '../src/view/head.php'; ?>
</head>

<?php
include_once '../src/view/header.php';
include_once '../src/Factory/DbAdaperFactory.php';
$conn = (new DbAdaperFactory())->createService();

// Récupère la recherche
$rechercheuser =  isset($_POST['recherche']) ? "%" . $_POST['recherche'] . "%" : "%" ;

// la requete mysql
$sql=
    <<<SQL
    SELECT * 
    FROM "user" 
    WHERE (username LIKE :rechercheuser)  OR (keyWords LIKE :rechercheuser) OR (email LIKE :rechercheuser) OR (fname LIKE :rechercheuser) OR ("user".name LIKE :rechercheuser) ORDER BY username, "user".created_at LIMIT 30
SQL;
$q = $conn->prepare($sql);
$q->bindParam(":rechercheuser", $rechercheuser,PDO::PARAM_STR);

$q->execute();
$q = $q->fetchAll();
if (count($q) != 0) {
foreach($q as $r) {?>
    <div class="card" style="width: 80rem;">
        <img class="card-img-top" src="" alt="Card image cap">
        <div class="card-body">
            <p class="card-text"><?= $r['username'] ?></p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><?= $r['fname'] . " " . $r['name'] . ", " . $r['age'] . " ans." ?> </li>
            <li class="list-group-item">Keywords : <span class="badge badge-secondary"><?=  $r['keywords'] ?></span> </li>
        </ul>
        <div class="card-body">
            <form action="user.php" method="post" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="hidden" id="user" name="user" value="<?=  $r['id'] ?>">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Aller voir le profil !</button>
            </form>
        </div>
    </div>
<?php  }

}
else { ?>
    <div class="card-body">
        <h2 class="card-title"> Désolé </h2>
        <h4 class="card-title"> Nous n'avons rien trouvé :(</h4>
        <img class="fit-picture" src="burned_match.png" alt="Burned match">
    </div>
<?php  }
include_once '../src/view/footer.php';?>

