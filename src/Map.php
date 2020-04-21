<?php

namespace Map;

class Map
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $meteo;

    /**
     * @var string
     */
    private $terrain;

    /**
     * @var \DateTime
     */
    private $mdj;

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id_carte;
    }

    /**
     * @param int $id
     */
    public function setId ($id)
    {
        $this->id_carte = $id;
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
     * @return string
     */
    public function getMdj ()
    {
        return $this->mdj;
    }

    /**
     * @param \DateTime $mdj
     */
    public function setMdj ($mdj)
    {
        $this->mdj = $mdj;
        return $this;
    }
}