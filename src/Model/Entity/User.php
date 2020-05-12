<?php

namespace User;

class User
{

    /**
     * @var string
     */
    private $username;

        /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;


    /**
     * @var \DateTime
     */
    private $createdAt;


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
    public function getPassword ()
    {
        return $this->password;
    }

    /**
     * @param @ string $password
     */
    public function setPassword ($password)
    {
        $this->password = $password;
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