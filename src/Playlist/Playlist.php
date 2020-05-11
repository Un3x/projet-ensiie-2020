<?php

namespace Playlist;

class Playlist
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
     * @var string
     */
    private $creatorUsername;

    /**
     * @var int
     */
    private $creator;


    /**
     * @var string, not constant
     */
    private $content;


    /**
     * @var \DateTime
     */
    private $publik;


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
    public function getName ()
    {
        return $this->name;
    }

    /**
     * @param int $id
     */
    public function setName ($string)
    {
        $this->name = $string;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreator ()
    {
        return $this->creator;
    }

    /**
     * @param
     */
    public function setCreator ($creator)
    {
        $this->creator = $creator;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatorUsername ()
    {
        return $this->creatorUsername;
    }

    /**
     * @param
     */
    public function setCreatorUsername ($creator)
    {
        $this->creatorUsername = $creator;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getContent ()
    {
        return $this->content;
    }

    /**
     * @param
     */
    public function setContent ($content)
    {
        $this->content = $content;
        return $this;
    }

    public function getPublik ()
    {
    	return $this->publik;
    }

    /**
     * @param
     */
    public function setPublik ($public)
    {
        $this->publik = $public;
        return $this;
    }

}
