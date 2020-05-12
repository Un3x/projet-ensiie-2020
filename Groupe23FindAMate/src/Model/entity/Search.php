<?php

namespace Entity;

class Search
{
  

    private $id;
    /**
     * @var string
     */
    private $username;

    /**
     * @var \DateTime
     */
    private $createdAt;


      /**
     * @var int
     */
    private $playersToFind;

    /**
     * @var string
     */
    private $gameName;

    /**
     * @var string
     */
    private $title;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getId()
    {
        return $this->id;
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
    public function getGameName()
    {
        return $this->gameName;
    }

    /**
     * @param string $email
     */
    public function setGameName ($gameName)
    {
        $this->gameName = $gameName;
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

    public function setId($i)
    {
        $this->id=$i;
        return $this;
    }
    /**
     * @return int
     */

     public function getPlayersToFind() {
         return $this->playersToFind;
     }

    /**
     * @param int $playersToFind
     */

     public function setPlayersToFind($playersToFind){
         $this->playersToFind=$playersToFind;
         return $this;
     }

    /**
     * @return string 
     */
     public function getTitle() {
        return $this->title;
    }
    /**
     * @param string $title
     */

    public function setTitle($title){
        $this->title=$title;
        return $this;
    }


     
    
}

