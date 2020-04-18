<?php

// this file ends session of current user
// call this file to logout the user

session_start();
session_unset();
session_destroy();
header("Location /");
?>
