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
     * @var string
     */
    private $slogan;

        /**
     * @var string
     */
    private $descript;

    /**
     * @var int
     */
    private $inactive;

    /**
     * @var \DateTime
     */
    private $createdAt;

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
     * @return string
     */
    public function getSlogan ()
    {
        return $this->slogan;
    }

    /**
     * @param string $slogan
     */
    public function setSlogan ($slogan)
    {
        $this->slogan = $slogan;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription ()
    {
        return $this->descript;
    }

    /**
     * @param string $description
     */
    public function setDescription ($descript)
    {
        $this->descript = $descript;
        return $this;
    }

    /**
     * @return int $active
     */
    public function getInactive()
    {
        return $this->inactive;
    }

    /**
     * @param int $active
     */
    public function setInactive($inactive)
    {
        $this->inactive=$inactive;
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
}