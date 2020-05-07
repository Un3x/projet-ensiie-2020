<?php
    /*Action des choix*/
    include 'page_fct.php';
    
    if (isset($_POST['choice1'])) {
        echo $_POST['choice1'];
    }
    if (isset($_POST['choice2'])) {
        echo $_POST['choice2'];
    }
    if (isset($_POST['choice3'])) {
        echo $_POST['choice3'];
    }
?>