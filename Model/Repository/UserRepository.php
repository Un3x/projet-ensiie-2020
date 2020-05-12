<?php

namespace Model\Repository;

class UserRepository
{

  private $dbAdapter;
  private $userHydrator;

  public function __construct(
    \PDO $dbAdapter,
    \Model\Hydrator\UserHydrator $userHydrator
  ) {
    $this->dbAdapter = $dbAdapter;
    $this->userHydrator = $userHydrator;
  }

  function findUserById(int $id)
  {
    $sql =
      <<<SQL
  SELECT id, username, created_at, role FROM user WHERE id = :id
SQL;

    $stmt = $this->dbAdapter->prepare($sql);
    $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
    $stmt->execute();
    $rawUser = $stmt->fetch();
    return $rawUser ? $this->userHydrator->hydrate($rawUser) : null;
  }

  function findUserByUsername(string $username)
  {
    $sql =
      <<<SQL
  SELECT id, username, created_at, role FROM user WHERE username = :username
SQL;

    $users = [];
    $stmt = $this->dbAdapter->prepare($sql);
    $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
    $stmt->execute();
    foreach ($stmt->fetchAll() as $rawUser) {
      $users[] = $this->userHydrator->hydrate($rawUser);
    }
    return $users;
  }

  function createUser(string $username, string $password)
  {
    $sql =
      <<<SQL
  INSERT INTO `user`(`username`, `password`) VALUES (:username, :password)
SQL;

    $stmt = $this->dbAdapter->prepare($sql);
    $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
    $stmt->bindValue(':password', password_hash($password, PASSWORD_BCRYPT), \PDO::PARAM_STR);
    $stmt->execute();
    return $this->dbAdapter->lastInsertId();
  }

  function connect(string $username, string $password)
  {
    $sql =
      <<<SQL
  SELECT password FROM user WHERE username = :username
SQL;

    $stmt = $this->dbAdapter->prepare($sql);
    $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
    $stmt->execute();
    return password_verify($password, $stmt->fetch()['password']);
  }

  function lastUsers()
  {
    $sql =
      <<<SQL
SELECT id, username
FROM user
ORDER BY created_at DESC
LIMIT 20
SQL;

    $stmt = $this->dbAdapter->prepare($sql);
    $stmt->execute();
    $users = [];
    foreach ($stmt->fetchAll() as $rawUser) {
      $users[] = $this->userHydrator->hydrate($rawUser);
    }
    return $users;
  }

  function following($user)
  {
    $sql =
      <<<SQL
SELECT id, username
FROM follow JOIN user ON follow.user_to = user.id
WHERE follow.user_from = :user
LIMIT 20
SQL;

    $stmt = $this->dbAdapter->prepare($sql);
    $stmt->bindValue(':user', $user, \PDO::PARAM_INT);
    $stmt->execute();
    $users = [];
    foreach ($stmt->fetchAll() as $rawUser) {
      $users[] = $this->userHydrator->hydrate($rawUser);
    }
    return $users;
  }
}
