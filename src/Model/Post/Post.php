<?php

namespace Post;

class Post
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $like_count;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var int
     */
    private $authorId;

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
    public function getContent ()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent ($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return int
     */
    public function getLikeCount()
    {
        return $this->like_count;
    }

    /**
     * @param string $content
     */
    public function setLikeCount($likes)
    {
        $this->like_count = $likes;
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
}