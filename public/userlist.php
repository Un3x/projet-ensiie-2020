<?php
#phpinfo();
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$users = $userRepository->fetchAll();

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Projet web Ensiie</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Thomas COMES">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css?v=1.0">
</head>

<body>
<header>
    <!-- <link rel="stylesheet" href="style.css" media="screen" type="text/css" /> -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Projet Web Ensiie 2020</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/userlist.php"><span>Home</span></a>
                </li>
                <a href='index.php?deconnexion=true'><span>Déconnexion</span></a>
                    <?php session_start();
                if(isset($_GET['deconnexion'])){
                    if($_GET['deconnexion']==true){
                        session_unset();
                        header("location:login.php");
                    }
                }
                else($_SESSION['username'] !== ""){
                    $user = $_SESSION['username'];
                    echo "<br> Boujour $user, vous etes connectés";
                }
                ?>
            </ul>
        </div>
    </nav>
</header>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>User List</h1>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>id</th>
                    <th>username</th>
                    <th>email</th>
                    <th>creation date</th>
                    <th>Action</th>
                </tr>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user->getId() ?></td>
                        <td><?= $user->getUsername() ?></td>
                        <td><?= $user->getEmail() ?></td>
                        <td><?= $user->getCreatedAt()->format(\DateTime::ATOM) ?></td>
                        <td>
                            <form method="POST" action="/deleteUser.php">
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
<script src="js/scripts.js"></script>
</body>
</html>
