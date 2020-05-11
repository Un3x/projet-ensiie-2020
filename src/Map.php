<?php

namespace Map;

class Map
{
    /**
     * @var int
     */
    private $id_map;

    /**
     * @var string
     */
    private $meteo;

    /**
     * @var string
     */
    private $terrain;


    /**
     * @var int
     */
    private $vote;

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id_map;
    }

    /**
     * @param int $id
     */
    public function setId ($id)
    {
        $this->id_map = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getMeteo ()
    {
        return $this->meteo;
    }

    /**
     * @param string $meteo
     */
    public function setMeteo ($meteo)
    {
        $this->meteo = $meteo;
        return $this;
    }

    /**
     * @return string
     */
    public function getTerrain ()
    {
        return $this->terrain;
    }

    /**
     * @param string $terrain
     */
    public function setTerrain ($terrain)
    {
        $this->terrain = $terrain;
        return $this;
    }

     /**
     * @return int
     */
    public function getVote ()
    {
        return $this->vote;
    }

    /**
     * @param int $mdj
     */
    public function setVote ($vote)
    {
        $this->vote = $vote;
        return $this;
    }
}