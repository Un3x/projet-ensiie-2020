<?php

namespace Model\Hydrator;

use Model\Entity\User as UserEntity;

class UserHydrator {
  public function hydrate($data): UserEntity
  {
    $topic = new UserEntity();
    $topic
      ->setId($data['id'])
      ->setUsername($data['username'])
      ->setCreation($data['created_at'])
      ->setRole($data['role'])
      ->setGamespseudo($data['gamespseudo']);
    return $topic;
  }
}