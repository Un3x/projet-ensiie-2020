<h1>Bienvenue chez vous, Ô tout puissant <?php echo $_SESSION['username'] ?>, administrateur de votre état.</h1>
<h3>Voici la liste de vos fidèles disciples :</h3>
    </br>
    <?php 
    $db = (new DbAdaperFactory())->createService();
    $urep = new \User\UserRepository($db);
    $users = $urep->fetchall();
    ?>
    <table>
    <tr><td>Identifiant</td><td>Nom d'utilisateur</td><td>Email</td><td>Est-ce qu'on a été sage ?</td></tr>
        <?php foreach($users as $user){ ?>
            <tr>
            <td><?php echo $user->getId() ?></td><td><?php echo $user->getUsername()?></td>
            <td><?php echo $user->getEmail() ?></td><td><form method="post" action="deleteUser.php" onsubmit="return areYouSure();">
                                                        <button type="submit" class="btn btn-danger" value=<?php $user->getId() ?> name=user_id>Supprimer cet utilisateur (ne marche pas encore)</button></td>
            </tr>
        <?php } ?>
    </table>
    </br>
    <p>Vous pouvez aussi supprimer votre propre compte :
        <form method="post" action="server.php" onsubmit="return areYouSure();">
        <button type=submit name="delete_account" class="btn btn-danger">/!\ SUPPRIMER MON COMPTE /!\</button>
    </p>
