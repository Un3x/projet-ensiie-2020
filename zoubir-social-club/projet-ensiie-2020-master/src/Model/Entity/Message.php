<?php

namespace Rediite\Model\Entity;

class Message
{
    /**
     * @var int
     */
    private $n_mess;

    /* le int représentant l'écrivain */
    private $writer;

    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $parution;

    /**
     * @var int
     */
    private $nblikes;

    private $isComment;
    
    /**
     * @return int
     */
    public function getN_mess ()
    {
        return $this->n_mess;
    }

    /**
     * @param int $n_mess
     */
    public function setN_mess ($n_mess)
    {
        $this->n_mess = $n_mess;
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
     * @return \DateTime
     */
    public function getParution ()
    {
        return $this->parution;
    }

    /**
     * @param \DateTime $parution
     */
    public function setParution ($parution)
    {
        $this->parution = $parution;
        return $this;
    }


    public function getLikes()
    {
	return $this->nblikes;
    }

    public function setLikes($num)
    {
        $this->nblikes = $num;
        return $this;
    }
   public function IsComment()
   {
    return $this->isComment;
    
   }

   public function setComment($ind)
   {
     if($ind==1)
     {
	$this->isComment = 1;
     }
     else
     {
	$this->isComment = 0;
     }
     return $this;
   }

   public function getWriter()
   {
	return $this->writer;
   }

   public function setWriter($num)
   {
    $this->writer = $num;
    return $this;
   }
}
?>






