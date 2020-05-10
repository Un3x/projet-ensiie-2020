<?php   

namespace Paris;

class Paris
{
    /**
     * @var int
     */
    private $id_paris;

    /**
     * @var int
     */
    private $player;

    /**
     * @var string
     */
    private $id_reu;

    /**
     * @var int
     */
    private $id_user;

    /**
     * @var TIME
     */
    private $retard;

    /**
     * @var int
     */
    private $mise;

    /**
     * @var TIMESTAMP
     */
    private $date_paris;

    /**
     * @return int
     */
    public function getIdParis ()
    {
        return $this->id_paris;
    }

    /**
     * @param int $id_paris
     */
    public function setIdParis ($id_paris)
    {
        $this->id_paris = $id_paris;
        return $this;
    }

    /**
     * @return int
     */
    public function getPlayer ()
    {
        return $this->player;
    }

    /**
     * @param int $id_paris
     */
    public function setPlayer ($player)
    {
        $this->player = $player;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdReu ()
    {
        return $this->id_reu;
    }

    /**
     * @param string $id_reu
     */
    public function setIdReu ($id_reu)
    {
        $this->id_reu = $id_reu;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdUser ()
    {
        return $this->id_user;
    }

    /**
     * @param int $id_user
     */
    public function setIdUser ($id_user)
    {
        $this->id_user = $id_user;
        return $this;
    }

    /**
     * @return TIME
     */
    public function getRetard ()
    {
        return $this->retard;
    }

    /**
     * @param TIME $retard
     */
    public function setRetard ($retard)
    {
        $this->retard = $retard;
        return $this;
    }

    /**
     * @return int
     */
    public function getMise ()
    {
        return $this->mise;
    }

    /**
     * @param int $mise
     */
    public function setMise ($mise)
    {
        $this->mise = $mise;
        return $this;
    }

    /**
     * @return int
     */
    public function getDateParis ()
    {
        return $this->date_paris;
    }

    /**
     * @param int $date_paris
     */
    public function setDateParis ($date_paris)
    {
        $this->date_paris = $date_paris;
        return $this;
    }
}