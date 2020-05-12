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
                    <a class="nav-link" href="/signup.php">S'inscrire'</a>
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
            <label for="password" class="label">Password</label>
            <input id="password" class="form-control" name="password" type="password" data-type="password" required>
            <small><p id="textpassword" style="color: red"></p></small>
        </div>
        <div class="group">
            <input id="check" type="checkbox" class="check" checked>
            <label for="check"><span class="icon"></span> Keep me Signed in</label>
        </div>
        <div class="group">
            <input type="submit" class="btn btn-primary" onclick="signin(); return false;" value="Sign in">
            <small><p id = "textsubmit" style="color: red"></p></small>
            <div class="hr"></div>
            <div class="foot-lnk">
            </div>
        </div>
        <div class="group">
            <small  >Besoin de créer un compte ?
            <a href="signup.php">Sign up</a></small>
        </div>
    </div>
</div>
<script src="scripts.js"></script>
</body>
