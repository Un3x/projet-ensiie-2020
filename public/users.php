<?php

include_once '../src/AbstractController.php';
include_once '../src/Repository/UsersRepository.php';

new class () extends AbstractController
{
    public function get()
    {
        $usersRepository = new UsersRepository($this->dbAdapter);
        $this->render('users', [
            'users' => $usersRepository->fetchAll()
        ]);
    }
};
