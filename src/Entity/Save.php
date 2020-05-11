<?php

namespace Save;

class Save
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var int
     */
    private $storyId;

    /**
     * @var string
     */
    private $storyTitle;

    /**
     * @var int
     */
    private $pageId;

    /**
     * @var int
     */
    private $skill;

    /**
     * @var int
     */
    private $stamina;
    
    /**
     * @var int
     */
    private $luck;
    
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
     * @return int
     */
    public function getUserId ()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId ($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getStoryId ()
    {
        return $this->storyId;
    }

    /**
     * @param int $storyId
     */
    public function setStoryId ($storyId)
    {
        $this->storyId = $storyId;
        return $this;
    }

    /**
     * @return string
     */
    public function getStoryTitle ()
    {
        return $this->storyTitle;
    }

    /**
     * @param string $storyTitle
     */
    public function setStoryTitle ($storyTitle)
    {
        $this->storyTitle = $storyTitle;
        return $this;
    }

    /**
     * @return int
     */
    public function getPageId ()
    {
        return $this->pageId;
    }

    /**
     * @param int $pageId
     */
    public function setPageId ($pageId)
    {
        $this->pageId = $pageId;
        return $this;
    }

    /**
     * @return int
     */
    public function getSkill ()
    {
        return $this->skill;
    }

    /**
     * @param int $skill
     */
    public function setSkill ($skill)
    {
        $this->skill = $skill;
        return $this;
    }

    /**
     * @return int
     */
    public function getStamina ()
    {
        return $this->stamina;
    }

    /**
     * @param int $stamina
     */
    public function setStamina ($stamina)
    {
        $this->stamina = $stamina;
        return $this;
    }

    /**
     * @return int
     */
    public function getLuck ()
    {
        return $this->pageId;
    }

    /**
     * @param int $luck
     */
    public function setLuck ($luck)
    {
        $this->luck = $luck;
        return $this;
    }
}