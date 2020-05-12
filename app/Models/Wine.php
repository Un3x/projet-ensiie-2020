<?php


namespace App\Models;


use App\Core\File;

/**
 * Class Wine
 * @package App\Models
 */
class Wine
{
    /**
     * @var int L'id du vin
     */
    private $id;
    /**
     * @var string Le nom du vin
     */
    private $name;
    /**
     * @var string La description du vin
     */
    private $description;
    /**
     * @var int L'id du type du vin
     */
    private $typeId;
    /**
     * @var int L'id du domaine du vin
     */
    private $domainId;
    /**
     * @var int L'id de l'année du vin
     */
    private $yearId;
    /**
     * @var int L'id du user qui a proposé le vin
     */
    private $proposedBy;
    /**
     * @var string Les tags du vin
     */
    private $tags;

    /**
     * Construit un Wine à partir d'une ligne de bdd
     *
     * @param $row
     * @return Wine
     */
    public static function fromDbRow($row){
        $res = new Wine();
        $res->setId($row['wid']);
        $res->setName($row['name']);
        $res->setDescription($row['description']);
        $res->setTags($row['tags']);
        $res->setProposedBy($row['proposed_by']);
        $res->setTypeId($row['tid']);
        $res->setDomainId($row['did']);
        $res->setYearId($row['yid']);
        return $res;
    }

    public function toDbRow(){
        $row = [];
        $row['name'] = $this->getName();
        $row['description'] = $this->getDescription();
        $row['tags'] = $this->getTags(false);
        $row['tid'] = $this->getTypeId();
        $row['did'] = $this->getDomainId();
        $row['yid'] = $this->getYearId();
        return $row;
    }

    /**
     * Récupère le chemin de l'image du vin
     *
     * @return string
     */
    public function getImagePath(){
        return self::getImagePathFromId($this->getId());
    }

    /**
     * Récupère le chemin de l'image du vin
     *
     * @param $id
     * @return string
     */
    public static function getImagePathFromId($id){
        $path = 'img/wines/' . $id . '.png';
        return File::exists(File::asset($path)) ? $path : 'img/wines/default.png';
    }

    /**
     * @return mixed
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Wine
     */
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Wine
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Wine
     */
    public function setDescription($description){
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeId(){
        return $this->typeId;
    }

    /**
     * @param mixed $typeId
     * @return Wine
     */
    public function setTypeId($typeId){
        $this->typeId = $typeId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDomainId(){
        return $this->domainId;
    }

    /**
     * @param mixed $domainId
     * @return Wine
     */
    public function setDomainId($domainId){
        $this->domainId = $domainId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getYearId(){
        return $this->yearId;
    }

    /**
     * @param mixed $yearId
     * @return Wine
     */
    public function setYearId($yearId){
        $this->yearId = $yearId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProposedBy(){
        return $this->proposedBy;
    }

    /**
     * @param mixed $proposedBy
     * @return Wine
     */
    public function setProposedBy($proposedBy){
        $this->proposedBy = $proposedBy;
        return $this;
    }

    /**
     * @param bool $array
     * @return mixed
     */
    public function getTags($array = true){
        return $array ? explode(',', $this->tags) : $this->tags;
    }

    /**
     * @param mixed $tags
     * @return Wine
     */
    public function setTags($tags){
        $this->tags = is_array($tags) ? implode(',', $tags) : $tags;
        return $this;
    }
}