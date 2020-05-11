<?php

namespace Ingame;

class Ingame
{
     /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $pseudo;

    /**
     * @var int
     */
    private $team;

     /**
     * @var string
     */
    private $mdj;
    /**
     * @return int
     *
     */

      /**
     * @var int
     */
    private $voteautre;

    public function getId ()
    {
        return $this->id_game;
    }

    /**
     * @param int $id
     */
    public function setId ($id)
    {
        $this->id_game = $id;
        return $this;
    }

     /**
     * @return int
     */
    public function getTeam()
    {
        return $this->team;
    }

       /**
     * @param int $id
     */
    public function setTeam ($team)
    {
        $this->team = $team;
        return $this;
    }

      /**
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    
     /**
     * @param string $id
     */
    public function setPseudo ($pseudo)
    {
        $this->pseudo = $pseudo;
        return $this;
    }

      /**
     * @return string
     */
    public function getMdj()
    {
        return $this->mdj;
    }

    
     /**
     * @param string $id
     */
    public function setMdj ($mdj)
    {
        $this->mdj = $mdj;
        return $this;
    }
    

      /**
     * @return int
     */
    public function getVoteAutre()
    {
        return $this->voteautre;
    }

    
     /**
     * @param int $id
     */
    public function setVoteAutre ($vote)
    {
        $this->voteautre = $vote;
        return $this;
    }



  
}