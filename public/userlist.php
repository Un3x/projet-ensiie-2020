<?php
#phpinfo();
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$users = $userRepository->fetchAll();

//test nb d'id pour pouvoir creer le prochain id du nouveau username qui s'inscrit
/*$nb_id = $userRepository->nb_users();
echo "nb d'identifiants = ".$nb_id;*/

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
        <a class="navbar-brand" href="#">Parions Retard</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                </li>
                    <a href='agenda.php' class="nav-link"><span>Agenda</span></a> 
                    <a href='profil.php' class="nav-link"><span>Profil</span></a> 
                    <a href='OrgaReu.php' class="nav-link"><span>Réunions</span></a>
                    <a href='bet.php' class="nav-link"><span>Paris</span></a>
                    <?php session_start();
                    if($_SESSION['username'] !== ""){
                    $points = $_SESSION['user']->getPoints();
                    echo "<div class='nav-link'>$points \$ </div>";
                    }
                    ?>
                    <?php if($userRepository->IsSuperAdmin($_SESSION['user']->getId()))
                      echo "<a href='home_super_admin.php' class='nav-link'><span>Gestion</span></a>";
                      ?>

                <?php session_start();
                        if($_SESSION['username'] !== ""){
                         $user = $_SESSION['username'];
                     // afficher un message
                     echo "<div class='connection_id nav-link' id='idco' >";
                     echo "$user";
                     echo "</div>";
                          if(isset($_GET['deconnexion'])) { 
                       if($_GET['deconnexion']==true) {  
                        session_unset();
                        header("location:index.php");
                       }
                    }

                    }
                ?>
                    <a href='userlist.php?deconnexion=true' class="nav-link" style="align-text:right;"><span>Déconnexion</span></a> 

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
                                    </tr>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user->getId() ?></td>
                        <td><?= $user->getUsername() ?></td>
                        <td><?= $user->getEmail() ?></td>
                        <td><?= $user->getCreatedAt()->format(\DateTime::ATOM) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<script src="js/scripts.js"></script>
</body>
</html>
