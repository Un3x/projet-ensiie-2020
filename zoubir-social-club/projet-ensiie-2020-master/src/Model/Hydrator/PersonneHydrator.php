<?php

namespace Rediite\Model\Hydrator;
error_reporting(E_ALL);
ini_set('display_errors', 1);

use \Rediite\Model\Entity\Personne as PersonneEntity;

class PersonneHydrator {
  public function hydrate($data): PersonneEntity
  {
    $personne = new PersonneEntity();
    $personne
      ->setId($data['n_pers'])
      ->setEmail($data['mail'])
      ->setPassword($data['password'])
      ->setName($data['nom'])
      ->setSurname($data['prenom'])
      ->setNickname($data['pseudo'])
      ->setCreationDate($data['d_inscri'])
      ->setCountry($data['pays'])
      ->setBirth($data['birth'])
      ->setAdmin($data['isadmin']);
    return $personne;
  }
}
