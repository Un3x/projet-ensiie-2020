<?php 

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \src\Model\repository\UserRepository($dbAdaper);
$users = $userRepository->fetchAll(); ?>


<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Find A Mate</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Zoubir Team v2.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css?v=1.0">
    <link rel="stylesheet" href="style.css">
    
</head>

<body>
<header>

</header>

<?php if(isset($_SESSION['isAdmin']) && ($_SESSION['isAdmin']=='TRUE')) : ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>User List</h1>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>id</th>
                    <th>Pseudo</th>
                    <th>email</th>
                    <th>creation date</th>
                    <th>Promo</th>
                    <th>Statut d'admin</th>
                    <th>Pseudo Discord</th>
                </tr>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user->getId() ?></td>
                        <td><?= $user->getUsername() ?></td>
                        <td><?= $user->getEmail() ?></td>
                        <td><?= $user->getCreatedAt()->format(\DateTime::ATOM) ?></td>
                        <td><?= $user->getPromo() ?></td>
                        <td><?= $user->getIsAdmin() ?></td>
                        <td><?= $user->getPseudoDiscord() ?></td>
                        <td><?= $user->getPasswd() ?></td>
                        <td>
                            <form method="POST" action="deleteUser.php">
                                <input name="user_id" type="hidden" value="<?= $user->getId() ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<?php endif;?>
<script src="js/scripts.js"></script>
</body>
</html>
