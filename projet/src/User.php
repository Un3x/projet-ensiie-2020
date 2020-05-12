<?php

namespace User;

class User
{
    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $mail;
    
    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var boolean
     */
    private $banned;

    /**
     * @var TIMESTAMP
     */
    private $date_creation;

    public function getLastname ()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getFirstname ()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail ()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setEmail ($mail)
    {
        $this->mail = $mail;
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
     * @return boolean
     */
    public function getStatus ()
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     */
    public function setStatus ($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getBanned ()
    {
        return $this->banned;
    }

    /**
     * @param boolean $banned
     */
    public function setBanned ($banned)
    {
        $this->banned = $banned;
        return $this;
    }

    /**
     * @return TIMESTAMP
     */
    public function getCreatedAt ()
    {
        return $this->date_creation;
    }

    /**
     * @param TIMESTAMP $date_created
     */
    public function setCreatedAt ($date_creation)
    {
        $this->date_creation= $date_creation;
        return $this;
    }

    public function setPassword ($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword ()
    {
        return $this->password;
    }
    
}
