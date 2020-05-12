<?php

namespace Model\Hydrator;

use Model\Entity\Game as GameEntity;

class GameHydrator
{
  public function hydrate($data): GameEntity
  {
    $topic = new GameEntity();
    $topic
      ->setAbrev($data['abrev'])
      ->setFullname($data['fullname']);
    return $topic;
  }

  public function hydrateDetails($data): GameEntity
  {
    $topic = new GameEntity();
    $topic
      ->setAbrev($data['abrev'])
      ->setFullname($data['fullname'])
      ->setDescription($data['description'])
      ->setPlayers($data['players'])
      ->setNote($data['note'])
      ->setGenres($data['genres']);
    return $topic;
  }
}
