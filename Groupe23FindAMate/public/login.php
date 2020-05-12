<?php

include_once '../src/Utils/autoloader.php';
include_once '../src/View/template.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \src\Model\repository\UserRepository($dbAdaper);

loadView('login',[]);
?>