<?php

include_once '../src/AbstractController.php';
include_once '../src/Repository/UsersRepository.php';
include_once '../src/Repository/ChallengesRepository.php';
new class () extends AbstractController
{
    public function get()
    {
        $this->render('challenge.bak', []);
    }
};
