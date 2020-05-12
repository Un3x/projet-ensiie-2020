<?php

namespace Rediite\Model\Entity;

class Ecrire {

    /**
     * @var int
     */
  private $n_pers;

    /**
     * @var int
     */
  private $n_mess;

    /**
     * @return mixed
     */
    public function getId ()
    {
        return $this->n_pers;
    }

     /**
     * @return mixed
     */
    public function getN_mess ()
    {
        return $this->n_mess;
    }

}