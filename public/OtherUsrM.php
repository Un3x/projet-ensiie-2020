<?php require_once("header.php"); ?>
<?php
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
//$users = $userRepository->fetchAll();

$id=$_SESSION['id'];
$user_cnt = $userRepository->select($id);

?>
<?php require_once("menuConnect.php"); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Utilisateurs</h1>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>nom</th>
                    <th>Prenom</th>
                    <th>Pseudo</th>
                    <th>email</th>
                    <th>adresse</th>
                    <th>telephone</th>
                    <th>Role</th>
                    <th>etat</th>
                    <th>Action</th>
                </tr>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user->getNom() ?></td>
                        <td><?= $user->getPrenom() ?></td>
                        <td><?= $user->getPseudo() ?></td>
                        <td><?= $user->getEmail() ?></td>
                        <td><?= $user->getAdresse() ?></td>
                        <td><?= $user->getTelephone() ?></td>
                        <td><?= $user->getRole() ?></td>
                        <td><?= $user->getEtat() ?></td>
                        <td>
                            <form method="POST" action="warnUser.php">
                                <input name="id_membre" type="hidden" value="<?= $user->getId() ?>">
                                <input name="id" type="hidden" value="<?= $id ?>">
                                <button type="submit">Accuser</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<script src="js/scripts.js"></script>
<?php include_once '../public/footer.php' ?>
