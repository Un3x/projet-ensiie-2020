<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    $parts = explode('\\', $class);
    if ($parts[0] !== "Model") return;
    $filepath = $_SERVER['DOCUMENT_ROOT'] . '/Model/' . implode('/', array_slice($parts, 1)) . '.php';
    require_once $filepath;
  }, true);