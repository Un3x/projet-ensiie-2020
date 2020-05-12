<?php

namespace Friendship;

class Friendship
{
    /**
     * @var int
     */
    private $idUser1;

    /**
     * @var int
     */
    private $idUser2;

    /**
     * @var int
     * 0 : friend request from user1 to user2
     * 1 : mutual friendship
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $statusDate;

    /**
     * @return int
     */
    public function getIdUser1 ()
    {
        return $this->idUser1;
    }

    /**
     * @param int $idUser1
     * @return \Friendship
     */
    public function setIdUser1 ($idUser1)
    {
        $this->idUser1 = $idUser1;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdUser2 ()
    {
        return $this->idUser2;
    }

    /**
     * @param int $idUser2
     * @return \Friendship
     */
    public function setIdUser2 ($idUser2)
    {
        $this->idUser2 = $idUser2;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus ()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return \Friendship
     */
    public function setStatus ($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStatusDate ()
    {
        return $this->statusDate;
    }

    /**
     * @param \DateTime $statusDate
     * @return \Friendship
     */
    public function setStatusDate ($statusDate)
    {
        $this->statusDate = $statusDate;
        return $this;
    }
}