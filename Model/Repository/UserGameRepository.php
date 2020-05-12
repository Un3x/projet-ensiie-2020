<?php

namespace Model\Repository;

class UserGameRepository
{

    private $dbAdapter;
    private $gameHydrator;
    private $userHydrator;

    public function __construct(
        \PDO $dbAdapter,
        \Model\Hydrator\GameHydrator $gameHydrator,
        \Model\Hydrator\UserHydrator $userHydrator
    ) {
        $this->dbAdapter = $dbAdapter;
        $this->gameHydrator = $gameHydrator;
        $this->userHydrator = $userHydrator;
    }

    function lastUsersGame($game)
    {
        $sql =
            <<<SQL
SELECT id, username, created_at, role, pseudo
  FROM user JOIN user_game ON user.id = user_game.user
  WHERE user_game.game = :game
  LIMIT 20
SQL;

        $stmt = $this->dbAdapter->prepare($sql);
        $stmt->bindValue(':game', $game, \PDO::PARAM_STR);
        $stmt->execute();
        $users = [];
        foreach ($stmt->fetchAll() as $rawUser) {
            $rawUser["gamespseudo"][$game] = $rawUser["pseudo"]; 
            $users[] = $this->userHydrator->hydrate($rawUser);
        }
        return $users;
    }

    function getUserGames($user)
    {
        $sql =
            <<<SQL
SELECT abrev, fullname
  FROM game JOIN user_game ON game.abrev = user_game.game
  WHERE user_game.user = :user
  LIMIT 20
SQL;

        $stmt = $this->dbAdapter->prepare($sql);
        $stmt->bindValue(':user', $user, \PDO::PARAM_INT);
        $stmt->execute();
        $games = [];
        foreach ($stmt->fetchAll() as $rawGame) {
            $games[] = $this->gameHydrator->hydrate($rawGame);
        }
        return $games;
    }
}
