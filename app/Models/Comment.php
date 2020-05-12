<?php


namespace App\Models;


use DateTime;
use Exception;

/**
 * Class Comment
 * @package App\Models
 */
class Comment
{
    /**
     * @var int L'id du commentaire
     */
    private $id;
    /**
     * @var int L'id du user qui a posté le commentaire
     */
    private $userId;
    /**
     * @var int L'id du win qui concerne le commentaire
     */
    private $wineId;
    /**
     * @var int L'id du domaine qui concerne le commentaire
     */
    private $domainId;
    /**
     * @var int L'id de l'année qui concerne le commentaire
     */
    private $yearId;

    /**
     * @var DateTime La date de post du commentaire
     */
    private $posted_at;

    /**
     * @var int L'id du type qui concerne le commentaire
     */
    private $typeId;
    /**
     * @var string Le texte du commentaire
     */
    private $msg;
    /**
     * @var int L'id du commentaire qui est le parent du commentaire actuel
     */
    private $in_response_toId;

    /**
     * Construit un commentaire à partir d'une ligne de bdd
     *
     * @param $row
     * @return Comment
     * @throws Exception
     */
    public static function fromDbRow($row){
        $com = new Comment();
        $com->setId($row['cid']);
        $com->setUser($row['uid']);
        $com->setWine($row['wid']);
        $com->setDomain($row['did']);
        $com->setYear($row['yid']);
        $com->setPostedAt(new DateTime($row['posted_at']));
        $com->setType($row['tid']);
        $com->setMsg($row['msg']);
        $com->setReplyTo($row['in_response_to']);
        return $com;
    }

    /**
     * Renvoie le commentaire dans un tableau pour le bdd
     * @return array
     */
    public function toDbRow(){
        $row = [];
        $row['tid'] = $this->getType();
        $row['msg'] = $this->getMsg();
        return $row;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setUser($id){
        $this->userId = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser(){
        return $this->userId;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setWine($id){
        $this->wineId = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWine(){
        return $this->wineId;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setDomain($id){
        $this->domainId = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDomain(){
        return $this->domainId;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setYear($id){
        $this->yearId = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getYear(){
        return $this->yearId;
    }

    /**
     * @param $posted
     * @return $this
     */
    public function setPostedAt($posted){
        $this->posted_at = $posted;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getPostedAt(){
        return $this->posted_at;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setType($id){
        $this->typeId = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType(){
        return $this->typeId;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param $msg
     * @return $this
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReplyTo()
    {
        return $this->in_response_toId;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setReplyTo($id)
    {
        $this->in_response_toId = $id;
        return $this;
    }
}