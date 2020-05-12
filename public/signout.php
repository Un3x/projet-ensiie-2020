<?php

include_once '../src/AbstractController.php';
include_once '../src/Repository/UsersRepository.php';

new class () extends AbstractController
{
    public function get()
    {
        if ($this->security->isLoggedIn())
        {
            $this->security->signOut();
        }
        $this->redirect('/');
    }
};
