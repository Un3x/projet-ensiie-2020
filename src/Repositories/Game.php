<?php

namespace Game;

class Game
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $winner;

    /**
     * @var \DateTime
     */
    private $playedAt;

    /**
     * @var string
     */
    private $player;

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
    public function getWinner ()
    {
        return $this->winner;
    }

    /**
     * @param string $winner
     */
    public function setWinner ($winner)
    {
        $this->winner = $winner;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPlayedAt ()
    {
        return $this->playedAt;
    }

    /**
     * @param \DateTime $playedAt
     */
    public function setPlayedAt ($playedAt)
    {
        $this->playedAt = $playedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlayer ()
    {
        return $this->player;
    }

    /**
     * @param string $player1
     */
    public function setPlayer ($player)
    {
        $this->player = $player;
        return $this;
    }
}
