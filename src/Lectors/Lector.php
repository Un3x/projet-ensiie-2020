<?php

namespace Lector;

class Lector
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var int
     */
    private $port;

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
    public function getIP ()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIP ($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort ()
    {
        return $this->port;
    }

    /**
     * @param int $id
     */
    public function setPort ($port)
    {
        $this->port = $port;
        return $this;
    }
}
