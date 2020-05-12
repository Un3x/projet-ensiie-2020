<?php

class Users
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $pseudo;

    /**
     * @var string
     */
    private $password;

    /**
     * @var boolean
     */
    private $suspendedAccount;

    /**
     * @var boolean
     */
    private $isAdmin;

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
    public function getPassword ()
    {
        return $this->password;
    }

    /**
     * @param string
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName ()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName ()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

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
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getSuspendedAccount ()
    {
        return $this->suspendedAccount;
    }

    /**
     * @param boolean
     */
    public function setSuspendedAccount($bool)
    {
        $this->suspendedAccount = $bool;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsAdmin ()
    {
        return $this->isAdmin;
    }

    /**
     * @param boolean
     */
    public function setIsAdmin($bool)
    {
        $this->isAdmin= $bool;
        return $this;
    }
}
