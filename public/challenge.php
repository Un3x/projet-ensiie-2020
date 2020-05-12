<?php

include_once '../src/AbstractController.php';
include_once '../src/Repository/UsersRepository.php';
include_once '../src/Repository/ChallengesRepository.php';
new class () extends AbstractController
{
    public function get()
    {
        if ($this->security->isLoggedIn())
        {
            if ($this->requireParams($_GET, ['id']))
            {
                $challengesRepository = new ChallengesRepository($this->dbAdapter);
                $this->render('challenge', [
                    'challenges' => $challengesRepository->fetchAllChallenges(),
                    'id' => $this->need('id')
                ]);
            }
        }
        else
        {
            $this->renderError(
                "Tu dois être connecté.e pour accéder à cette page !"
            );
        }
    }
};
