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
     * @var int describing user rights
     * 	->will have to decide which number corresponds to which rights.
     */
    private $songNumber;

    /**
     * @var int describing user rights
     * 	->will have to decide which number corresponds to which rights.
     */
    private $language;

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
     * @param
     */
    public function setSourceName ($sourceName)
    {
        $this->sourceName = $sourceName;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getSongName ()
    {
        return $this->songName;
    }

    /**
     * @param
     */
    public function setSongName ($songName)
    {
        $this->songName = $songName;
        return $this;
    }

    public function getCategory ()
    {
    	return $this->category;
    }

    /**
     * @param
     */
    public function setCategory ($category)
    {
        $this->category = $category;
        return $this;
    }

    public function getAuthorName ()
    {
    	return $this->authorName;
    }

    /**
     * @param
     */
    public function setAuthorName ($authorName)
    {
        $this->authorName = $authorName;
        return $this;
    }

    public function getSongNumber ()
    {
    	return $this->songNumber;
    }

    /**
     * @param
     */
    public function setSongNumber ($songNumber)
    {
        $this->songNumber = $songNumber;
        return $this;
    }

    public function getLanguage ()
    {
    	return $this->language;
    }

    /**
     * @param
     */
    public function setLanguage ($language)
    {
        $this->language = $language;
        return $this;
    }

}
