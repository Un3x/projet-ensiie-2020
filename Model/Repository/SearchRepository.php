<?php

namespace Model\Repository;

class SearchRepository
{

    private $dbAdapter;

    public function __construct(
        \PDO $dbAdapter
    ) {
        $this->dbAdapter = $dbAdapter;
    }

    function search($str)
    {
        $results = [];
        $sql = <<<SQL
SELECT  username AS results FROM user WHERE username LIKE :str
SQL;
        $stmt = $this->dbAdapter->prepare($sql);
        $stmt->bindValue(':str', "%" . $str . "%", \PDO::PARAM_STR);
        $stmt->execute();
        foreach ($stmt->fetchAll() as $result) {
            $results[] = [
                "value" => $result[0],
                "type" => "user",
            ];
        }

        $sql = <<<SQL
SELECT fullname FROM game WHERE fullname LIKE :str
SQL;
        $stmt = $this->dbAdapter->prepare($sql);
        $stmt->bindValue(':str', "%" . $str . "%", \PDO::PARAM_STR);
        $stmt->execute();
        foreach ($stmt->fetchAll() as $result) {
            $results[] = [
                "value" => $result[0],
                "type" => "game",
            ];
        }

        $sql = <<<SQL
SELECT DISTINCT hashtag FROM hashtag  WHERE hashtag LIKE :str
SQL;
        $stmt = $this->dbAdapter->prepare($sql);
        $stmt->bindValue(':str', "%" . $str . "%", \PDO::PARAM_STR);
        $stmt->execute();
        foreach ($stmt->fetchAll() as $result) {
            $results[] = [
                "value" => $result[0],
                "type" => "hashtag",
            ];
        }
        $sql = <<<SQL
SELECT DISTINCT genre FROM genre WHERE genre LIKE :str
SQL;
        $stmt = $this->dbAdapter->prepare($sql);
        $stmt->bindValue(':str', "%" . $str . "%", \PDO::PARAM_STR);
        $stmt->execute();
        foreach ($stmt->fetchAll() as $result) {
            $results[] = [
                "value" => $result[0],
                "type" => "genre",
            ];
        }
        return $results;
    }
}
