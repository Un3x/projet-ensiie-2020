<?php
    include '../src/PplOnline.php';
    include '../src/PplOnlineRepository.php';
    include '../src/Factory/DbAdaperFactory.php';

    $dbAdaper = (new DbAdaperFactory())->createService();
    $pplonlineRepository = new PplOnline\PplOnlineRepository($dbAdaper);
    $pplonlines = $pplonlineRepository->fetchAll();
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>La Ligue des Deglingos</title>
        <meta name="description" content="Projet web Ensiie">
        <meta name="author" content="Theau FERNANDEZ / Quentin JURY / Gabriel Meziere">
        <link rel="stylesheet" href="style.css?v=1.0">
    </head>
    <body>
        <div id="connexion_info">
            <input type="hidden" id=nbr_online value=<?php echo($pplonlineRepository->update()); ?> />
            <?php session_start(); echo("Welcome " .$_SESSION["username"]); ?>
            <?php echo("/ Online : "); echo($pplonlineRepository->update());  ?>
            <form method="POST" action="/Logout.php">
                <button type="submit">Logout</button>
            </form>
        </div>
        <div id="volet_clos">
            <div id="volet">
                <form method="POST" action="/updateUtilisateur.php" name="profile_changes">
                <div id="profile_settings">
                    <ul style="list-syle-type:none;">
                        <li>Change username</li>
                        <li>Change Password</li>
                    </ul>
                </div>
                <a href="#volet" class="open" aria-hidden="true"><img src="images/profil.png" alt="profil picture"></a>
                <a href="#volet_clos" class="close" aria-hidden="true"><img src="images/profil.png" alt="profil picture"></a>
            </div>
        </div>
        <p>
        Cette page sera la page d'accueil destinée à la redirection après s'être login
        </p>
    </body>
</html>