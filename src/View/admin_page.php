<?php //On vérifie que l'utilisateur est bien un admin.
    if (is_null($_SESSION['admin'])){
        header('Location: user_page.php');
    }
?>
<h1>Bienvenue chez vous, Ô tout puissant <?php echo $_SESSION['username'] ?>, administrateur de votre état.</h1>
<h3>Voici la liste de vos fidèles disciples :</h3>
    </br>
    <?php 
    $db = (new DbAdaperFactory())->createService();
    $urep = new \User\UserRepository($db);
    $users = $urep->fetchall();
    ?>
    <table>
    <th>Identifiant </th><th>Nom d'utilisateur</th><th>Email</th><th>Est tout puissant ?</th><th>Est-ce qu'on a été sage ?</th>
        <?php foreach($users as $user){ ?>
            <tr>
            <td><?php echo $user->getId() ?></td><td><?php echo $user->getUsername()?></td>
            <td><?php echo $user->getEmail() ?></td><td><?php echo $user->getAdmin() ?></td>
                    <?php if (! $user->getAdmin()) { ?>
                    <td><form method="post" action="deleteUser.php" onsubmit="return areYouSure()">
                        <input type="hidden" name="user_id" value=<?php echo $user->getID()?> />
                        <button type="submit" class="btn btn-danger" name="del_as_admin">Supprimer cet utilisateur</button>
                        </form>
                        </td>
                    <?php } ?>

            </tr>
        <?php } ?>
    </table>
    </br>
    <p>Vous pouvez aussi supprimer votre propre compte :
        <form method="post" action="server.php" onsubmit="return areYouSure();">
        <button type=submit name="delete_account" class="btn btn-danger">/!\ SUPPRIMER MON COMPTE /!\</button>
        </form>
    </p>
