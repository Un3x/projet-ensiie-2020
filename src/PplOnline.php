<?php

namespace PplOnline;

class PplOnline
{
    /**
     * @var bigint
     */
    private $ti;

    /**
     * @var string
     */
    private $ip;


    /**
     * @return int
     */
    public function getIp ()
    {
        return $this->ip;
    }

    /**
     * @param int $id
     */
    public function setIp ($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    public function getTime ()
    {
        return $this->ti;
    }

    public function setTime ($ti)
    {
        $this->ti = $ti;
        return $this;
    }
}