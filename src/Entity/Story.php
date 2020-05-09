<?php

namespace Story;

class Story
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
    private $author;

    /**
     * @var string
     */
    private $summary;

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
    public function getAuthor ()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor ($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getSummary ()
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary ($summary)
    {
        $this->summary = $summary;
        return $this;
    }
}
