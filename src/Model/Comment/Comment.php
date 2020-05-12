<?php

namespace Comment;

class Comment
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
    private $postId;

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
    public function getPostId ()
    {
        return $this->postId;
    }

    /**
     * @param int $postId
     */
    public function setPostId ($postId)
    {
        $this->postId = $postId;
        return $this;
    }
}