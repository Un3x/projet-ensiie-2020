<?php

namespace User;

class User
{
    /**
     * @var string
     */
    private $pseudo;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;

    /**
     * @var bool
     */
    private $administrator;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $team;

    /**
     * @return string
     */
    public function getPseudo ()
    {
        return $this->pseudo;
    }

    /**
     * @param string $pseudo
     */
    public function setPseudo ($pseudo)
    {
        $this->pseudo = $pseudo;
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
     * @param string $password
     */
    public function setPassword ($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return bool
     */
    public function getAdministrator ()
    {
        return $this->administrator;
    }

    /**
     * @param string $administrator
     */
    public function setAdministrator ($administrator)
    {
        $this->administrator = $administrator;
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

    /**
     * @return string
     */
    public function getTeam ()
    {
        return $this->team;
    }

    /**
     * @param string $team
     */
    public function setTeam ($team)
    {
        $this->team = $team;
        return $this;
    }
}