<?php

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
    <title>Medialiste</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Thomas COMES">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=1.0">
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Medialiste</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/index.php">Home</a>                      
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/signIn.php">Sign in</a>
                 </li>                                          
                <li class="nav-item active">                                          
                    <a class="nav-link" href="/signUp.php">Sign up</a>
                 </li>
                <li class="nav-item active">                                          
                    <a class="nav-link" href="/affichage.php">Affichage liste</a>
                 </li>
                 <li class="nav-item active">                                          
                    <a class="nav-link" href="/affichage2.php">Affichage oeuvre</a>
                 </li>          
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
                    <th>Username</th>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>Email</th>   
                    <th>Status</th>
                    <th>Banned</th>
                    <th>Action</th>
                </tr>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user->getUsername() ?></td>
                        <td><?= $user->getLastname() ?></td>
                        <td><?= $user->getFirstname() ?></td>
                        <td><?= $user->getEmail() ?></td>           
                        <td><?= $user->getStatus() ?></td>
                        <td><?= $user->getBanned() ?></td>
                        <td>
                            <form method="POST" action="/deleteUser.php">
                                <input name="user_id" type="hidden" value="<?= $user->getUsername() ?>">
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
