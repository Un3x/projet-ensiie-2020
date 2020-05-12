<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css?v=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <a class="navbar-brand" href="/">Find A Mate</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active " >
                    <a class="nav-link" href="game.php">Ajout d'un jeu</a>                
            </li>
            <li class="nav-item active " >
                    <a class="nav-link" href="gamelist.php">Liste des jeux</a>                
            </li>
            </ul>
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active " >
                    <a class="nav-link" href="createsearch.php">Créer une recherche</a>                
            </li>
            <li class="nav-item active " >
                    <a class="nav-link" href="allSearch.php">Toutes les recherches</a>                
            </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if(isset($_SESSION["name"])): ?>
                    <li class="nav-item active"> 
                    <a class="nav-link" href="deconnection.php"> Déconnexion </a>   
                    </li>                 
                    <li class="nav-item active"> 
                    <a class="nav-link" href="profil.php?action=consulter&pseudo=<?php echo $_SESSION["name"] ?>"> <?php echo $_SESSION["name"] ?> </a>   
                    </li>                 
                <?php else: ?>
                    <li class="nav-item active" >
                    <a class="nav-link" href="signup.php">Sign Up</a>
                </li>    
                <li class="nav-item active " >
                    <a class="nav-link" href="login.php">Login</a>                
                </li>
                <?php endif; ?>
            </ul>
        </nav>