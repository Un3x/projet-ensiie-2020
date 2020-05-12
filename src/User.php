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
     * @param string $username
     */
    public function setPassword ($password)
    {
        $this->password = $password;
        return $this;
    }

}