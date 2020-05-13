<html lang="fr">
<head>
    <?php include_once '../src/view/head.php' ?>

    <link rel="stylesheet" href="./css/nouscontacter.css">
</head>

<?php include_once '../src/view/header.php' ?>
<body>
    <div class="container">
        <div class="row justify-content-center">
        <h2> Une remarque? une suggestion? N'hésitez pas à nous écrire!</h2> <br /> <br />
            <div class="col-md-6 order-md-1">
                <h4 class="mb-3">Formulaire de contact</h4>
                <form action="#" method="post" name="Formulaire">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="prenom">Votre prénom</label>
                            <input type="text" class="form-control" id="prenom" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="prenom">Votre nom</label>
                            <input type="text" class="form-control" id="nom" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="adresse">Adresse</label>
                            <input type="text" class="form-control" id="adresse" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ville">Ville</label>
                            <input type="text" class="form-control" id="ville" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email">Votre email</label>
                            <input type="text" class="form-control" id="email" >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telephone">Téléphone</label>
                            <input type="text" class="form-control" id="telephone" >
                        </div>
                    </div>
                    <div class="mb-3">
                        <p>Votre message</p>
                        <textarea class="form-control" id="message" name="message" rows="10"></textarea>
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Valider</button>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"> </script>
    <?php include_once '../src/view/footer.php' ?>
</body>
</html>
                        
