<?php

namespace Story;

class Page
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $choice1;
    
    /**
     * @var int
     */
    private $choice2;
    /**
     * @var int
     */
    private $choice3;
    
    /**
     * @var string
     */
    private $text1;

    /**
     * @var string
     */
    private $text2;

    /**
     * @var string
     */
    private $text3;

    /**
     * @var bool
     */
    private $first;

    /**
     * @var bool
     */
    private $last;

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
    public function getText ()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText ($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return int
     */
    public function getChoice1 ()
    {
        return $this->choice1;
    }

    /**
     * @param int $choice1
     */
    public function setChoice1 ($choice1)
    {
        $this->choice1 = $choice1;
        return $this;
    }

    /**
     * @return int
     */
    public function getChoice2 ()
    {
        return $this->choice2;
    }

    /**
     * @param int $choice2
     */
    public function setChoice2 ($choice2)
    {
        $this->choice2 = $choice2;
        return $this;
    }

    /**
     * @return int
     */
    public function getChoice3 ()
    {
        return $this->choice3;
    }

    /**
     * @param int $choice3
     */
    public function setChoice3 ($choice3)
    {
        $this->choice3 = $choice3;
        return $this;
    }

    /**
     * @return string
     */
    public function getText1 ()
    {
        return $this->text1;
    }

    /**
     * @param string $text1
     */
    public function setText1 ($text1)
    {
        $this->text1 = $text1;
        return $this;
    }

    /**
     * @return string
     */
    public function getText2 ()
    {
        return $this->text2;
    }

    /**
     * @param string $text2
     */
    public function setText2 ($text2)
    {
        $this->text2 = $text2;
        return $this;
    }

    /**
     * @return string
     */
    public function getText3 ()
    {
        return $this->text3;
    }

    /**
     * @param string $text3
     */
    public function setText3 ($text3)
    {
        $this->text3 = $text3;
        return $this;
    }

    /**
     * @return bool
     */
    public function getFirst ()
    {
        return $this->first;
    }

    /**
     * @param bool $first
     */
    public function setFirst ($first)
    {
        $this->first = $first;
        return $this;
    }

    /**
     * @return bool
     */
    public function getLast ()
    {
        return $this->last;
    }

    /**
     * @param bool $last
     */
    public function setLast ($last)
    {
        $this->last = $last;
        return $this;
    }
}
