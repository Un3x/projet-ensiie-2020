<?php

class ChallengesPlayed
{
    /**
     * @var int
     */
    private $idUser;

    /**
     * @var int
     */
    private $idChallenge;

    /**
     * @var int
     */
    private $progression;

    /**
     * @var string
     */
    private $savePlayerSolution;


    /**
     * @return int
     */
    public function getUserId ()
    {
        return $this->idUser;
    }

    /**
     * @param int $userid
     */
    public function setUserId ($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getChallengeId ()
    {
        return $this->idChallenge;
    }

    /**
     * @param int $idChallenge
     */
    public function setChallengeId ($idChallenge)
    {
        $this->$idChallenge = $idChallenge;
        return $this;
    }

    /**
     * @return int
     */
    public function getProgression ()
    {
        return $this->progression;
    }

    /**
     * @return string
     */
    public function getSavePlayerSolution()
    {
        return $this->savePlayersSolution;
    }

    /**
     * @param string $savePlayerSolution
     */
    public function setSavePlayerSolution($savePlayerSolution)
    {
        $this->savePlayersSolution = $savePlayerSolution;
        return $this;
    }
    /**
     * @param int $progression
     */
    public function setProgression ($progression)
    {
        $this->progression = $progression;
        return $this;
    }

}
