<?php require_once("header.php"); ?>
<?php
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);

$id=$_SESSION['id'];
$user_cnt = $userRepository->select($id);


$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
//$users = $userRepository->fetchAll();
?>

<?php require_once("menuConnect.php"); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Mon compte</h1>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>nom</th>
                    <th>Prenom</th>
                    <th>Pseudo</th>
                    <th>email</th>
                    <th>password</th>
                    <th>adresse</th>
                    <th>telephone</th>
                    <th>Role</th>
                    <th>etat</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td><?= $user_cnt->getNom() ?></td>
                    <td><?= $user_cnt->getPrenom() ?></td>
                    <td><?= $user_cnt->getPseudo() ?></td>
                    <td><?= $user_cnt->getEmail() ?></td>
                    <td><?= $user_cnt->getPassword() ?></td>
                    <td><?= $user_cnt->getAdresse() ?></td>
                    <td><?= $user_cnt->getTelephone() ?></td>
                    <td><?= $user_cnt->getRole() ?></td>
                    <td><?= $user_cnt->getEtat() ?></td>
                    <td>
                        <form method="POST" action="/deleteUser.php">
                            <input name="id_membre" type="hidden" value="<?= $user_cnt->getId() ?>">
                            <input name="id" type="hidden" value="<?= $id ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>


<button type="button" onclick="document.getElementById('mdf').style.display='block'">Modifications</button></br>
<form id="mdf" method="POST" action="personalmodif.php" style="display:none">
    <input name="id" type="hidden" value="<?= $user_cnt->getId() ?>">
    <label for="n">Nom : </label>
    <input type="text" id="n" name="nom" value="<?= $user_cnt->getNom() ?>"></br>
    <label for="pn">Prenom : </label>
    <input type="text" id="pn" name="prenom" value="<?= $user_cnt->getPrenom() ?>"></br>
    <label for="ps">Pseudo : </label>
    <input type="text" id="ps" name="pseudo" value="<?= $user_cnt->getPseudo() ?>"></br>
    <label for="e">Email : </label>
    <input type="text" id="e" name="email" value="<?= $user_cnt->getEmail() ?>"></br>
    <label for="pw">Password : </label>
    <input type="text" id="pw" name="password" value="<?= $user_cnt->getPassword() ?>"></br>
    <label for="a">Adresse : </label>
    <input type="text" id="a" name="adresse" value="<?= $user_cnt->getAdresse() ?>"></br>
    <label for="t">Telephone : </label>
    <input type="text" id="t" name="telephone" value="<?= $user_cnt->getTelephone() ?>"></br>
    <button type="button" onclick="document.getElementById('mdf').style.display='none'">Annuler</button>
    <button type="submit">Enregistrer les Modifications</button>
</form>
</br>



<script src="js/scripts.js"></script>
<?php include_once '../public/footer.php' ?>
