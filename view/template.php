<?php

function loadView($view, $data)
{
?>
    <?php require_once 'head.php' ?>
    <body>
        <?php require_once 'layout/header.php' ?>
        <div class="container">
            <?php require_once 'view/' . $view . '.php' ?>
        </div>
        <?php require_once 'layout/footer.php' ?>
    </body>
<?php } ?>