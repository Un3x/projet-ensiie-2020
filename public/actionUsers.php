<?php


include_once '../src/AbstractController.php';
include_once '../src/Repository/UsersRepository.php';
include_once '../src/Repository/ChallengesPlayedRepository.php';


new class () extends AbstractController
{
    public function get()
    {
            if ($this->security->isLoggedIn())
            {
                $usersRepository = new UsersRepository($this->dbAdapter);
                $challengesPlayedRepository = new ChallengesPlayedRepository($this->dbAdapter);
                if ($this->security->isadmin)
                {
                    if ($this->need('action') === 'removeSuspension') {
                        $usersRepository->removeSuspension($this->need('id'));
                    }

                    else if ($this->need('action') === 'removeAdministration') {
                        $usersRepository->removeAdministrator($this->need('id'));
                    }

                    else if ($this->need('action') === 'makeAdministrator') {
                        $usersRepository->makeAdministrator($this->need('id'));
                    }
                    else if ($this->need('action') === 'suspend') {
                        $usersRepository->suspend($this->need('id'));
                    }
                    if ($this->need('id') == $this->security->id)
                    {
                        $this->security->refresh();
                    }
                }


                if ($this->need('id') == $this->security->id || $this->security->isadmin)
                {
                    if ($this->need('action') === 'delete') {
                        $usersRepository->delete($this->need('id'));
                        if ($this->need('id') == $this->security->id)
                        {
                            $this->security->signOut();
                        }
                    }
                    
                    if ($this->need('action') === 'restart'){
                      $challengesPlayedRepository ->deleteProgression($this->need('id'));
                    }


                }
                $this->redirect($this->need('redirect') . '.php');
            }
            else
            {
                echo "Action non autorisée";
            }
    }
};
