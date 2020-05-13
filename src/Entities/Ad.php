<?php

namespace Ad;

class Ad
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */	
    private $keyWords;

    /**
     * @var int
     */
    private $authorId;
    
    /**
     * @var int
     */
    private $likes;

    /**
     * @var int
     */
    private $reportCounter;

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
    public function getTitle ()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle ($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription ()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription ($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt ()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt ($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getAuthorId ()
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId ($authorId)
    {
        $this->authorId = $authorId;
        return $this;
    }

    /**
     * @return string
     */
    public function getKeyWords ()
    {
        return $this->keyWords;
    }

    /**
     * @param string $kw
     */
    public function setKeyWords ($kw)
    {
        $this->keyWords= $kw;
        return $this;
    }

    /**
     * @return int
     */
    public function getLikes ()
    {
        return $this->likes;
    }

    /**
     * @param int $likes
     */
    public function setLikes ($likes)
    {
        $this->likes= $likes;
        return $this;
    }

    /**
     * @return int 
     */
    public function getReportCounter ()
    {
	return $this->reportCounter;
    }

    /**
     * @param string $rc
     */
    public function setReportCounter ($rc)
    {
	$this->reportCounter = $rc;
	return $this;
    }
}
