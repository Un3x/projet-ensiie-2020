<?php

namespace League;

class League
{
    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName ()
    {
        return $this->name;
    }
    
    /**
     * @param int $name
     */
    public function setName ($name)
    {
        $this->name = $name;
        return $this;
    }
}