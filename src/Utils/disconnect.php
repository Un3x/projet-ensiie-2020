<?php
unset($_SESSION['user_name']);
unset($_SESSION['user_email']);
session_destroy();
header('Location: ../View/connection.html'); 
?>