<?php


namespace App\Models;


use App\Core\File;

/**
 * Class Domain
 * @package App\Models
 */
class Domain
{
    /**
     * @var int L'id du domaine
     */
    private $id;
    /**
     * @var string Le nom du domaine
     */
    private $name;
    /**
     * @var string Les tags
     */
    private $tags;

    /**
     * Construit un domaine à partir d'une ligne de la bdd
     * @param $row
     * @return Domain
     */
    public static function fromDbRow($row){
        $domain = new Domain();
        $domain->setId($row['did']);
        $domain->setName($row['name']);
        $domain->setTags($row['tags']);
        return $domain;
    }

    /**
     * Renvoie le chemin de l'image du domaine
     * @return string
     */
    public function getImagePath(){
        return self::getImagePathFromId($this->getId());
    }

    /**
     * Renvoie le chemin de l'image du domaine
     *
     * @param $id
     * @return string
     */
    public static function getImagePathFromId($id){
        $path = 'img/domains/' . $id . '.jpg';
        return File::exists(File::asset($path)) ? $path : 'img/domains/default.jpg';
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Domain
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Domain
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return Domain
     */
    public function setTags($tags){
        $this->tags = is_array($tags) ? implode(',', $tags) : $tags;
        return $this;
    }
}