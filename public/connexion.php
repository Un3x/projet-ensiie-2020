<html lang="fr">

<head>
    <?php include_once '../src/view/head.php' ?>

    <link rel="stylesheet" href="./css/connexion.css">
</head>

<?php include_once '../src/view/header.php' ?>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5 mb-5">
            <div class="text-center col-md-4">
                <form class="form-signin" action="/authentification.php" method="post">
                    <img class="mb-4" src="/match_n_build.png" alt="" width="72" height="72">
                    <h1 class="h3 mb-3 font-weight-normal">Connexion</h1>
                    
                    <label for="email" class="sr-only">Adresse mail</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Adresse mail" required="" >
                    
                    <label for="pwd" class="sr-only">Mot de passe</label>
                    <input type="password" id="pwd" name="pwd" class="form-control" placeholder="Mot de passe" required="">
                    
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
    <?php include_once '../src/view/footer.php' ?>
</body>

</html>
