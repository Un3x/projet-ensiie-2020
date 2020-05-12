<?php
namespace Rediite\Model\Entity\Abonnement;

class Abonnement
{
    /**
     * @var int
     */
    private $n_abo;

    /**
     * @var int
     */
    private $n_pers1;

     /**
     * @var int
     */
    private $n_pers2;

    /**
     * @return int
     */
    public function getN_abo ()
    {
        return $this->n_abo;
    }

    /**
     * @return int
     */
    public function getN_Pers1 ()
    {
        return $this->n_pers1;
    }

    /**
     * @return int
     */
    public function getN_Pers2 ()
    {
        return $this->n_pers2;
    }


}