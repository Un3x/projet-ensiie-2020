<?php

namespace App\Models;

use App\Core\File;
use DateTime;
use Exception;

/**
 * Class User
 * @package App\Models
 */
class User
{
    /**
     * Le role VIEWER (utilisateur simple)
     */
    const VIEWER_ROLE = 0b0000000001;
    /**
     * Le role ADMIN (utilisateur root)
     */
    const ADMIN_ROLE = 0b0000000010;

    /**
     * @var int L'id du user
     */
    private $id;

    /**
     * @var string Le pseudo du user
     */
    private $username;

    /**
     * @var string L'email du user
     */
    private $email;

    /**
     * @var string Le mot de passe hashé du user
     */
    private $hashedPwd;

    /**
     * @var DateTime La date de création du user
     */
    private $createdAt;

    /**
     * @var int Le role du user
     */
    private $role;

    /**
     * @var string La description du user
     */
    private $description;

    /**
     * User constructor.
     * @param null $email
     * @param null $username
     * @param null $hashedPwd
     * @param null $createdAt
     * @param null $id
     * @param int $role
     * @param null $description
     */
    public function __construct($email = null, $username = null, $hashedPwd = null, $createdAt = null, $id = null,
                                $role = 0x0, $description = null)
    {
        $this->setId($id);
        $this->setEmail($email);
        $this->setUsername($username);
        $this->setHashedPwd($hashedPwd);
        $this->setCreatedAt($createdAt);
        $this->setRole($role);
        $this->setDescription($description);
    }

    /**
     * Construit un User à partir d'une ligne de bdd
     *
     * @param $row
     * @return User
     * @throws Exception
     */
    public static function fromDbRow($row){
        $user = new User();
        $user
            ->setId($row['uid'])
            ->setUsername($row['username'])
            ->setEmail($row['email'])
            ->setCreatedAt(new DateTime($row['created_at']))
            ->setHashedPwd($row['pwd'])
            ->setRole((int) $row['role'])
            ->setDescription($row['description']);
        return $user;
    }

    // On évite de changer les champs "readonly"

    /**
     * Sérialize le user dans une ligne de bdd
     *
     * @return array
     */
    public function toDbRow(){
        $res = [];
        $res['username'] = $this->getUsername();
        $res['pwd'] = $this->getHashedPwd();
        $res['role'] = $this->getRoleString();
        $res['description'] = $this->getDescription();
        return $res;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return ucfirst($this->username);
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getHashedPwd(){
        return $this->hashedPwd;
    }

    /**
     * @param $pwd
     * @return $this
     */
    public function setHashedPwd($pwd){
        $this->hashedPwd = $pwd;
        return $this;
    }

    /**
     * Récupère le chemin de la photo de profil
     *
     * @return string
     */
    public function getPPPath(){
        return self::getPPPathFromId($this->getId());
    }

    /**
     * Récupère le chemin de la photo de profil
     *
     * @param $id
     * @return string
     */
    public static function getPPPathFromId($id){
        $path = 'img/users/pp/' . $id . '.jpg';
        return File::exists(File::asset($path)) ? $path : 'img/users/pp/default.jpg';
    }

    /**
     * Récupère le chemin de la bannière
     *
     * @return string
     */
    public function getBGPath(){
        return self::getBGPathFromId($this->getId());
    }

    /**
     * Récupère le chemin de la bannière
     *
     * @param $id
     * @return string
     */
    public static function getBGPathFromId($id){
        $path = 'img/users/bg/' . $id . '.jpg';
        return File::exists(File::asset($path)) ? $path : 'img/users/bg/default.jpg';
    }

    /**
     * @return int
     */
    public function getRole(){
        return $this->role;
    }

    /**
     * @return string
     */
    public function getRoleString(){
        return str_pad($this->role, 10, "0", STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function getRoleName(){
        $res = [];
        if($this->getRole() & self::VIEWER_ROLE){
            $res[] = "Utilisateur";
        }
        if($this->getRole() & self::ADMIN_ROLE){
            $res[] = "Administrateur";
        }

        return implode(" ; ", $res);
    }

    /**
     * @param $role
     * @return $this
     */
    public function setRole($role){
        $this->role = $role;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * @param $desc
     * @return $this
     */
    public function setDescription($desc){
        $this->description = $desc;
        return $this;
    }
}