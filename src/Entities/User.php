<?php

namespace User;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $username;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */	
    private $keyWords;

    /**
     * @var int
     */
    private $age;
    
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $fname;

    /**
     * @var string
     */
    private $pwd;

    /**
     * @var boolean
     */
    private $isAdmin;
    
    /**
     * @var int
     */
    private $reportCounter;

    /**
     * @var string
     */
    private $description;

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
    
    public function getAge ()
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge ($age)
    {
        $this->age = $age;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail ()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail ($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername ()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername ($username)
    {
        $this->username = $username;
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
     * @return string
     */
    public function getName ()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName ($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFname ()
    {
        return $this->fname;
    }

    /**
     * @param string $fname
     */
    public function setFname ($fname)
    {
        $this->fname = $fname;
        return $this;
    }

    /**
     * @return string
     */
     
    public function getKeywords ()
    {
        return $this->keyWords;
    }
    /**
     * @param string $keywords
     */
    public function setKeyWords ($keyWords)
    {
        $this->keyWords = $keyWords;
        return $this;
    }
}

