<?php

// this file ends session of current user

session_start();
session_unset();
session_destroy();
header("Location /");
?>
