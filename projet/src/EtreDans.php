<?php

namespace EtreDans;

class EtreDans
{
    /**
     * @var int
     */
    private $numero;

    /**
     * @var int
     */
    private $id_liste;

     * @return int
     */
    public function getNumero ()
    {
        return $this->numero;
    }

    /**
     * @param int $numero
     */
    public function setNumero ($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdListe ()
    {
        return $this->id_liste;
    }
    
      /**
     * @param int $id_liste
     */
    public function setIdListe ($id_liste)
    {
        $this->id_liste = $id_liste;
        return $this;
    }
 
}