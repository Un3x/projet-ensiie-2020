<?php

include_once '../src/AbstractController.php';
include_once '../src/Repository/UsersRepository.php';

new class () extends AbstractController
{
    public function get()
    {
        if ($this->security->isLoggedIn())
        {
            $id = $this->requireParams($_GET, ['id']) ?
                $this->params['id'] : strval($this->security->id)
            ;

            if ($this->security->id == $id || $this->security->isAdmin())
            {
                $userRepository = new UsersRepository($this->dbAdapter);
                $this->render('profil', [
                    'user' => $userRepository->fetchOne($id)
                ]);
            }
            else
            {
                $this->renderError(
                    "Tu n'as pas le droit de voir ce profil !"
                );
            }
        }
        else
        {
            $this->renderError(
                "Tu dois être connecté.e pour essayer de voir cette page !"
            );
        }
    }
    public function post()
    {
        if ($this->need('action') === 'modify')
        {
            $usersRepository = new UsersRepository($this->dbAdapter);
            
            if (!$usersRepository->exists($this->need('pseudo')))
            {
                $usersRepository->modifyProfile($this->security->id ,$this->need('pseudo'),$this->need('password'));
                $this->security->refresh();
                
                $this->render('profil', [
                    'message' => 'Votre profil a bien été modifié !',
                    'user' => $userRepository->fetchOne($id)
                ]);
            }
            else
            {
                // Pour changer que le mot de passe
                if($this->security->pseudo === $this->need('pseudo')){
                    $usersRepository->modifyProfile($this->security->id ,$this->need('pseudo'),$this->need('password'));
                    $this->security->refresh();
                    $this->render('profil', [
                        'message' => 'Votre mot de passe a bien été modifié !',
                        'user' => $userRepository->fetchOne($id)
                    ]);
                }else{
                    $this->render('profil', [
                        'message' => 'Pas de chance, ce pseudo est déjà utilisé ! Tu dois en trouver un autre !'
                    ]);
                }
            }

        }
    }
    
};
