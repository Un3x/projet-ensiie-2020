<?php

namespace Entity;

class Game
{
     /**
     * @var int
     */
    private $id;

     /**
     * @var string
     */
    private $name;

     /**
     * @var bool
     */
    private $isFree;

     /**
     * @var string
     */
    private $description;

     /**
     * @return string
     */
    
     public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int $isFree
     */
    public function getIsFree()
    {
        return $this->isFree;
    }

    /**
     * @return int $isAccepted
     */
    public function getIsAccepted()
    {
        return $this->isAccepted;
    }




    /**
     * @param int $i
     */
    public function setIsAccepted ($i)
    {
        $this->isAccepted = $i;
        return $this;
    }


    /**
     * @param int $id
     */
    public function setId ($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param int $isFree
     */
    public function setIsFree($isFree)
    {
        $this->isFree = $isFree;
        return $this;
    }

    /**
     * @param string $description
     */

    public function setDescription($description){
        $this->description = $description;
        return $this;
    }
}