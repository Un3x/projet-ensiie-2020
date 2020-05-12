<?php


namespace App\Models;


use Carbon\Carbon;

/**
 * Class LoggedUser
 * @package App\Models
 */
class LoggedUser extends User
{
    /**
     * La date de la dernière connexion
     * @var Carbon
     */
    private $lastLoggedTime;


    /**
     * Rempli le LoggedUser à partir d'un User
     * @param User $user
     */
    public function fromUser(User $user){
        $this->setId($user->getId());
        $this->setUsername($user->getUsername());
        $this->setEmail($user->getEmail());
        $this->setHashedPwd($user->getHashedPwd());
        $this->setCreatedAt($user->getCreatedAt());
        $this->setRole($user->getRole());
        $this->setDescription($user->getDescription());
    }

    /**
     * Définit la date de dernière connexion
     *
     * @param $last
     * @return $this
     */
    public function setLastLogged($last){
        $this->lastLoggedTime = $last;
        return $this;
    }

    /**
     * Renvoie la date de dernière connexion
     *
     * @return Carbon
     */
    public function getLastLogged(){
        return $this->lastLoggedTime;
    }
}