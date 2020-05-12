<?php

namespace Entity;

class Message
{
     /**
     * @var int
     */
    private $messageid;

     /**
     * @var string
     */
    private $content;

     /**
     * @var int
     */
    private $searchid;

     /**
     * @var string
     */
    private $emittor;

    /**
     * @var \DateTime
     */
    private $createdAt;


     /**
     * @return string
     */
    
     public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getMessageId()
    {
        return $this->messageid;
    }


        /**
     * @return int
     */
    public function getSearchId()
    {
        return $this->searchid;
    }

    /**
     * @return string
     */
    public function getEmittor()
    {
        return $this->emittor;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt ()
    {
        return $this->createdAt;
    }





    /**
     * @param int $i
     */
    public function setMessageId ($i)
    {
        $this->messageid = $i;
        return $this;
    }


    /**
     * @param int $id
     */
    public function setSearchId ($id)
    {
        $this->searchid = $id;
        return $this;
    }

    /**
     * @param string $name
     */
    public function setContent($message)
    {
        $this->content = $message;
        return $this;
    }

    /**
     * @param string $name
     */
    public function setEmittor($name)
    {
        $this->emittor = $name;
        return $this;
    }

     /**
     * @param string $name
     */
    public function setCreatedAt($name)
    {
        $this->createdAt = $name;
        return $this;
    }


}