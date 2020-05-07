<?php 
    $db = (new DbAdaperFactory())->createService();
    $urep = new \User\UserRepository($db);
    $users = $urep->fetchall();
    foreach($users as $user){
        echo $user->getId();
        echo $user->getUsername();
        echo $user->getAdmin();
    }