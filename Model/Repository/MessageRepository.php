<?php

namespace Model\Repository;

class MessageRepository
{

  private $dbAdapter;
  private $messageHydrator;

  public function __construct(
    \PDO $dbAdapter,
    \Model\Hydrator\MessageHydrator $messageHydrator
  ) {
    $this->dbAdapter = $dbAdapter;
    $this->messageHydrator = $messageHydrator;
  }

  function lastPublicMessages($user, $number)
  {
    $number *= 20;
    $sql =
      <<<SQL
  SELECT message.id, message.content, message.created_at, message.visibility, message.type, message.reply, user.id as userid, user.username, user.role, count(rep.id) as reply
  FROM message LEFT JOIN message AS rep ON rep.reply = message.id, user
  WHERE message.user = user.id AND message.visibility = "public" AND message.reply IS NULL
  GROUP BY message.id
  ORDER BY message.id DESC
  LIMIT :number, 20
SQL;

    $stmt = $this->dbAdapter->prepare($sql);
    $stmt->bindValue(':number', $number, \PDO::PARAM_INT);
    $stmt->execute();
    $msgs = [];
    foreach ($stmt->fetchAll() as $rawMessage) {
      $react =
        <<<SQL
          SELECT emoji, count(user) as nb, sum(reaction.user = :user) as react
          FROM reaction
          WHERE message = :msg
          GROUP BY emoji
SQL;
      $stmtreact = $this->dbAdapter->prepare($react);
      $stmtreact->bindValue(':user', $user, \PDO::PARAM_INT);
      $stmtreact->bindValue(':msg', $rawMessage['id'], \PDO::PARAM_INT);
      $stmtreact->execute();
      $rawMessage["reactions"] = [];
      foreach ($stmtreact->fetchAll() as $reaction) {
        $rawMessage["reactions"][$reaction["emoji"]]["nb"] = $reaction["nb"];
        $rawMessage["reactions"][$reaction["emoji"]]["react"] = $reaction["react"] == "1" ? true : false;
      }
      $msgs[] = $this->messageHydrator->hydrate($rawMessage);
    }
    return $msgs;
  }

  function lastFollowedMessages($user, $number)
  {
    $number *= 20;
    $sql =
      <<<SQL
  SELECT message.id, message.content, message.created_at, message.visibility, message.type, message.reply, user.id as userid, user.username, user.role, count(rep.id) as reply
  FROM message LEFT JOIN message AS rep ON rep.reply = message.id, user
  WHERE message.user = user.id AND message.reply IS NULL
  AND (user.id = :user AND message.visibility != "deleted"
  OR (message.visibility = "unlisted" AND user.id IN (SELECT user_to FROM follow WHERE user_from = :user ))
  OR (message.visibility = "private" AND user.id IN (SELECT f1.user_from FROM follow as f1, follow as f2 WHERE f1.user_from = f2.user_to AND f1.user_to=f2.user_from AND f1.user_to = :user)))
  GROUP BY message.id
  ORDER BY message.id DESC
  LIMIT :number, 20
SQL;

    $stmt = $this->dbAdapter->prepare($sql);
    $stmt->bindValue(':number', $number, \PDO::PARAM_INT);
    $stmt->bindValue(':user', $user, \PDO::PARAM_INT);
    $stmt->execute();
    $msgs = [];
    foreach ($stmt->fetchAll() as $rawMessage) {
      $react =
        <<<SQL
          SELECT emoji, count(user) as nb, sum(reaction.user = :user) as react
          FROM reaction
          WHERE message = :msg
          GROUP BY emoji
SQL;
      $stmtreact = $this->dbAdapter->prepare($react);
      $stmtreact->bindValue(':user', $user, \PDO::PARAM_INT);
      $stmtreact->bindValue(':msg', $rawMessage['id'], \PDO::PARAM_INT);
      $stmtreact->execute();
      $rawMessage["reactions"] = [];
      foreach ($stmtreact->fetchAll() as $reaction) {
        $rawMessage["reactions"][$reaction["emoji"]]["nb"] = $reaction["nb"];
        $rawMessage["reactions"][$reaction["emoji"]]["react"] = $reaction["react"] == "1" ? true : false;
      }
      $msgs[] = $this->messageHydrator->hydrate($rawMessage);
    }
    return $msgs;
  }

  function lastUserMessages($user, $target, $number)
  {
    $number *= 20;
    $sql =
      <<<SQL
  SELECT message.id, message.content, message.created_at, message.visibility, message.type, message.reply, user.id as userid, user.username, user.role, count(rep.id) as reply
  FROM message LEFT JOIN message AS rep ON rep.reply = message.id, user
  WHERE message.user = user.id AND message.reply IS NULL
  AND user.id = :target
  AND (user.id = :user AND message.visibility != "deleted"
  OR (message.visibility = "unlisted" AND user.id IN (SELECT user_to FROM follow WHERE user_from = :user ))
  OR (message.visibility = "private" AND user.id IN (SELECT f1.user_from FROM follow as f1, follow as f2 WHERE f1.user_from = f2.user_to AND f1.user_to=f2.user_from AND f1.user_to = :user)))
  GROUP BY message.id
  ORDER BY message.id DESC
  LIMIT :number, 20
SQL;

    $stmt = $this->dbAdapter->prepare($sql);
    $stmt->bindValue(':number', $number, \PDO::PARAM_INT);
    $stmt->bindValue(':user', $user, \PDO::PARAM_INT);
    $stmt->bindValue(':target', $target, \PDO::PARAM_INT);
    $stmt->execute();
    $msgs = [];
    foreach ($stmt->fetchAll() as $rawMessage) {
      $react =
        <<<SQL
          SELECT emoji, count(user) as nb, sum(reaction.user = :user) as react
          FROM reaction
          WHERE message = :msg
          GROUP BY emoji
SQL;
      $stmtreact = $this->dbAdapter->prepare($react);
      $stmtreact->bindValue(':user', $user, \PDO::PARAM_INT);
      $stmtreact->bindValue(':msg', $rawMessage['id'], \PDO::PARAM_INT);
      $stmtreact->execute();
      $rawMessage["reactions"] = [];
      foreach ($stmtreact->fetchAll() as $reaction) {
        $rawMessage["reactions"][$reaction["emoji"]]["nb"] = $reaction["nb"];
        $rawMessage["reactions"][$reaction["emoji"]]["react"] = $reaction["react"] == "1" ? true : false;
      }
      $msgs[] = $this->messageHydrator->hydrate($rawMessage);
    }
    return $msgs;
  }

