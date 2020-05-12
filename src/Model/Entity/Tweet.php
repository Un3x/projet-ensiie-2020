<?php

namespace Tweet;

class Tweet {
    /**
     * @var int
     */
    private $id_tweet;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $author;

    /**
     * @var \DateTime
     */
    private $date;

   /**
     * @var int
     */
    private $nblike;

    /**
     * @var bool
     */
    private $isAnswer;
    /**
     * @return int
     */
    public function getIdTweet ()
    {
        return $this->id_tweet;
    }

    /**
     * @param int $id
     */
    public function setIdTweet ($id)
    {
        $this->id_tweet = $id;
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
     * @return string
     */
    public function getAuthor ()
    {
        return $this->author;
    }

    /**
     * @param string $author_id
     */
    public function setAuthor ($author_name)
    {
        $this->author = $author_name;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate ()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsAnswer() 
    {
        return $this->isAnswer;
    }

    /**
     * @param bool $isAnswer
     */
    public function setIsAnswer($isAnswer)
    {
        $this->isAnswer = $isAnswer;
        return $this;
    }


    /**
     * @return int
     */
    public function getNbLike() 
    {
        return $this->nblike;
    }

    /**
     * @param int $nbLike
     */
    public function setNbLike($nbLike)
    {
        $this->nblike = $nbLike;
        return $this;
    }
}