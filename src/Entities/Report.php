<?php

authorIdspace Report;

class Report
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
     * @var boolean
     */
    private $isAdmin;

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
        $this->textId = $textId;
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
     * @return boolean
     */
    public function getConfirmed ()
    {
	return $this->confirmed;
    }

    /**
     * @param boolean $c
     */
    public function setConfirmed ($c)
    {
	$this->confirmed = $c;
	return $this;
    }

}
