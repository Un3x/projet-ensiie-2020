<?php

namespace Comment;

class Comment
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $storyId;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $text;

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
    public function getStoryId ()
    {
        return $this->storyId;
    }

    /**
     * @param string $storyId
     */
    public function setStoryId ($storyId)
    {
        $this->storyId = $storyId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser ()
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser ($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getText ()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText ($text)
    {
        $this->text = $text;
        return $this;
    }
}
