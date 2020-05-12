<?php

namespace Book;

class Book
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
     * @var boolean
     */
    private $borrowed;

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
    public function getAuteur ()
    {
        return $this->auteur;
    }

    /**
     * @param string $auteur
     */
    public function setAuteur ($auteur)
    {
        $this->auteur = $auteur;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitre ()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre ($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return string
     */
    public function getApercu(){
        return $this->apercu;
    }

    /**
     * @param string $apercu
     */
    public function setApercu ($apercu)
    {
        $this->apercu = $apercu;
        return $this;
    }

    /**
     * @return string
     */
    public function getSummary(){
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary ($summary)
    {
        $this->summary = $summary;
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
     * @return boolean
     */
    public function getBorrowed ()
    {
        return $this->borrowed;
    }

    /**
     * @param boolean $borrowed
     */
    public function setBorrowed ($borrowed)
    {
        $this->borrowed = $borrowed;
        return $this;
    }
    /**
     * @return boolean
     */
    public function getLikes ()
    {
        return $this->likes;
    }
    /**
     * @param string $summary
     */
    public function setLikes ($likes)
    {
        $this->likes = $likes;
        return $this;
    }
    /**
     * @return boolean
     */
    public function getDislikes ()
    {
        return $this->dislikes;
    }
    /**
     * @param string $summary
     */
    public function setDislikes ($dislikes)
    {
        $this->dislikes = $dislikes;
        return $this;
    }
}