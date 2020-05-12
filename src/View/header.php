<header>
    <?php
    include_once '../src/View/template.php';
    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">BIblIothEque</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                <?php 
                session_start();
                if(! isset($_SESSION["loggedin"])) {?>

                <a href="borrowBook.php?log=1"> Log In </a>

                <?php }elseif(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
                    echo $_SESSION["username"];
                    if($_SESSION["adminright"]){?>
                    <a href="borrowBook.php?gestion=1"> Book Gestion </a>
                    <?php }?>

                <a href="borrowBook.php?logout=1"> Log Out </a> 

                <?php }?>
                <a href="borrowBook.php?home=1"> Catalog </a>

                </li>
                <li class=nav-item active>
                    <div class="ui-widget">
                        <form method="POST" action="/borrowBook.php">
                            <label for="book""> Search : </label>
                            <input type="text" name ="book" id="book" onkeyup="showHint(this.value)" name="search"><br/>
                            <span id="nameHint"></span><br/>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>