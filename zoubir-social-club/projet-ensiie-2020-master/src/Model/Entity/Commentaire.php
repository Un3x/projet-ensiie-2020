<?php

namespace Rediite\Model\Entity;

class Commentaire {

    /**
     * @var int
     */
  private $n_comm;

    /**
     * @var int
     */
  private $n_mess;

    /**
     * @var string
     */
  private $content;

    /**
     * @return mixed
     */
    public function getN_Comm ()
    {
        return $this->n_pers;
    }

     /**
     * @return mixed
     */
    public function getN_mess ()
    {
        return $this->n_mess;
    }
     /**
     * @return mixed
     */
    public function getContent ()
    {
        return $this->content;
    }

     /**
     * @param mixed $contenu
     * @return Commentaire
     */
    public function getContent ($contenu)
    {
        this->content = $contenu;
	return $this;
    }
    
}