<?php

include_once '../src/AbstractController.php';
include_once '../src/Repository/UsersRepository.php';

new class () extends AbstractController
{
    public function get()
    {
        $this->render('index', []);
    }

    public function post()
    {
            if ($this->need('action') === 'signin')
            {
                if ($this->security->signIn(
                    $this->need("pseudo"),
                    $this->need("password")
                )) {
                    $this->redirect('/home.php');
                } else {
                    $this->render('index', [
                        'message' => 'Ton pseudo ou ton mot de passe n\'est pas bon.'
                    ]);
                }
            }
            else if ($this->need('action') === 'signup')
            {
                    $usersRepository = new UsersRepository($this->dbAdapter);
                    if (! $usersRepository->exists($this->need('pseudo')))
                    {
                        $usersRepository->create([
                            'firstname' => $this->need('firstname'),
                            'lastname' => $this->need('lastname'),
                            'pseudo' => $this->need('pseudo'),
                            'password' => $this->need('password')
                        ]);
                        $this->security->signIn(
                            $this->need("pseudo"),
                            $this->need("password")
                        );
                        $this->redirect('/home.php');
                    }
                    else
                    {
                        $this->render('index', [
                            'message' => 'Pas de chance, ce pseudo est déjà utilisé ! Tu dois en trouver un autre !'
                        ]);
                    }


            }
    }
};
