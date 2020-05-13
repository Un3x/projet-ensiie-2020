<?php

include '../src/Factory/DbAdaperFactory.php';
$adId = $_POST['ad_id'] ?? null; //
if ($adId) {
        $connexion = (new DbAdaperFactory())->createService();
        $sql="SELECT text FROM \"report\" RIGHT OUTER JOIN \"ad\" ON \"report\".textId=\"ad\".id WHERE \"ad\".id = :adId";
        $reqs=$connexion->prepare($sql);
        $reqs->bindParam(":adId",$adId,PDO::PARAM_INT);
        $reqs->execute();
        $reqs=$reqs->fetchAll();
        ?>
        <table class="table">
            <tr>
                <th>signalements</th>
            </tr>
        <?php foreach($reqs as $req): ?>
            <tr>
                <td><?= $req['text'] ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
        <a href="/espace_membre.php"> retourner à l'espace membre</a>
<?php } ?>
<?php  #JOIN "ad" ON textId ="ad".:adId)?>