  function lastGameMessages($user, $abrev, $number)
  {
    $sql =
      <<<SQL
  SELECT fullname FROM game WHERE abrev = :abrev
SQL;
    $stmt = $this->dbAdapter->prepare($sql);
    $stmt->bindValue(':abrev', $abrev, \PDO::PARAM_STR);
    $stmt->execute();
    $fullname = $stmt->fetch()["fullname"];

    $number *= 20;
    $sql =
      <<<SQL
  SELECT message.id, message.content, message.created_at, message.visibility, message.type, message.reply, user.id as userid, user.username, user.role, count(rep.id) as reply
  FROM message LEFT JOIN message AS rep ON rep.reply = message.id, user, hashtag
  WHERE message.user = user.id AND message.reply IS NULL
  AND message.id = hashtag.message
  AND (hashtag = :fullname OR hashtag = :abrev)
  AND (user.id = :user AND message.visibility != "deleted"
  OR (message.visibility = "unlisted" AND user.id IN (SELECT user_to FROM follow WHERE user_from = :user ))
  OR (message.visibility = "private" AND user.id IN (SELECT f1.user_from FROM follow as f1, follow as f2 WHERE f1.user_from = f2.user_to AND f1.user_to=f2.user_from AND f1.user_to = :user)))
  GROUP BY message.id
  ORDER BY message.id DESC
  LIMIT :number, 20
SQL;

    $stmt = $this->dbAdapter->prepare($sql);
    $stmt->bindValue(':number', $number, \PDO::PARAM_INT);
    $stmt->bindValue(':user', $user, \PDO::PARAM_INT);
    $stmt->bindValue(':abrev', $abrev, \PDO::PARAM_STR);
    $stmt->bindValue(':fullname', $fullname, \PDO::PARAM_STR);
    $stmt->execute();
    $msgs = [];
    foreach ($stmt->fetchAll() as $rawMessage) {
      $react =
        <<<SQL
          SELECT emoji, count(user) as nb, sum(reaction.user = :user) as react
          FROM reaction
          WHERE message = :msg
          GROUP BY emoji
SQL;
      $stmtreact = $this->dbAdapter->prepare($react);
      $stmtreact->bindValue(':user', $user, \PDO::PARAM_INT);
      $stmtreact->bindValue(':msg', $rawMessage['id'], \PDO::PARAM_INT);
      $stmtreact->execute();
      $rawMessage["reactions"] = [];
      foreach ($stmtreact->fetchAll() as $reaction) {
        $rawMessage["reactions"][$reaction["emoji"]]["nb"] = $reaction["nb"];
        $rawMessage["reactions"][$reaction["emoji"]]["react"] = $reaction["react"] == "1" ? true : false;
      }
      $msgs[] = $this->messageHydrator->hydrate($rawMessage);
    }
    return $msgs;
  }

  function postMessage($user, $content, $visibility, $type)
  {
    $sql =
      <<<SQL
  INSERT INTO `message` (`user`, `content`, `visibility`, `type`) VALUES (:user, :content, :visibility, :type);
  SELECT LAST_INSERT_ID();
SQL;

    $stmt = $this->dbAdapter->prepare($sql);
    $stmt->bindValue(':user', $user, \PDO::PARAM_INT);
    $stmt->bindValue(':content', $content, \PDO::PARAM_STR);
    $stmt->bindValue(':visibility', $visibility, \PDO::PARAM_STR);
    $stmt->bindValue(':type', $type, \PDO::PARAM_STR);
    $stmt->execute();

    $id = $this->dbAdapter->lastInsertId();
    preg_match_all('/#(\w|\p{So})+/u', $content, $matches);
    foreach ($matches[0] as $hashtag) {
      var_dump($hashtag);
      $sql_hs =
        <<<SQL
  INSERT INTO `hashtag` (`hashtag`, `message`) VALUES (:hashtag, :message);
SQL;
      $stmt = $this->dbAdapter->prepare($sql_hs);
      $stmt->bindValue(':hashtag', substr($hashtag, 1), \PDO::PARAM_STR);
      $stmt->bindValue(':message', $id, \PDO::PARAM_INT);
      $stmt->execute();
    }
  }

  function deleteMessage($id)
  {
    $sql =
      <<<SQL
  UPDATE `message` SET `visibility` = 'deleted' WHERE `message`.`id` = :id;
SQL;

    $stmt = $this->dbAdapter->prepare($sql);
    $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
    $stmt->execute();
  }
}
