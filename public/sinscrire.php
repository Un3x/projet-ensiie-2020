<html lang="fr">
<head>
    <?php include_once '../src/view/head.php' ?>

    <link rel="stylesheet" href="./css/connexion.css">
</head>
<body>
    <?php include_once '../src/view/header.php' ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 order-md-1">
                <h4 class="mb-3">Créer son compte</h4>
                <form action="/ajoutuser.php" method="post" name="Formulaire" onsubmit="return validation(this);" >
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="prenom">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom ...">
                            <small id="wrongPrenom" class="text-danger">
                            </small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nom">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom ...">
                            <small id="wrongNom" class="text-danger">
                            </small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="email" class="form-control" id="email" name="email" placeholder="votre@email.com" required="">
                        </div>
                        <small id="wrongEmail" class="text-danger">
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="pseudo">Pseudo</label>
                        <input type="pseudo" class="form-control" id="pseudo" name="pseudo" placeholder="Entrez un pseudo.." data-kwimpalastatus="alive">
                        <small id="wrongPseudo" class="text-danger">
                        </small>
                    </div>
                    <div class="mb-3">
                        <label for="age">Âge</label>
                        <input type="text" class="form-control" id="age" name="age" placeholder="Entrez votre âge ...">
                        <small id="wrongAge" class="text-danger">
                        </small>
                    </div>
                    <div class="mb-3">
                        <label for="pwd1">Mot de passe(doit contenir au moins 6 caractères avec chiffres)</label>
                        <input type="password" class="form-control" id="pwd1" name="pwd1" placeholder="Entrez votre mot de passe ...">
                        <small id="wrongPwd1" >
                        </small>
                    </div>
                    <div class="mb-3">
                        <label for="pwd2">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="pwd2" name="pwd2" placeholder="Confirmer votre mot de passe ...">
                        <small id="wrongPwd2" class="text-danger">
                        </small>
                    </div>
                    <hr class="mb-4">
                    <p> tous les champs sont requis</p>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Valider</button>
                </form>
            </div>
        </div>
    </div>
    <script src="inscrire.js"> </script>
    <?php include_once '../src/view/footer.php' ?>
</body>
</html>
        

