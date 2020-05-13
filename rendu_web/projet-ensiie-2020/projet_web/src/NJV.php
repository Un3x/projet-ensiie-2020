<?php

namespace NJV;

class NJV
{
    /**
     * @var int
     */
    private $edition;

    /**
     * @var \Date
     */
    private $jour;

    /**
     * @return int
     */
    public function getEdition ()
    {
        return $this->edition;
    }

    /**
     * @param int $edition
     */
    public function setEdition ($edition)
    {
        $this->edition = $edition;
        return $this;
    }

    /**
     * @return \Date
     */
    public function getJour ()
    {
        return $this->jour;
    }

    /**
     * @param \Date $jour
     */
    public function setJour ($jour)
    {
        $this->jour = $jour;
        return $this;
    }
}