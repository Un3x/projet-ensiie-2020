<?php

namespace Rediite\Model\Entity;

class Liker {
    /**
     * @var int
     */
    private $n_mess;

    /**
     * @var int
     */
    private $n_pers;


    /**
     * @return int
     */
    public function getN_mess ()
    {
        return $this->n_mess;
    }

    /**
     * @return int
     */
    public function getN_pers ()
    {
        return $this->n_pers;
    }
}
?>