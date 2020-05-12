<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Twittiie ^^</title>
    <meta name="description" content="Twittiie">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Projet Web Ensiie 2020 : Twittiie</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Accueil</a>
                </li>
                <li>
                    <a class="nav-link" href="/Authentification.php">Authentifiez-vous !</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="authentification">
    <div>
        <div class="form-group">
            <label for="username" class="label">Username</label>
            <input id="username" class="form-control" name="username" type="text" required>
            <small><p id="textusername" style="color: red"></p></small>
        </div>
        <div class="form-group">
            <label for="email" class="label">Email</label>
            <input id="email" class="form-control" name="email" type="text" required>
            <small><p id="textemail" style="color: red"></p></small>
        </div>
        <div class="form-group">
            <label for="password1" class="label">Password</label>
            <input id="password1" class="form-control" name="password1" type="password" data-type="password" required>
            <small><p id="textpassword1" style="color: red"></p></small>
        </div>
        <div class="form-group">
            <label for="password2" class="label">Confirm password</label>
            <input id="password2" class="form-control" name="password2" type="password" data-type="password" required>
            <small><p id="textpassword2" style="color: red"></p></small>
        </div>
        <div class="group">
            <input type="submit" class="btn btn-primary" onclick="register(); return false;" value="Sign up">
            <small><p id = "textsubmit" style="color: red"></p></small>
            <div class="hr"></div>
            <div class="foot-lnk">
            </div>
        </div>
        <div class="group">
            <small  >Déjà inscrit ?
                <a href="Authentification.php">Sign in</a></small>
        </div>
    </div>
</div>
<script src="scripts.js"></script>
</body>
