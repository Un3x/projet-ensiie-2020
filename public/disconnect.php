<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['admin']);
unset($_SESSION['password']);