
<head>
    <?php
include_once '../src/view/head.php';
include_once '../src/view/header.php';
?>
    <link rel="stylesheet" href="./css/connexion.css">
</head>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h2>Voici les annonces en vogue !</h2><br /><br />
        </div>
        <div class="col-sm-12">
                <?php
        include_once 'search_ad.php' ;?>
        </div>
    </div>
</div>
<script src="script.js"></script>
</body>
<?php
include_once '../src/view/footer.php'
?>
</html>
