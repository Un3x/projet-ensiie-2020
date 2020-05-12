<?php
    $books = $data["books"];
?>
<style>
    body {
    background-repeat: no-repeat;
    background-size: cover;
    color:black;
    background-color:white;
    background-image:url(Images/bibliotheque.jpg);
}
</style>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
                <p class=catalogue><a href="borrowBook.php?home=1"> Catalog </a></p>
                <?php 
                session_start();
                if(! isset($_SESSION["loggedin"])) {?>
                <p class=connecter><a href="borrowBook.php?log=1"> Log in </a></p>
                <p class=inscrire><a href="borrowBook.php?compte=1" > Sign up </a></p>
                <?php }elseif(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){?>
                <p class=inscrire><a href="borrowBook.php?logout=1"> Log Out </a></p>
                <?php } ?>
        </div>
    </div>
</div>
<script src="script.js"></script>