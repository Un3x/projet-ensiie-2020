<?php

include_once '../src/Entity/ChallengesPlayed.php';

class ChallengesPlayedRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct ($dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function hydrate ($challengesPlayedDatum, $challengePlayed)
    {
        $challengePlayed
        ->setUserId($challengesPlayedDatum['idUser'])
        ->setChallengeId($challengesPlayedDatum['idChallenge'])
        ->setSavePlayerSolution($challengesPlayedDatum['savePlayersSolution'])
        ->setProgression($challengesPlayedDatum['progression']);
    }

    public function fetchChallengesPlayedAll ()
    {
        $challengesPlayedData = $this->dbAdapter->query('SELECT * FROM "ChallengesPlayed"');
        $challengesPlayed = [];
        foreach ($challengesPlayedData as $challengePlayedDatum) {
            $challengePlayed = new ChallengesPlayed();
            $this->hydrate($challengePlayedDatum, $challengePlayed);
            $challengesPlayed [] = $challengePlayed;
        }
        return $challengesPlayed ;
    }
    public function fetch ($userId , $challengeId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT * FROM "ChallengesPlayed" WHERE idUser = :userId and idChallenge = :challengeId ');
        $stmt->bindParam('userId', $userId);
        $stmt->bindParam('challengeId', $challengeId);
        $stmt->execute();
        $challengePlayed = new ChallengePlayed();
        $this->hydrate($stmt->fetch(), $challengePlayed);

        return $challengePlayed;
    }
    public function delete ($userId, $challengeId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "ChallengesPlayed" where id = :userId and idChallenge = :challengeId');
        $stmt->bindParam('userId', $userId);
        $stmt->bindParam('challengeId', $challengeId);
        $stmt->execute();
    }
    public function SavePlayerSolution ($userId, $challengeId,$playerSolution)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "ChallengesPlayed" SET savePlayersSolution = :playerSolution  where id = :userId and idChallenge = :challengeId');
        $stmt->bindParam('userId', $userId);
        $stmt->bindParam('challengeId', $challengeId);
        $stmt->bindParam('playerSolution', $playerSolution);
        $stmt->execute();
    }
    public function ChallengePlayedByUser($userId, $challengeId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT * FROM "ChallengesPlayed" WHERE userId = :userId and idChallenge = :challengeId');
        $stmt->bindParam('userId ', $userId);
        $stmt->bindParam('challengeId', $challengeId);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function create($data)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "ChallengesPlayed" (idUser, idChallenge, progression, savePlayersSolution) VALUES (:idUser, :idChallenge, : progression, :savePlayersSolution)');
        $stmt->bindValue(':idUser', $data['idUser']);
        $stmt->bindValue(':idChallenge', $data['idChallenge']);
        $stmt->bindValue(':progression', $data['progression']);
        $stmt->bindValue(':savePlayersSolution', $data['savePlayersSolution']);
        $stmt->execute();
    }

    public function deleteProgression ($userId)
    {
      $stmt = $this
          ->dbAdapter
          ->prepare('UPDATE "ChallengesPlayed" SET progression =0 where idUser = :userId');

      $stmt->bindParam('userId', $userId);

      $stmt->execute();
    }


  }
