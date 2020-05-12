<?php

namespace Model\Repository;

class GameRepository
{

    private $dbAdapter;
    private $gameHydrator;

    public function __construct(
        \PDO $dbAdapter,
        \Model\Hydrator\GameHydrator $gameHydrator
    ) {
        $this->dbAdapter = $dbAdapter;
        $this->gameHydrator = $gameHydrator;
    }

    function lastGames()
    {
        $sql =
            <<<SQL
SELECT abrev, fullname
  FROM game LEFT OUTER JOIN hashtag ON abrev = hashtag OR fullname = hashtag
  GROUP BY abrev
  ORDER BY COUNT(message) DESC
  LIMIT 20
SQL;

        $stmt = $this->dbAdapter->prepare($sql);
        $stmt->execute();
        $games = [];
        foreach ($stmt->fetchAll() as $rawGame) {
            $games[] = $this->gameHydrator->hydrate($rawGame);
        }
        return $games;
    }

    function lastGamesDetailed()
    {
        $sql =
            <<<SQL
            SELECT abrev, fullname, description, COUNT(DISTINCT pseudo) AS players, ROUND(AVG(vote),2) as note
            FROM game
            LEFT JOIN user_vote ON user_vote.game = game.abrev
            LEFT JOIN user_game ON user_game.game = game.abrev
            GROUP BY abrev
SQL;

        $stmt = $this->dbAdapter->prepare($sql);
        $stmt->execute();
        $games = [];
        foreach ($stmt->fetchAll() as $rawGame) {
            $genre =
                <<<SQL
                SELECT genre
                FROM genre
                WHERE game = :abrev
SQL;
            $stmtgenre = $this->dbAdapter->prepare($genre);
            $stmtgenre->bindValue(':abrev', $rawGame['abrev'], \PDO::PARAM_STR);
            $stmtgenre->execute();
            $rawGame["genres"] = [];
            foreach ($stmtgenre->fetchAll() as $genre) $rawGame["genres"][] = $genre["genre"];
            $games[] = $this->gameHydrator->hydrateDetails($rawGame);
        }
        return $games;
    }

    function details($abrev)
    {
        $sql =
            <<<SQL
  SELECT abrev, fullname, description, COUNT(DISTINCT pseudo) AS players, ROUND(AVG(vote),2) as note
            FROM game
            LEFT JOIN user_vote ON user_vote.game = game.abrev
            LEFT JOIN user_game ON user_game.game = game.abrev
            WHERE abrev = :abrev
            GROUP BY abrev
SQL;

        $stmt = $this->dbAdapter->prepare($sql);
        $stmt->bindValue(':abrev', $abrev, \PDO::PARAM_STR);
        $stmt->execute();
        $rawGame = $stmt->fetch();
        return $rawGame ? $this->gameHydrator->hydrateDetails($rawGame) : null;
    }
}
