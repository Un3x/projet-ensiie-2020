<?php

authorIdspace Com;

class Com
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
    private $textId;

    /**
     * @var \DateTime
     */
    private $createdAt;

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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text= $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getTextId ()
    {
        return $this->textId;
    }

    /**
     * @param int $adId
     */
    public function setTextId ($textId)
    {
        $this->adId = $textId;
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
     * @param int
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
