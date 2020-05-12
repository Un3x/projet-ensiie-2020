<?php


namespace Interest;

class Interest
{
    /**
     * @var string
     */
    private $theme;
    /**
     * @var int
     */
    private $subscribers;


    /**
     * @return int
     */
    public function getSubscribers()
    {
        return $this->subscribers;
    }
    /**
     * @param int $subscribers
     */
    public function setSubscribers($subscribers)
    {
        $this->subscribers = $subscribers;
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