<head>
    <?php include_once '../src/view/head.php' ?>

    <link rel="stylesheet" href="./css/connexion.css">
</head>

<?php
include_once '../src/view/header.php';
include_once '../src/Factory/DbAdaperFactory.php';

if (isset($_POST['adId'])){

    $conn=(new DbAdaperFactory())->createService();

$sql = "SELECT title,username
    FROM \"ad\" JOIN \"user\" ON \"user\".id=\"ad\".authorId
    WHERE \"ad\".id=:ad ";

$q = $conn->prepare($sql);
$q->bindParam(":ad", $_POST['adId'],PDO::PARAM_STR);

$q->execute();
$q = $q->fetchAll();
foreach ($q as $r) {
    ?>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="order-md-1">
            <h4 class="mb-3">Signaler l'annonce : </h4>
            <p><?=  $r['title'] ?> par <?= $r['username'] ?></p>
            <form action="ajoutReport.php" method="post" name="Report" onsubmit="return validation()">
                <div class="row justify-content-left">
                    <div><textarea class="form-control" type="text" name="text" id="text" size="300"  placeholder="Écrivez vos raisons ici ..." rows="8"  required></textarea></div>
                    <script> function validation(){
                            alert("Votre signalement a bien été envoyé.")
                            return true;
                        } </script>
                    <input type="hidden" id="textId" name="textId" value="<?= $_POST['adId'] ?>">
                    <input name="ad_id" class="btn btn-secondary" type="submit" value="Valider">
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<br><br>
<br><br><br>
<br><br><br>

</body>
    <?php include_once '../src/view/footer.php' ?>

<?php } }
else {
    header('Location: /index.php');
    exit();
}
?>


