<?php

include_once '../src/AbstractController.php';
include_once '../src/Repository/ChallengesRepository.php';
include_once '../src/Repository/ChallengesPlayedRepository.php';
new class () extends AbstractController
{
    public function get()
    {
        if ($this->security->isLoggedIn())
        {
            $challengesRepository = new ChallengesRepository($this->dbAdapter);
            $challengesPlayedRepository=new ChallengesPlayedRepository($this->dbAdapter);
            $this->render('home', [
                'challenges' => $challengesRepository->fetchAllChallenges(),
                'challengesPlayed'=> $challengesPlayedRepository->fetchChallengesPlayedAll()
              ]);
        }
        else
        {
            $this->renderError(
                'Tu dois être connecté.e pour accéder à cette page !'
            );
        }
    }
};
