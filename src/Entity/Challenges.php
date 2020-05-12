<?php

class Challenges
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
     * @var int
     */
    private $difficultyLevel;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $sequenceNumber;

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName ($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getDifficultyLevel()
    {
        return $this->difficultyLevel;
    }

    /**
     * @param int $difficultyLevel
     */
    public function setDifficultyLevel($difficultyLevel)
    {
        $this->difficultyLevel = $difficultyLevel;
        return $this;
    }
    /**
     * @return int
     */
    public function getSequenceNumber()
    {
        return $this->sequenceNumber;
    }

    /**
     * @param int $sequenceNumber
     */
    public function setSequenceNumber($sequenceNumber)
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $name
     */
    public function setDescription ($description)
    {
        $this->description = $description;
        return $this;
    }


}
