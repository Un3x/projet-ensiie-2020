<?php

namespace Kara;

class Kara
{
    /**
     * @var int, should we use like a account name or something?
     */
    private $id;

    /**
     * @var string
     */
    private $string;

    /**
     * @var string, not constant
     */
    private $sourceName;


    /**
     * @var string, not constant
     */
    private $songName;


    /**
     * @var \DateTime
     */
    private $category;

    /**
     * @var int describing user rights
     * 	->will have to decide which number corresponds to which rights.
     */
    private $authorName;

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
    public function getString ()
    {
        return $this->string;
    }

    /**
     * @param int $id
     */
    public function setString ($string)
    {
        $this->string = $string;
        return $this;
    }

    /**
     * @return string
     */
    public function getSourceName ()
    {
        return $this->sourceName;
    }

    /**
     * @return \DateTime
     */
    public function getSongName ()
    {
        return $this->songName;
    }

    public function getCategory ()
    {
    	return $this->category;
    }

    public function getAuthorName ()
    {
    	return $this->authorName;
    }

}
