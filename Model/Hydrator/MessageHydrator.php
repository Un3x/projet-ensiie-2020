<?php

namespace Model\Hydrator;

use Model\Entity\Message as MessageEntity;

class MessageHydrator {
  public function hydrate($data): MessageEntity
  {
    $topic = new MessageEntity();
    $topic
      ->setId($data['id'])
      ->setUser($data['userid'], $data['username'], $data['role'])
      ->setContent($data['content'])
      ->setCreation($data['created_at'])
      ->setVisibility($data['visibility'])
      ->setType($data['type'])
      ->setReply($data['reply'])
      ->setReactions($data['reactions']);
    return $topic;
  }
}