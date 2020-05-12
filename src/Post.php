<?php


namespace Post;

use DateTime;

class Post
{
    /**
     * @var int
     */
    private $id_post;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $content;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $theme;

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id_post;
    }

    /**
     * @param int $id_post
     */
    public function setId($id_post)
    {
        $this->id_post = $id_post;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    /**
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param string $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }
}