<?php

namespace Message;

class Message
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var date
     */
    private $date;
    
    /**
     * @var string
     */
    private $emetteur;
    
    /**
     * @var string
     */
    private $recepteur;
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
    public function getContent ()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent ($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return date
     */
    public function getDate ()
    {
        return $this->date;
    }

    /**
     * @param date $date
     */
    public function setDate ($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmetteur ()
    {
        return $this->emetteur;
    }

    /**
     * @param string $string
     */
    public function setEmetteur ($emetteur)
    {
        $this->emetteur = $emetteur;
        return $this;
    }

    /**
     * @return string
     */
    public function getRecepteur ()
    {
        return $this->recepteur;
    }

    /**
     * @param string $recepteur
     */
    public function setRecepteur ($recepteur)
    {
        $this->recepteur = $recepteur;
        return $this;
    }
}
