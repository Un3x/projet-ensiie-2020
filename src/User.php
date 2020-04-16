<?php

namespace User;

class User
{
    /**
     * @var int, should we use like a account name or something?
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string, not constant
     */
    private $username;


    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var int describing user rights
     * 	->will have to decide which number corresponds to which rights.
     */
    private $rights;

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

    public function getRights ()
    {
    	return $this->rights;
    }

    public function setRights ($rights)
    {
    	$this->rights = $rights;
	return $this;
    }
}
