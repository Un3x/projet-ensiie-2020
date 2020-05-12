<?php

include_once '../src/Entity/Challenges.php';

class ChallengesRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct($dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAllChallenges()
    {

        $challengesData = $this->dbAdapter->query('SELECT * FROM "Challenges"');
        $challenges = [];
        foreach ($challengesData as $challengesDatum) {
            $challenge = new Challenges();
            $challenge
                ->setId($challengesDatum['id'])
                ->setName($challengesDatum['name'])
                ->setDifficultyLevel($challengesDatum["difficultylevel"])
                ->setDescription($challengesDatum["description"])
                ->setSequenceNumber($challengesDatum["sequencenumber"]);
            $challenges[] = $challenge;
        }
        return $challenges;
    }

    public function delete ($challengeId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "Challenges" where id = :challengeId');

        $stmt->bindParam('challengeId', $challengeId);
        $stmt->execute();
    }
}
