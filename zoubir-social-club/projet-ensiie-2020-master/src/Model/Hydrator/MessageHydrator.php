<?php

namespace Rediite\Model\Hydrator;
error_reporting(E_ALL);
ini_set('display_errors', 1);

use \Rediite\Model\Entity\Message as MessageEntity;

class MessageHydrator {
  public function hydrate($data): MessageEntity
  {
    $message = new MessageEntity();
    /*$data['n_pers']*/
    $message
      ->setN_mess($data['n_mess'])
      ->setContent($data['content'])
      ->setParution($data['parution'])
      ->setLikes($data['nb_like'])
      ->setWriter($data['n_pers'])
      ->setComment($data['is_comment']);
    return $message;
  }
}
